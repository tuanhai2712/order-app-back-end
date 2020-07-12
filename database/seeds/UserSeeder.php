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
        $data = [
          'name' => 'Nguyễn Tuấn Hải',
          'email' => 'tuanhai2712@gmail.com',
          'address' => 'Thôn Hoàng Tân - Xã Hoàng Đồng - TP.Lạng Sơn',
          'phone_number' => '0947271292',
          'role' => 999,
          'password' => bcrypt('12345678'),
          'created_at' => new Datetime(),
        ];
        DB::table('users')->insert($data);
    }
}
