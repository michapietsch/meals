<?php

namespace App\Actions\IngredientsList;

use App\Models\CompositionModel;
use App\Models\MealModel;
use App\Models\RecipeModel;
use Illuminate\Support\Collection;

class CollectIngredientsRecursively
{
    public function toFlatCollection(MealModel|RecipeModel $mealOrRecipe)
    {
        return $mealOrRecipe
            ->composition
            ->reduce(
                function (Collection $carry, CompositionModel $item) {
                    $factor =
                        $item->composable_type === "recipe" ?
                            $item->amount
                        : 1.0;

                    return $this->reduce($carry, $item, $factor);
                },
                collect()
            );
    }

    private function reduce(Collection &$carry, CompositionModel $item, float $factor = 1.0)
    {
        if ($item->composable_type === "ingredient") {
            $item->amount = $item->amount * $factor;

            $carry[] = $item;

            return $carry;
        }

        $item->composable->composition
            ->reduce(
                function (Collection $carry, CompositionModel $item) use ($factor) {
                    if ($item->composable_type === "recipe") {
                        $factor = $factor * $item->amount;
                    }

                    return $this->reduce($carry, $item, $factor);
                },
                $carry
            );

        return $carry;
    }
}
