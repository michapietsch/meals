<?php


use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect(route('meals.show', \App\Models\MealModel::first()));
    })->name('dashboard');

    Route::resource('meals', \App\Http\Controllers\MealsController::class);
    Route::resource('meals.dishes', \App\Http\Controllers\MealDishesController::class)->except(['destroy']);
    Route::delete('meals/{meal}/dishes/{type}/{id}', [\App\Http\Controllers\MealDishIngredientController::class, 'destroy'])->name('meals.dishes.destroy');
    Route::resource('recipes', \App\Http\Controllers\RecipesController::class);
    Route::resource('recipes.composables', \App\Http\Controllers\RecipeComposablesController::class);
});
