<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'marque' => 'Toyota',
                'model' => 'Camry',
                'color' => 'Silver',
                'fuel_type' => 'Gasoline',
                'year' => 2022,
                'prix_journalier' => 75.00,
                'disponible' => true,
                'image' => 'toyota-camry.jpg',
                'description' => 'Comfortable, reliable sedan with excellent fuel economy.',
            ],
            [
                'marque' => 'Honda',
                'model' => 'Civic',
                'color' => 'Blue',
                'fuel_type' => 'Gasoline',
                'year' => 2022,
                'prix_journalier' => 65.00,
                'disponible' => true,
                'image' => 'honda-civic.jpg',
                'description' => 'Compact sedan with great handling and fuel efficiency.',
            ],
            [
                'marque' => 'Ford',
                'model' => 'Mustang',
                'color' => 'Red',
                'fuel_type' => 'Gasoline',
                'year' => 2021,
                'prix_journalier' => 120.00,
                'disponible' => true,
                'image' => 'ford-mustang.jpg',
                'description' => 'Powerful American muscle car with iconic styling.',
            ],
            [
                'marque' => 'BMW',
                'model' => '3 Series',
                'color' => 'Black',
                'fuel_type' => 'Diesel',
                'year' => 2022,
                'prix_journalier' => 150.00,
                'disponible' => true,
                'image' => 'bmw-3series.jpg',
                'description' => 'Luxury sedan with exceptional performance and comfort.',
            ],
            [
                'marque' => 'Tesla',
                'model' => 'Model 3',
                'color' => 'White',
                'fuel_type' => 'Electric',
                'year' => 2022,
                'prix_journalier' => 180.00,
                'disponible' => true,
                'image' => 'tesla-model3.jpg',
                'description' => 'Zero emissions electric car with cutting-edge technology.',
            ],
            [
                'marque' => 'Jeep',
                'model' => 'Wrangler',
                'color' => 'Green',
                'fuel_type' => 'Gasoline',
                'year' => 2021,
                'prix_journalier' => 140.00,
                'disponible' => true,
                'image' => 'jeep-wrangler.jpg',
                'description' => 'Rugged off-road SUV built for adventure.',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
