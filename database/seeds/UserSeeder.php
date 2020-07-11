<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Tuấn Hải', 'Hương Trang', 'Thùy Linh', 'Tùng Lâm', 'Long'];
        $address = ['Lạng Sơn', 'Hà Nội', 'Cao Bằng', 'Bắc Cạn', 'Hồ Chí Mình'];
        $phoneNumber = ['0912312313', '012312879', '1230123102', '091283192', '0947271292'];
        for ($i=1; $i < 150 ; $i++) {
          $data = [
              'name' => $name[array_rand($name, 1)],
              'email' => 'test'.$i.'@gmail.com',
              'address' => $address[array_rand($address, 1)],
              'phone_number' => $phoneNumber[array_rand($phoneNumber, 1)],
              'role' => 1,
              'password' => bcrypt('12345678'),
              'price_list' => '1',
              'created_at' => new Datetime(),
          ];
          DB::table('users')->insert($data);
        }

        // $data = [
        //   'name' => 'Nguyễn Tuấn Hải',
        //   'email' => 'tuanhai2712@gmail.com',
        //   'address' => 'Thôn Hoàng Tân - Xã Hoàng Đồng - TP.Lạng Sơn',
        //   'phone_number' => '0947271292',
        //   'role' => 999,
        //   'password' => bcrypt('12345678'),
        //   'created_at' => new Datetime(),
        // ];
        // DB::table('users')->insert($data);
    }
}
