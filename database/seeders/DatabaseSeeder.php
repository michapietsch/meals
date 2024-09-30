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

        $ingredientBowlOfCereals = IngredientModel::create([
            'name' => 'cereals',
            'unit' => 'small bowl',
            'amount' => 1,
        ]);

        $ingredientCoffee = IngredientModel::create([
            'name' => 'hot coffee',
            'unit' => 'cup',
            'amount' => 1,
        ]);

        $ingredientApple = IngredientModel::create([
            'name' => 'apple',
            'unit' => 'piece',
            'amount' => 1,
        ]);

        MealModel::create([
            'title' => 'Everyday Breakfast',
            'dishes' => [
                [
                    'type' => 'ingredient',
                    'id' => $ingredientBowlOfCereals->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => $ingredientCoffee->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => $ingredientApple->id,
                ],
            ],
        ]);

        RecipeModel::create([
            'title' => 'pizza dough',
            'ingredients' => [
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'name' => 'flour',
                        'unit' => 'g',
                        'amount' => 450,
                    ])->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'name' => 'water',
                        'unit' => 'ml',
                        'amount' => 250,
                    ])->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'name' => 'salt',
                        'unit' => 'teaspoon',
                        'amount' => 1,
                    ])->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'name' => 'olive oil',
                        'unit' => 'tablespoon',
                        'amount' => 3,
                    ])->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'name' => 'dry yeast',
                        'unit' => 'package',
                        'amount' => 1,
                    ])->id,
                ],
            ],
        ]);
    }
}
