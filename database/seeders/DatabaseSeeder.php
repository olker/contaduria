<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Catálogo central del Plan de Cuentas 2026 (códigos y nombres literales del PDF).
        $this->call(PlanAccountsSeeder::class);

        // \App\Models\User::factory(10)->create();
    }
}
