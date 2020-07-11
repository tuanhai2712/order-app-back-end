<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ten_san_pham = ['Giày', 'Quần', 'Áo', 'Xe', 'Bàn', 'Súng', 'Máy tính', 'Rượu', 'Rèm cửa', 'Đèn', 'Kẹo'];
        $link_san_pham = [
          'https://genk.vn/luc-nao-ngoi-tren-may-bay-la-nguy-hiem-nhat-cat-canh-ha-canh-hay-dang-o-tren-khong-20200521170530097.chn',
          'http://www.nettruyen.com/',
          'https://www.youtube.com/watch?v=F6M3FiaquVE',
          'https://topdev.vn/',
          'https://www.facebook.com/',
        ];
        $gia_thuc_te = [100, 200, 300, 400, 500];
        $gia_thuc_chi = [90, 190, 290, 390, 490];
        $phi_ship_tq = [5, 3, 1, 0];
        $phi_ship_vn = [15000, 5000, 4000, 10000, 0];
        $dat_coc = [10000, 20000, 30000, 400000];
        $ty_gia = [3400, 3500, 3600, 3300, 3200];
        $tinh_trang = [0, 1, 2, 3, 4, 5, 6, 7];
        for ($i=0; $i < 100 ; $i++) {
            $int= rand(1553391670, 1593398670);
            $data = [
              'user_id' => rand(1, 19),
              'ten_san_pham' => $ten_san_pham[array_rand($ten_san_pham, 1)],
              'link_san_pham' => $link_san_pham[array_rand($link_san_pham, 1)],
              'gia_thuc_te' => $gia_thuc_te[array_rand($gia_thuc_te, 1)],
              'gia_thuc_chi' => $gia_thuc_chi[array_rand($gia_thuc_chi, 1)],
              'phi_ship_tq' => $phi_ship_tq[array_rand($phi_ship_tq, 1)],
              'phi_ship_vn' => $phi_ship_vn[array_rand($phi_ship_vn, 1)],
              'dat_coc' => $dat_coc[array_rand($dat_coc, 1)],
              'ty_gia' => $ty_gia[array_rand($ty_gia, 1)],
              'tinh_trang' => $tinh_trang[array_rand($tinh_trang, 1)],
              'created_at' => date("Y-m-d H:i:s",$int),
            ];
            DB::table('orders')->insert($data);
        }
    }
}
