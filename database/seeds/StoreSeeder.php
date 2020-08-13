<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
          [
              'store' => 'Lạng Sơn',
              'created_at' => new Datetime(),
          ],
          [
              'store' => 'Hà Nội',
              'created_at' => new Datetime(),
          ],
          [
              'store' => 'Hồ Chí Mình',
              'created_at' => new Datetime(),
          ],
        ];
        DB::table('stores')->insert($data);
    }
}
