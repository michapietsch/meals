<?php

namespace App\Http\Controllers;

use App\Models\IngredientModel;
use App\Models\MealModel;
use App\Models\RecipeModel;

class MealDishIngredientController extends Controller
{
    public function destroy(MealModel $meal, string $type, int $id)
    {
        $meal->dishes = $meal->dishes()->reject(
            fn ($dish) => $dish->type === $type && $dish->id === $id
        );

        $meal->save();

        $composable = match($type) {
            'ingredient' => IngredientModel::find($id),
            'recipe' => RecipeModel::find($id),
        };

        if ($type === 'ingredient') {
            $composable->delete();
        }

        return redirect()->back();
    }
}
