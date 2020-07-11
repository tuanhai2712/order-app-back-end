<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'header_img' => null,
            'procedure_img' => null,
            'price_img' => null,
            'pay_img' => null,
            'about_us' => null,
            'exchange_rate' => null,
            'created_at' => new Datetime(),
        ];
        DB::table('settings')->insert($data);
    }
}
