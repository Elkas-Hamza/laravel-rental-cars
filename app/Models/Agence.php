<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'adresse',
        'tele',
        'email',
        'temp_debut',
        'temp_fin'
    ];
}
