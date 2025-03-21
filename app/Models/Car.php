<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'color',
        'year',
        'category',
        'description',
        'price_per_day',
        'transmission',
        'seats',
        'fuel_type',
        'air_conditioner',
        'image',
        'status',
        'disponible'
    ];

    /**
     * Get the reservations for the car.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
