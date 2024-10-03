<?php

namespace App\Http\Controllers;

use App\Models\CompositionModel;
use App\Models\IngredientModel;
use App\Models\RecipeModel;
use App\Objects\Composable;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipeComposablesController
{
    public function create(RecipeModel $recipe)
    {
        return Inertia::render('Recipes/Composables/Create', [
            'composables' => collect([
                ...IngredientModel::all()->mapInto(Composable::class),
                ...RecipeModel::all()->mapInto(Composable::class),
            ])
        ]);
    }

    public function store(Request $request, RecipeModel $recipe)
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
            'ingredient' => $recipe->composeIngredient($id, $name, $amount, $unit),
            'recipe' => $recipe->composeRecipe($id, $amount, $unit),
        };

        return redirect()->route('recipes.show', $recipe);
    }

    public function destroy(RecipeModel $recipe, CompositionModel $composable)
    {
        $composable->delete();

        return redirect()->back();
    }
}
