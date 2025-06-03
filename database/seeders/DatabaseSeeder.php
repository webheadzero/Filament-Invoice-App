<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::firstOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Sample clients
        Client::firstOrCreate([
            'email' => 'client1@email.com',
        ], [
            'name' => 'PT. Satu Jaya',
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 1, Jakarta',
            'company_name' => 'PT. Satu Jaya',
            'tax_number' => '01.234.567.8-999.000',
        ]);
        Client::firstOrCreate([
            'email' => 'client2@email.com',
        ], [
            'name' => 'CV. Dua Makmur',
            'phone' => '082345678901',
            'address' => 'Jl. Melati No. 2, Bandung',
            'company_name' => 'CV. Dua Makmur',
            'tax_number' => '02.345.678.9-888.000',
        ]);
    }
}
