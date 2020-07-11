<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
          'price1' => '30000',
          'price2' => '28000',
          'price3' => '27000',
          'price4' => '26000',
          'created_at' => new Datetime(),
        ];
        DB::table('price_list')->insert($data);
    }
}
