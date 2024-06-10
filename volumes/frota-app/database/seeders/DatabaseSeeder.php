<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\PaymentDriver;
use App\Models\Settings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Settings::factory()->create([
            'percentageTaxIVA' => 6,
            'contabiServicelValue' => 200,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'roles' => ['user', "admin"],
            'password' => bcrypt('senha'),
        ]);

        $driver = \App\Models\User::factory()->create([
            'name' => fake()->name(),
            'roles' => ['user', 'driver'],
            'password' => bcrypt('senha'),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'IBAN' => fake()->iban(),
            'NIF' => fake()->numberBetween(100000000, 999999999),
            'hasCar' => false,
            'rentValue' => 250,
        ]);

        $driver->refundsIva()->create([
            'description' => 'Teste',
            'amount' => 100,
            'payment_date' => fake()->date,
            'ivaPercentage' => 6,
            'ivaRefund' => 6,
        ]);

        $driver2 = \App\Models\User::factory()->create([
            'name' => fake()->name(),
            'roles' => ['user', 'driver'],
            'password' => bcrypt('senha'),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'IBAN' => fake()->iban(),
            'NIF' => fake()->numberBetween(100000000, 999999999),
            'hasCar' => true,
            'rentValue' => 0,
        ]);

        $value = fake()->randomFloat(2, 450, 1000);

        $payment1 = PaymentDriver::factory()->create([
            'date' => fake()->date,
            'user_id' => $driver->id,
            'car_id' => Car::factory()->create()->id,
            'platform' => 'uber',
            'valueWeek' => $value,
            'taxPercentage' => 6,
            'taxValue' => $value * 0.06,
            'profitPercentage' => 100,
            'hasCar' => $driver->hasCar,
            'rentValue' => $driver->rentValue,
            'paymentMethod' => 'IBAN',
            'slotValue' => 0,
            'viaVerdeValue' => 20,
            'totalValue' => $value - ($value * 0.06) - $driver->rentValue - 20,
        ]);

        $payment1->closePayment();

        $value = fake()->randomFloat(2, 450, 1000);
        $payment2 = PaymentDriver::factory()->create([
            'date' => fake()->date,
            'user_id' => $driver2->id,
            'car_id' => Car::factory()->create()->id,
            'platform' => 'uber',
            'valueWeek' => $value,
            'taxPercentage' => 6,
            'taxValue' => $value * 0.06,
            'profitPercentage' => 100,
            'hasCar' => $driver2->hasCar,
            'rentValue' => $driver2->rentValue,
            'paymentMethod' => 'IBAN',
            'slotValue' => 0,
            'viaVerdeValue' => 20,
            'totalValue' => $value - ($value * 0.06) - $driver2->rentValue - 20,
        ]);

        $payment2->closePayment();

    }
}
