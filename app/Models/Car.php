<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'marque',
        'model',
        'color',
        'fuel_type',
        'year',
        'prix_journalier',
        'disponible',
        'image',
        'description'
    ];

    /**
     * Get the reservations for the car.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
