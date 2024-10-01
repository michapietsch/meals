<?php

namespace App\Objects;

use App\Models\IngredientModel;

readonly class Ingredient implements ComposableInterface
{
    public static function fromModel(IngredientModel $ingredient, ?float $amount, ?string $unit): self
    {
        return new self($ingredient->id, $ingredient->title, $amount, $unit);
    }

    public function __construct(
        public ?int $id,
        public string $title,
        public ?float $amount,
        public ?string $unit,
    ) {
    }
}
