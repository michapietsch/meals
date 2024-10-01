<?php

namespace App\Http\Controllers;

use App\Models\IngredientModel;
use App\Models\MealModel;
use App\Models\RecipeModel;

class RecipeComposablesController
{
    public function store(Request $request, MealModel $meal)
    {
        $data = $request->validate([
            'type' => 'required|string|in:ingredient,recipe',
            'id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
            'unit' => 'nullable|string|max:255',
        ]);

        if ($data['type'] === 'ingredient') {
            $composable =
                IngredientModel::firstOrCreate(
                    ['id' => $data['id']],
                    [
                        'name' => $data['name'],
                        'amount' => $data['amount'],
                        'unit' => $data['unit'],
                    ]
                );
        }

        if ($data['type'] === 'recipe') {
            $composable = RecipeModel::find($data['id']);
        }

        $meal->dishes = [...$meal->dishes, [
            'type' => $data['type'],
            'id' => $composable->id,
            'amount' => $data['amount'],
            'unit' => $data['unit'],
        ]];

        $meal->save();

        return redirect()->route('meals.show', $meal);
    }
}
