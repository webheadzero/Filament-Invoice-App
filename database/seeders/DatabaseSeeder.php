<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Setting;

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
            'email' => 'letsbakencook.finance@gmail.com',
        ], [
            'name' => 'Shierly Rusli',
            'phone' => '-',
            'address' => 'Ruko Alicante A28, Gading Serpong, Kab. Tangerang',
            'company_name' => 'Letsbakencook',
        ]);

        // Sample invoices
        $client = Client::where('email', 'letsbakencook.finance@gmail.com')->first();
        
        Invoice::firstOrCreate([
            'invoice_number' => 'INV-2024-0001',
        ], [
            'client_id' => $client->id,
            'invoice_date' => now(),
            'total_amount' => 1500000,
            'items' => [
                [
                    'description' => 'Website Development',
                    'quantity' => 1,
                    'unit_price' => 1500000,
                    'amount' => 1500000
                ]
            ]
        ]);

        Invoice::firstOrCreate([
            'invoice_number' => 'INV-2024-0002',
        ], [
            'client_id' => $client->id,
            'invoice_date' => now()->subDays(15),
            'total_amount' => 2500000,
            'items' => [
                [
                    'description' => 'Mobile App Development',
                    'quantity' => 1,
                    'unit_price' => 2500000,
                    'amount' => 2500000
                ]
            ]
        ]);

        // Settings
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Bima Setiaji L',
                'company_address' => "Notawang Raya A3 Wonotawang Bangunjiwo Kasihan Bantul",
                'bank_accounts' => [
                    [
                        'bank_name' => 'Bank Mandiri',
                        'account_number' => '1370007207042',
                        'account_name' => 'Bima Setiaji Laksana',
                    ],
                ],
            ]
        );
    }
}
