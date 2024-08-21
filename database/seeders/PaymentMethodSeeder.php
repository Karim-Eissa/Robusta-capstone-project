<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        PaymentMethod::create(['name' => 'Credit Card']);
        PaymentMethod::create(['name' => 'PayPal']);
        PaymentMethod::create(['name' => 'Bank Transfer']);
    }
}
