<?php

namespace App\Http\Controllers;

use App\Models\CompositionModel;
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
        return Inertia::render('Meals/Composables/Create', [
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

        [ $id, $name, $amount, $unit ] = [$data['id'], $data['name'], $data['amount'], $data['unit']];

        match($data['type']) {
            'ingredient' => $meal->composeIngredient($id, $name, $amount, $unit),
            'recipe' => $meal->composeRecipe($id, $amount, $unit),
        };

        return redirect()->route('meals.show', $meal);
    }

    public function destroy(MealModel $meal, CompositionModel $dish)
    {
        $dish->delete();

        return redirect()->back();
    }
}
