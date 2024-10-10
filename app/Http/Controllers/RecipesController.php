<?php

namespace App\Http\Controllers;

use App\Models\RecipeModel;
use Inertia\Inertia;

class RecipesController extends Controller
{
    public function show(RecipeModel $recipe)
    {
        return Inertia::render('Recipes/Recipe', [
            'recipe' => $recipe->load('composition.composable'),
        ]);
    }
}
