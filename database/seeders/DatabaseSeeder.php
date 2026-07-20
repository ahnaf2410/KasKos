<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            RoomSeeder::class,
            RoomHistorySeeder::class,
            BillCategorySeeder::class,
            BillSeeder::class,
            PaymentSeeder::class,
            PersonalPaymentSeeder::class,
        ]);
    }
}

