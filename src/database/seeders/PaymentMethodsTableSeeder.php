<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('payment_methods')->delete();

        DB::table('payment_methods')->insert([
            ['name' => 'カード払い'],
            ['name' => 'コンビニ払い'],
        ]);
       
    }
}
