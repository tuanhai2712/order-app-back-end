<?php
namespace App\Services;

use App\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Constants;
Use Carbon\Carbon;


class UserService implements UserServiceInterface
{
    /**
     * -----------------------------------------------------------------------------
     * sendMail
     * -----------------------------------------------------------------------------
     *
     * Action send email to user
     *
     * @param :
     *          + type: String
     *          + data: Array
     *          + to: String
     *          + cc: String
     *          + bcc: String
     *
     * @return :
     *          + Array response
     */
    public function getUser($conditions)
    {
        $page = $conditions['page'];
        $query = $this->makeQuery($conditions)->join('price_list', 'users.price_list', '=', 'price_list.id')
            ->select(
              'users.*',
              'price_list.price1',
              'price_list.price2',
              'price_list.price3',
              'price_list.price4'
            )->paginate(Constants::LIMIT_RECORD_PER_PAGE, ['*'], 'page', $page);
        return $query->toArray();
    }

    private function makeQuery($conditions)
    {
      $query = DB::table('users')->orderBy('created_at', 'asc');
      if (isset($conditions['name'])) {
        $query->where('name', 'like', '%'.$conditions['name'].'%');
      }
      if (isset($conditions['phone_number'])) {
        $query->where('phone_number', $conditions['phone_number']);
      }
      return $query;
    }

    public function updatePriceListForUser($data)
    {
      if ($data['role'] === Constants::USER_ADMIN_ROLE) {
        return DB::table('price_list')->where('id', 1)->update([
          'price1' => $data['price1'],
          'price2' => $data['price2'],
          'price3' => $data['price3'],
          'price4' => $data['price4'],
          'updated_at' => Carbon::now()
        ]);
      } else {
        $priceListId = null;
        $findPriceList = DB::table('price_list')->where([
          ['price1', $data['price1']],
          ['price2', $data['price2']],
          ['price3', $data['price3']],
          ['price4', $data['price4']]
        ])->first();
        if (!$findPriceList) {
          $priceListId = DB::table('price_list')->insertGetId([
            'price1' => $data['price1'],
            'price2' => $data['price2'],
            'price3' => $data['price3'],
            'price4' => $data['price4'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
          ]);
        } else {
          $priceListId = $findPriceList->id;
        }
        return DB::table('users')->where('id', $data['user_id'])->update(['price_list' => $priceListId]);
      }
    }
}
