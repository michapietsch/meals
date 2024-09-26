<?php

use App\Models\IngredientModel;
use App\Objects\Meal;
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
        return Inertia::render('Dashboard', [
            'meal' => new Meal(\App\Models\MealModel::first()),
        ]);
    })->name('dashboard');

    Route::get('/meals/{meal}/dishes/create', function ($meal) {
        return Inertia::render('Meals/Dishes/Create', [
            // 'meal' => new MealModel($meal),
            'ingredients' => IngredientModel::all(),
        ]);
    })->name('meals.dishes.create');
});
