<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; // <-- AGREGA ESTA LÍNEA

   protected $fillable = ['name', 'price', 'stock', 'description', 'image', 'category'];
}