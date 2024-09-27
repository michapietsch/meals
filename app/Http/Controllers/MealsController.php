<?php

namespace App\Http\Controllers;

use App\Models\MealModel;
use App\Objects\Meal;
use Inertia\Inertia;

class MealsController extends Controller
{
    public function show(MealModel $meal)
    {
        return Inertia::render('Dashboard', [
            'meal' => new Meal($meal),
        ]);
    }
}
