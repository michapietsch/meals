<?php

namespace App\Objects;

use App\Models\MealModel;

class Meal
{
    public readonly int $id;
    public readonly string $title;
    public readonly \Illuminate\Support\Collection $dishes;

    public function __construct(MealModel $meal)
    {
        $this->id = $meal->id;

        $this->title = $meal->title;

        $this->dishes = $meal->dishes();

        throw_unless($this->dishes->every(fn ($dish) => $dish instanceof Composable));
    }
}
