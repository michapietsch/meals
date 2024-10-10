<?php

namespace App\Models;

use App\Objects\ComposableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientModel extends Model implements ComposableInterface
{
    use HasFactory;

    protected $table = 'ingredients';

    protected $guarded = [];
}
