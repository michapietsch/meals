<?php

namespace Database\Seeders;

use App\Models\IngredientModel;
use App\Models\MealModel;
use App\Models\RecipeModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $meal = MealModel::create([ 'title' => 'Everyday Breakfast' ]);

        $meal->composeIngredient(null, 'cereals', 1, 'small bowl');
        $meal->composeIngredient(null, 'hot coffee', 1, 'cup');
        $meal->composeIngredient(null, 'apple', 1);

        $recipe = RecipeModel::create([ 'title' => 'pizza dough' ]);

        $recipe->composeIngredient(null, 'flour', 450, 'g');
        $recipe->composeIngredient(null, 'water', 250, 'ml');
        $recipe->composeIngredient(null, 'salt', 1, 'teaspoon');
        $recipe->composeIngredient(null, 'olive oil', 3, 'tablespoon');
        $recipe->composeIngredient(null, 'dry yeast', 1, 'package');

        RecipeModel::create([ 'title' => 'peperoni pizza' ]);
    }
}
