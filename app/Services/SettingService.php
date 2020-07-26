<?php
namespace App\Services;

use App\Interfaces\SettingServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Constants;
Use Carbon\Carbon;


class SettingService implements SettingServiceInterface
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

    public function setting($data)
    {
      $currentSetting = DB::table('settings')->where('id', 1);
      $settingUpdate = [];
      if (isset($data['file'])) {
        $url = $this->saveImage($data['file']);
        $settingUpdate[$data['field']] = $url;
      }
      if (isset($data['exchange_rate'])) {
        $settingUpdate[$data['field']] = $data['exchange_rate'];
      }
      $currentSetting->update($settingUpdate);
      return $currentSetting->first();
    }

    private function saveImage($image)
    {
        $file = Storage::disk('public')->put('', $image);
        $url = Storage::url($file);
        return $url;
    }

    public function getSetting()
    {
      return DB::table('settings')->where('id', 1)->first();
    }


    public function getCustomers($role)
    {
      if ($role == Constants::USER_ADMIN_ROLE) {
        return DB::table('users')->where('role', '<>', $role)->get()->toArray();
      }
        return [];
    }

    public function getOverview($userId, $role)
    {
      if ($role == Constants::USER_ADMIN_ROLE) {
        $totalOrder = DB::table('orders')->count();
        $pendingOrder = DB::table('orders')->where('tinh_trang', Constants::DANG_CHO_XU_LY)->count();
        $successOrder = DB::table('orders')->where('tinh_trang', Constants::DA_XONG)->count();
        $newOrder = DB::table('orders')->where([
            ['tinh_trang', Constants::DANG_CHO_XU_LY],
            ['created_at','>',Carbon::now()->subDay()],
            ['created_at','<',Carbon::now()]
        ])->count();
        $totalUser =  DB::table('users')->where('role', Constants::USER_NORMAL_ROLE)->count();
        return [
            'totalOrder' => $totalOrder,
            'pendingOrder' => $pendingOrder,
            'successOrder' => $successOrder,
            'totalUser' => $totalUser,
            'newOrder' => $newOrder,
        ];
      }
      $totalOrder = DB::table('orders')->where('user_id', $userId)->count();
      $pendingOrder = DB::table('orders')->where([
          ['user_id', $userId],
          ['tinh_trang', Constants::DANG_CHO_XU_LY]
      ])->count();
      $successOrder = DB::table('orders')->where([
          ['user_id', $userId],
          ['tinh_trang', Constants::DA_XONG]
      ])->count();
      $newOrder = DB::table('orders')->where([
          ['user_id', $userId],
          ['tinh_trang', Constants::DANG_CHO_XU_LY],
          ['created_at','>',Carbon::now()->subDay()],
          ['created_at','<',Carbon::now()]
      ])->count();
      return [
          'totalOrder' => $totalOrder,
          'pendingOrder' => $pendingOrder,
          'newOrder' => $newOrder,
          'successOrder' => $successOrder,
      ];
    }
}
