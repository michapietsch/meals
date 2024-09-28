<?php

namespace App\Http\Controllers;

use App\Models\IngredientModel;
use App\Models\MealModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealDishesController extends Controller
{
    public function create(MealModel $meal)
    {
        return Inertia::render('Meals/Dishes/Create', [
            // 'meal' => new MealModel($meal),
            'ingredients' => IngredientModel::all(),
        ]);
    }

    public function store(Request $request, MealModel $meal)
    {
        $data = $request->validate([
            'type' => 'required|string|in:ingredient',
            'id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
            'unit' => 'nullable|string|max:255',
        ]);

        $ingredient =
            IngredientModel::firstOrCreate(
                [ 'id' => $data['id'] ],
                [
                    'name' => $data['name'],
                    'amount' => $data['amount'],
                    'unit' => $data['unit'],
                ]
            );

        $meal->dishes = [...$meal->dishes, [
            'type' => $data['type'],
            'id' => $ingredient->id,
        ]];

        $meal->save();

        return redirect()->route('meals.show', $meal);
    }
}
