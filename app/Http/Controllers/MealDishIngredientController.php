<?php

namespace App\Http\Controllers;

use App\Models\IngredientModel;
use App\Models\MealModel;

class MealDishIngredientController extends Controller
{
    public function destroy(MealModel $meal, IngredientModel $ingredient)
    {
        $meal->dishes = $meal->dishes()->reject(
            fn ($dish) => $dish->type === 'ingredient' && $dish->id === $ingredient->id
        );

        $meal->save();

        $ingredient->delete();

        return redirect()->back();
    }
}
