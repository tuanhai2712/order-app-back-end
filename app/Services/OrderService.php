<?php
namespace App\Services;

use App\Interfaces\OrderServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Constants;
Use Carbon\Carbon;
use App\EloquentModels\Order;
use App\EloquentModels\Consignment;


class OrderService implements OrderServiceInterface
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
    public function getOrderCheck($conditions)
    {
        $page = $conditions['page'];
        $query = $this->makeQuery($conditions)
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('price_list', 'users.price_list', '=', 'price_list.id')
            ->select(
              'orders.*',
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
            )
            ->paginate(Constants::LIMIT_RECORD_PER_PAGE, ['*'], 'page', $page);
        return $query->toArray();
    }

    private function makeQuery($conditions)
    {
      $query = DB::table('orders')->orderBy('created_at', 'asc');
      if (isset($conditions['order_id'])) {
        $query->where('orders.id', $conditions['order_id']);
      }
      if (isset($conditions['role'])) {
        if ($conditions['role'] == Constants::USER_NORMAL_ROLE) {
          $query->where('user_id', $conditions['user_id']);
        }
        if ($conditions['role'] == Constants::USER_ADMIN_ROLE && isset($conditions['customer_id'])) {
          $query->where('user_id', $conditions['customer_id']);
        }
      }
      if (isset($conditions['tinh_trang']) && $conditions['tinh_trang'] != Constants::ALL_ORDER) {
        $query->where('tinh_trang', $conditions['tinh_trang']);
      }
      if (isset($conditions['ma_van_don'])) {
        $query->where('ma_van_don', $conditions['ma_van_don']);
      }
      if (isset($conditions['tu_ngay'])) {
        $query->where('created_at', '>=', Carbon::parse($conditions['tu_ngay'])->format("Y-m-d"));
      }
      if (isset($conditions['den_ngay'])) {
        $to = Carbon::parse($conditions['den_ngay'])->format("Y-m-d") . ' 23:59:59';
        $query->where('created_at', '<=', $to);
      }
      return $query;
    }

    public function create($data)
    {
      $userId = $data['user_id'];
      if ($data['role'] == Constants::USER_ADMIN_ROLE) {
        $userId = $data['customer_id'];
      }
      $id = DB::table('orders')->insertGetId([
        'link_san_pham' => $data['link'],
        'user_id' => $userId,
        'ty_gia' => $data['ty_gia'],
        'ten_san_pham' => $data['ten_san_pham'],
        'chuyen_nhanh' => $data['chuyen_nhanh'],
        'note' => $data['note'],
        'created_at' => Carbon::now(),
      ]);
      if (!$id) {
        return false;
      }
      if (isset($data['files'])) {
        $this->saveImage($data['files'], $id);
      }
      return true;
    }

    private function saveImage($images, $orderId)
    {
      foreach ($images as $image) {
        $file = Storage::disk('public')->put('', $image);
        $url = Storage::url($file);
        DB::table('images')->insert([
          'ma_don_hang' => $orderId,
          'url' => $url,
        ]);
      }
    }

    public function getImageOrder($orderId)
    {
      return DB::table('images')->where('ma_don_hang', $orderId)->get()->toArray();
    }

    public function updateOrder($data)
    {
      $oldOrders = DB::table('orders')->where('id', $data['id']);
      $dataUpdate = [];
      $dataUpdate['link_san_pham'] = $data['link_san_pham'];
      $dataUpdate['ten_san_pham'] = $data['ten_san_pham'];
      $dataUpdate['gia_thuc_chi'] = $data['gia_thuc_chi'];
      $dataUpdate['ma_van_don'] = $data['ma_van_don'];
      $dataUpdate['khoi_luong'] = $data['khoi_luong'];
      $dataUpdate['user_id'] = $data['user_id'];
      $dataUpdate['gia_thuc_te'] = $data['gia_thuc_te'];
      $dataUpdate['phi_ship_tq'] = $data['phi_ship_tq'];
      $dataUpdate['phi_ship_vn'] = $data['phi_ship_vn'];
      $dataUpdate['dat_coc'] = $data['dat_coc'];
      $dataUpdate['chuyen_nhanh'] = $data['chuyen_nhanh'];
      $dataUpdate['note'] = $data['note'];
      $dataUpdate['updated_at'] = Carbon::now();
      $updated = $oldOrders->update($dataUpdate);
      return $data;
    }

    public function confirmOrder($data)
    {
      $oldOrders = DB::table('orders')->where('id', $data['id']);
      $dataUpdate = [];
      $dataUpdate['tinh_trang'] = $data['tinh_trang'];
      $updated = $oldOrders->update($dataUpdate);
      return $data;
    }

    public function getOrderBeingTransportedStatus()
    {
      $orders = DB::table('orders')->where('tinh_trang', Constants::DEN_KHO_TQ)->get()->toArray();
      return $orders;
    }

    public function getConsignment()
    {
      $consignment = DB::table('consignment')->where('tinh_trang', Constants::KY_GUI_DEN_KHO_TQ)->get()->toArray();
      return $consignment;
    }

    public function checkBarcode($data)
    {
      if (count($data['confirmedOrder'])) {
        foreach ($data as $key => $value) {
          $order = DB::table('orders')->where('ma_van_don', $value['ma_van_don']);
          $dataUpdate = [];
          $dataUpdate['khoi_luong'] = $value['khoi_luong'];
          $dataUpdate['tinh_trang'] = Constants::DEN_KHO_VN;
          $dataUpdate['updated_at'] = Carbon::now();
          $updated = $order->update($dataUpdate);
        }
      }
      if (count($data['arrConsignment'])) {
        DB::table('consignment')->whereIn('ma_van_don', $data['arrConsignment'])->update(['tinh_trang' => 1]);
      }
      return [
        'code' => 200,
        'success' => true,
      ];
    }

    public function import($data, $type)
    {
        for ($i=1; $i < count($data); $i++) {
          if ($data[$i][0] === 0) {
            $row = $i + 1;
            return [
              "code" => 422,
              "success" => false,
              "message" => "",
              "data" => null,
              "error" => "Dòng ".$row.": Vui lòng kiểm tra lại mã vận đơn 0"
            ];
          }
            $order = Order::where('ma_van_don', $data[$i][0])->first();
            if ($order) {
              $status = Constants::DEN_KHO_TQ;
              if ($type === Constants::IMPORT_TYPE_DEN_KHO_VN) {
                $status = Constants::DEN_KHO_VN;
              } elseif ($type === Constants::IMPORT_TYPE_DA_TRA_HANG) {
                $status = Constants::DA_XONG;
              }
              $order->update([
                'tinh_trang' => $status,
                'khoi_luong' => $data[$i][1],
                'updated_at' => Carbon::now()
              ]);
            }
            if (!$order) {
              $consignment = Consignment::where('ma_van_don', $data[$i][0])->first();
              if (!$consignment) {
                DB::table('consignment')->insert(['ma_van_don' => $data[$i][0], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
              } else {
                $status = Constants::KY_GUI_DEN_KHO_VN;
                if ($type === Constants::IMPORT_TYPE_DA_TRA_HANG) {
                   $status = Constants::KY_GUI_DA_TRA_HANG;
                }
                $consignment->update([
                  'tinh_trang' => $status,
                  'updated_at' => Carbon::now()
                ]);
              }
            }
        }
        return [
          'code' => 200,
          'success' => true,
        ];
    }


    public function findWaybillCode($data)
    {
      if (!$data['search_type_goods']) {
        return DB::table('consignment')->where('ma_van_don', $data['waybill_code'])->first();
      }
      return DB::table('orders')->where('ma_van_don', $data['waybill_code'])->first();
    }
}
