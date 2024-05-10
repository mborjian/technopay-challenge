<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(10)->create(['type' => 'customer'])
            ->each(function ($user) {
                Order::factory(3)->create(['customer_id' => $user->id]);
            });

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
    }
}
