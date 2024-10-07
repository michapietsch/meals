<?php

namespace App\Http\Controllers;

use App\Models\MealModel;
use Inertia\Inertia;

class MealsController extends Controller
{
    public function show(MealModel $meal)
    {
        return Inertia::render('Meals/Meal', [
            'meal' => $meal->load('composition.composable'),
        ]);
    }
}
