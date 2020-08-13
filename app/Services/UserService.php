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
        $query = $this->makeQuery($conditions)
            ->join('price_list', 'users.price_list', '=', 'price_list.id')
            ->select(
              'users.*',
              'price_list.freight_charges_ls_fast_20',
              'price_list.freight_charges_ls_slow_20',
              'price_list.freight_charges_ls_fast_20_100',
              'price_list.freight_charges_ls_slow_20_100',
              'price_list.freight_charges_ls_fast_100',
              'price_list.freight_charges_ls_slow_100',
              'price_list.freight_charges_hn_fast_100',
              'price_list.freight_charges_hn_slow_100',
              'price_list.freight_charges_hcm_fast_100',
              'price_list.freight_charges_hcm_slow_100'
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
          'freight_charges_ls_fast_20' => $data['freight_charges_ls_fast_20'],
          'freight_charges_ls_slow_20' => $data['freight_charges_ls_slow_20'],
          'freight_charges_ls_fast_20_100' => $data['freight_charges_ls_fast_20_100'],
          'freight_charges_ls_slow_20_100' => $data['freight_charges_ls_slow_20_100'],
          'freight_charges_ls_fast_100' => $data['freight_charges_ls_fast_100'],
          'freight_charges_ls_slow_100' => $data['freight_charges_ls_slow_100'],
          'freight_charges_hn_fast_100' => $data['freight_charges_hn_fast_100'],
          'freight_charges_hn_slow_100' => $data['freight_charges_hn_slow_100'],
          'freight_charges_hcm_fast_100' => $data['freight_charges_hcm_fast_100'],
          'freight_charges_hcm_slow_100' => $data['freight_charges_hcm_slow_100'],
          'updated_at' => Carbon::now()
        ]);
      } else {
        $priceListId = null;
        $findPriceList = DB::table('price_list')->where([
          ['freight_charges_ls_fast_20', $data['freight_charges_ls_fast_20']],
          ['freight_charges_ls_slow_20', $data['freight_charges_ls_slow_20']],
          ['freight_charges_ls_fast_20_100', $data['freight_charges_ls_fast_20_100']],
          ['freight_charges_ls_slow_20_100', $data['freight_charges_ls_slow_20_100']],
          ['freight_charges_ls_fast_100', $data['freight_charges_ls_fast_100']],
          ['freight_charges_ls_slow_100', $data['freight_charges_ls_slow_100']],
          ['freight_charges_hn_fast_100', $data['freight_charges_hn_fast_100']],
          ['freight_charges_hn_slow_100', $data['freight_charges_hn_slow_100']],
          ['freight_charges_hcm_fast_100', $data['freight_charges_hcm_fast_100']],
          ['freight_charges_hcm_slow_100', $data['freight_charges_hcm_slow_100']],
        ])->first();
        if (!$findPriceList) {
          $priceListId = DB::table('price_list')->insertGetId([
            'freight_charges_ls_fast_20' => $data['freight_charges_ls_fast_20'],
            'freight_charges_ls_slow_20' => $data['freight_charges_ls_slow_20'],
            'freight_charges_ls_fast_20_100' => $data['freight_charges_ls_fast_20_100'],
            'freight_charges_ls_slow_20_100' => $data['freight_charges_ls_slow_20_100'],
            'freight_charges_ls_fast_100' => $data['freight_charges_ls_fast_100'],
            'freight_charges_ls_slow_100' => $data['freight_charges_ls_slow_100'],
            'freight_charges_hn_fast_100' => $data['freight_charges_hn_fast_100'],
            'freight_charges_hn_slow_100' => $data['freight_charges_hn_slow_100'],
            'freight_charges_hcm_fast_100' => $data['freight_charges_hcm_fast_100'],
            'freight_charges_hcm_slow_100' => $data['freight_charges_hcm_slow_100'],
            'updated_at' => Carbon::now(),
          ]);
        } else {
          $priceListId = $findPriceList->id;
        }
        return DB::table('users')->where('id', $data['user_id'])->update(['price_list' => $priceListId]);
      }
    }
}
