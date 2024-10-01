<?php

namespace Tests\Feature\Repositories;

use App\Models\CompositionModel;
use App\Models\IngredientModel;
use App\Models\RecipeModel;
use App\Objects\Ingredient;
use App\Objects\Recipe;
use App\Repositories\RecipesRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RecipesRepositoryTest extends TestCase
{
    #[Test]
    public function store_new_recipe()
    {
        $repository = new RecipesRepository();

        $composables = collect([
            new Ingredient(null, 'Ingredient 1', 100, 'g'),
        ]);

        $recipe = new Recipe(null, 'Recipe 1', $composables);

        $recipeModel = $repository->store($recipe);

        $this->assertSame('Recipe 1', $recipeModel->title);

        $ingredientModel = IngredientModel::sole();

        $this->assertSame('Ingredient 1', $ingredientModel->title);

        $this->assertDatabaseHas(
            'composition',
            [
                'parent_type' => 'recipe',
                'parent_id' => $recipeModel->id,
                'composable_type' => 'ingredient',
                'composable_id' => $ingredientModel->id,
                'amount' => 100,
                'unit' => 'g',
            ]
        );
    }

    #[Test]
    public function load_recipe()
    {
        $repository = new RecipesRepository();

        $recipeModel = RecipeModel::create([
            'title' => 'Recipe 1',
        ]);

        CompositionModel::create([
            'parent_type' => 'recipe',
            'parent_id' => $recipeModel->id,
            'composable_type' => 'ingredient',
            'composable_id' => IngredientModel::create([
                'title' => 'Ingredient 1',
            ])->id,
            'amount' => 100,
            'unit' => 'g',
        ]);

        $recipe = $repository->find($recipeModel->id);

        $this->assertSame('Recipe 1', $recipe->title);

        $this->assertCount(1, $recipe->composition);

        $this->assertSame('Ingredient 1', $recipe->composition->first()->title);
        $this->assertSame(100.0, $recipe->composition->first()->amount);
        $this->assertSame('g', $recipe->composition->first()->unit);
    }
}
