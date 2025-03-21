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
            'adresse' => 'Avenue Hassan II, Casablanca, Morocco',
            'tele' => '+212 52000123',
            'email' => 'contact@carrentalcenter.com',
            'temp_debut' => '08:00:00',
            'temp_fin' => '20:00:00',
        ]);
    }
}
