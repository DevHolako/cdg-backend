<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Acte;
use App\Models\Doc;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'nomComplete' => 'Marouane Rguibi',
            'login' => 'godhimself',
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "isAdmin" => true
        ]);
        User::create([
            'nomComplete' => 'Rguibi Maroaune',
            'login' => 'holako',
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "isAdmin" => false
        ]);

        Doc::factory()->count(3)->create();
        Acte::factory()->count(60)->create();
    }
}
