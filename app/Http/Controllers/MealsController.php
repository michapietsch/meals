<?php

namespace App\Http\Controllers;

use App\Models\MealModel;
use Inertia\Inertia;

class MealsController extends Controller
{
    public function show(MealModel $meal)
    {
        return Inertia::render('Dashboard', [
            'meal' => $meal->load('composition.composable'),
        ]);
    }
}
