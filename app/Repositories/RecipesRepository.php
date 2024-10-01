<?php

namespace App\Repositories;

use App\Models\CompositionModel;
use App\Models\IngredientModel;
use App\Models\RecipeModel;
use App\Objects\Ingredient;
use App\Objects\Recipe;

class RecipesRepository
{
    public function store(Recipe $recipe): RecipeModel
    {
        $recipeModel = RecipeModel::create([
            'title' => $recipe->title,
        ]);

        $recipe->composition->each(
            fn ($composable) =>
                match(get_class($composable)) {
                    Ingredient::class =>
                        CompositionModel::create([
                            'parent_type' => 'recipe',
                            'parent_id' => $recipeModel->id,
                            'composable_type' => 'ingredient',
                            'composable_id' => IngredientModel::create([
                                'title' => $composable->title,
                            ])->id,
                            'amount' => $composable->amount,
                            'unit' => $composable->unit,
                        ]),
                }
        );

        return $recipeModel;
    }

    public function find(int $id): Recipe
    {
        return Recipe::fromModel(RecipeModel::find($id));
    }
}
