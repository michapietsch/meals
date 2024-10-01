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
            'title' => 'cereals',
            'unit' => 'small bowl',
            'amount' => 1,
        ]);

        $ingredientCoffee = IngredientModel::create([
            'title' => 'hot coffee',
            'unit' => 'cup',
            'amount' => 1,
        ]);

        $ingredientApple = IngredientModel::create([
            'title' => 'apple',
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
                        'title' => 'flour',
                        'unit' => 'g',
                        'amount' => 450,
                    ])->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'title' => 'water',
                        'unit' => 'ml',
                        'amount' => 250,
                    ])->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'title' => 'salt',
                        'unit' => 'teaspoon',
                        'amount' => 1,
                    ])->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'title' => 'olive oil',
                        'unit' => 'tablespoon',
                        'amount' => 3,
                    ])->id,
                ],
                [
                    'type' => 'ingredient',
                    'id' => IngredientModel::create([
                        'title' => 'dry yeast',
                        'unit' => 'package',
                        'amount' => 1,
                    ])->id,
                ],
            ],
        ]);
    }
}
