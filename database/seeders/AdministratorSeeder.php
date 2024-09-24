<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrator::factory([
            'email' => 'administrator@demo.com',
            'password' => \Hash::make('secret123')
        ])->count(1)->create();
    }
}
