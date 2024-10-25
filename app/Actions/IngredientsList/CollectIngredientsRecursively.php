<?php

namespace App\Actions\IngredientsList;

use App\Models\MealModel;

class CollectIngredientsRecursively
{
    public function toFlatCollection(MealModel $meal)
    {
        return $meal
            ->composition
            ->reduce(
                function ($carry, $item) {
                    return $this->reduce($carry, $item);
                },
                collect()
            );
    }

    private function reduce(&$carry, $item)
    {
        if ($item->composable_type == "ingredient") {
            $carry[] = $item;

            return $carry;
        }

        $item->composable->composition
            ->reduce(
                function ($carry, $item) {
                    return $this->reduce($carry, $item);
                },
                $carry
            );

        return $carry;
    }
}
