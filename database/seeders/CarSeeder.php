<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First clear the cars table
        DB::table('cars')->truncate();

        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'color' => 'Silver',
                'year' => 2022,
                'category' => 'Sedan',
                'description' => 'Comfortable, reliable sedan with excellent fuel economy.',
                'price_per_day' => 75.00,
                'transmission' => 'automatic',
                'seats' => 5,
                'fuel_type' => 'Gasoline',
                'air_conditioner' => true,
                'license_plate' => 'ArtC123',
                'image' => 'images/camry/2021-toyota-camry-hybrid-xle-121-1603151471.jpg',
                'images' => json_encode([
                    'images/camry/2021-toyota-camry-hybrid-xle-121-1603151471.jpg',
                    'images/camry/2021-toyota-camry-hybrid-xle-124-1603151475.jpg',
                    'images/camry/2021-toyota-camry-hybrid-xle-125-1603151475.jpg',
                    'images/camry/2021-toyota-camry-hybrid-xle-127-1603151478.jpg',
                    'images/camry/2021-toyota-camry-hybrid-xle-132-1603151481.jpg'
                ]),
                'status' => 'available',
                'disponible' => true,
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'color' => 'Blue',
                'year' => 2022,
                'category' => 'Compact',
                'description' => 'Compact sedan with great handling and fuel efficiency.',
                'price_per_day' => 65.00,
                'transmission' => 'automatic',
                'seats' => 5,
                'fuel_type' => 'Gasoline',
                'air_conditioner' => true,
                'license_plate' => 'ABC123',
                'image' => 'images/civic/2022-honda-civic-sedan-110-1623810388.jpg',
                'images' => json_encode([
                    'images/civic/2022-honda-civic-sedan-110-1623810388.jpg',
                    'images/civic/2022-honda-civic-sedan-112-1623810389.jpg',
                    'images/civic/2022-honda-civic-sedan-113-1623810389.jpg'
                ]),
                'status' => 'available',
                'disponible' => true,
            ],
            [
                'brand' => 'Ford',
                'model' => 'Mustang',
                'color' => 'Red',
                'year' => 2021,
                'category' => 'Sports',
                'description' => 'Powerful American muscle car with iconic styling.',
                'price_per_day' => 120.00,
                'transmission' => 'automatic',
                'seats' => 4,
                'fuel_type' => 'Gasoline',
                'air_conditioner' => true,
                'license_plate' => 'XYZ789',
                'image' => 'images/mustang/2021-ford-mustang-mach-1-109-1592231891.jpg',
                'images' => json_encode([
                    'images/mustang/2021-ford-mustang-mach-1-109-1592231891.jpg',
                    'images/mustang/2021-ford-mustang-mach-1-110-1592231892.jpg',
                    'images/mustang/2021-ford-mustang-mach-1-112-1592231893.jpg'
                ]),
                'status' => 'available',
                'disponible' => true,
            ],
            [
                'brand' => 'BMW 3 Series',
                'model' => '330e',
                'color' => 'Black',
                'year' => 2022,
                'category' => 'Luxury',
                'description' => 'Luxurious sedan with powerful performance and premium features.',
                'price_per_day' => 150.00,
                'transmission' => 'automatic',
                'seats' => 5,
                'fuel_type' => 'Hybrid',
                'air_conditioner' => true,
                'license_plate' => 'DEF456',
                'image' => 'images/3series/2020-bmw-330e-101-1565802976.jpg',
                'images' => json_encode([
                    'images/3series/2020-bmw-330e-101-1565802976.jpg',
                    'images/3series/2020-bmw-330e-102-1565802977.jpg',
                    'images/3series/2020-bmw-330e-109-1565802977.jpg',
                    'images/3series/2020-bmw-330e-111-1565802979.jpg'
                ]),
                'status' => 'available',
                'disponible' => true,
            ],
            [
                'brand' => 'Tesla',
                'model' => 'Model 3',
                'color' => 'White',
                'year' => 2022,
                'category' => 'Sedan',
                'description' => 'Zero emissions electric car with cutting-edge technology.',
                'price_per_day' => 180.00,
                'transmission' => 'automatic',
                'seats' => 5,
                'fuel_type' => 'Electric',
                'air_conditioner' => true,
                'license_plate' => 'GHI789',
                'image' => 'images/model3/2019-tesla-model-3-dual-motor-ltwrap-simari-883-1651164161.jpg',
                'images' => json_encode([
                    'images/model3/2019-tesla-model-3-dual-motor-ltwrap-simari-883-1651164161.jpg',
                    'images/model3/2019-tesla-model-3-dual-motor-ltwrap-simari-895-1651164161.jpg',
                    'images/model3/2019-tesla-model-3-dual-motor-ltwrap-simari-896-1651164164.jpg'
                ]),
                'status' => 'available',
                'disponible' => true,
            ],
            [
                'brand' => 'Jeep',
                'model' => 'Wrangler',
                'color' => 'Green',
                'year' => 2021,
                'category' => 'SUV',
                'description' => 'Rugged off-road SUV built for adventure.',
                'price_per_day' => 140.00,
                'transmission' => 'manual',
                'seats' => 4,
                'fuel_type' => 'Gasoline',
                'air_conditioner' => false,
                'license_plate' => 'JKL012',
                'image' => 'images/wrangler/2018-jeep-jl-wrangler-sport-102-1525800589.jpg',
                'images' => json_encode([
                    'images/wrangler/2018-jeep-jl-wrangler-sport-102-1525800589.jpg',
                    'images/wrangler/2018-jeep-jl-wrangler-sport-103-1525800589.jpg',
                    'images/wrangler/2018-jeep-jl-wrangler-sport-106-1525800589.jpg'
                ]),
                'status' => 'available',
                'disponible' => true,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
