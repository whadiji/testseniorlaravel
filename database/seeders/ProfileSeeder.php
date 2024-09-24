<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = Administrator::first();
        Profile::factory([
            'administrator_id' => $administrator->id
        ])->count(20)->create();
    }
}
