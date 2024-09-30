<?php

namespace App\Http\Controllers;

use App\Models\IngredientModel;
use App\Models\MealModel;
use App\Models\RecipeModel;
use App\Objects\Composable;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealDishesController extends Controller
{
    public function create(MealModel $meal)
    {
        return Inertia::render('Meals/Dishes/Create', [
            // 'meal' => new MealModel($meal),
            'ingredients' => IngredientModel::all()->mapInto(Composable::class),
            'recipes' => RecipeModel::all()->mapInto(Composable::class),
            'composables' => collect([
                ...IngredientModel::all()->mapInto(Composable::class),
                ...RecipeModel::all()->mapInto(Composable::class),
            ])
        ]);
    }

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
