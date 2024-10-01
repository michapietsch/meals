<?php

namespace App\Objects;

use App\Models\CompositionModel;
use App\Models\RecipeModel;

class Recipe
{
    public static function fromModel(RecipeModel $recipe)
    {
        return new self(
            $recipe->id,
            $recipe->title,
            $recipe->composition
                ->map(
                    fn (CompositionModel $item) => match($item->composable_type) {
                        'ingredient' => Ingredient::fromModel($item->composable, $item->amount, $item->unit),
                    }
                )
        );
    }

    public function __construct(public readonly ?int $id, public readonly string $title, public readonly \Illuminate\Support\Collection $composition)
    {
        throw_unless($this->composition->every(fn ($composable) => $composable instanceof ComposableInterface));
    }
}
