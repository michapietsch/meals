<?php

namespace App\Objects;

use App\Models\RecipeModel;

class Recipe
{
    public readonly int $id;
    public readonly string $title;
    public readonly \Illuminate\Support\Collection $ingredients;

    public function __construct(RecipeModel $recipe)
    {
        $this->id = $recipe->id;

        $this->title = $recipe->title;

        $this->ingredients = $recipe->ingredients();

        throw_unless($this->ingredients->every(fn ($ingredient) => $ingredient instanceof Ingredient));
    }
}
