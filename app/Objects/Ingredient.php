<?php

namespace App\Objects;

use App\Models\IngredientModel;

class Ingredient
{
    public readonly string $type;
    public readonly int $id;
    public readonly string $name;
    public readonly ?string $unit;
    public readonly ?float $amount;

    public function __construct(IngredientModel $ingredient)
    {
        $this->type = 'ingredient';
        $this->id = $ingredient->id;
        $this->name = $ingredient->name;
        $this->unit = $ingredient->unit;
        $this->amount = $ingredient->amount;
    }
}
