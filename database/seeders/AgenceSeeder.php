<?php

namespace Database\Seeders;

use App\Models\Agence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agence::create([
            'name' => 'Car Rental Center',
            'adresse' => '123 Main Street, New York, NY 10001',
            'tele' => '+1 (555) 123-4567',
            'email' => 'contact@carrentalcenter.com',
            'temp_debut' => '08:00:00',
            'temp_fin' => '20:00:00',
        ]);
    }
}
