<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Rekening Bank
        PaymentMethod::create([
            'type' => 'bank',
            'name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => 'Angkringan Modern',
            'is_active' => true
        ]);

        PaymentMethod::create([
            'type' => 'bank',
            'name' => 'Mandiri',
            'account_number' => '0987654321',
            'account_holder' => 'Angkringan Modern',
            'is_active' => true
        ]);

        PaymentMethod::create([
            'type' => 'bank',
            'name' => 'BRI',
            'account_number' => '5555666677',
            'account_holder' => 'Angkringan Modern',
            'is_active' => true
        ]);

        // E-Wallet
        PaymentMethod::create([
            'type' => 'ewallet',
            'name' => 'GoPay',
            'account_number' => '081234567890',
            'account_holder' => 'Angkringan cakra',
            'is_active' => true
        ]);

        PaymentMethod::create([
            'type' => 'ewallet',
            'name' => 'OVO',
            'account_number' => '081234567890',
            'account_holder' => 'Angkringan Modern',
            'is_active' => true
        ]);

        PaymentMethod::create([
            'type' => 'ewallet',
            'name' => 'Dana',
            'account_number' => '081234567890',
            'account_holder' => 'Angkringan Cakra',
            'is_active' => true
        ]);
    }
}
