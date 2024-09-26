<?php

namespace App\Models;

use App\Objects\Dish;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MealModel extends Model
{
    use HasFactory;

    protected $table = 'meals';

    protected $casts = [
        'dishes' => 'array',
    ];

    public function dishes(): Collection
    {
        $ingredients = IngredientModel::whereIn('id', collect($this->dishes)->pluck('id'))->get();

        return collect($this->dishes)->map(function ($dish) use ($ingredients) {
            return new Dish($ingredients->find($dish['id']));
        });
    }
}
