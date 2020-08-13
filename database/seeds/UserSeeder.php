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
          'name' => 'Triệu Thùy Dung',
          'email' => 'vanchuyen3mien@gmail.com',
          'address' => 'Số 76 - Đường Hồ Tùng Mậu - TP. Lạng Sơn',
          'phone_number' => '0973191282',
          'role' => 999,
          'password' => bcrypt('12345678'),
          'created_at' => new Datetime(),
        ];
        DB::table('users')->insert($data);
    }
}
