<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientModel extends Model
{
    use HasFactory;

    protected $table = 'ingredients';

    protected $guarded = [];
}
