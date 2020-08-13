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
          'freight_charges_ls_fast_20' => 38000,
          'freight_charges_ls_slow_20' => 32000,
          'freight_charges_ls_fast_20_100' => 36000,
          'freight_charges_ls_slow_20_100' => 30000,
          'freight_charges_ls_fast_100' => 35000,
          'freight_charges_ls_slow_100' => 28000,
          'freight_charges_hn_fast_100' => 39000,
          'freight_charges_hn_slow_100' => 28000,
          'freight_charges_hcm_fast_100' => 48000,
          'freight_charges_hcm_slow_100' => 40000,
          'created_at' => new Datetime(),
        ];
        DB::table('price_list')->insert($data);
    }
}
