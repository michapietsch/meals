<?php

namespace App\Objects;

use App\Models\IngredientModel;
use App\Models\RecipeModel;
use Illuminate\Database\Eloquent\Model;

class Composable
{
    public readonly string $type;
    public readonly int $id;
    public readonly string $title;
    public readonly ?string $unit;
    public readonly ?float $amount;

    public function __construct(Model&ComposableInterface $composable, ?float $amount = null, ?string $unit = null)
    {
        $this->type =
            match(get_class($composable)) {
                IngredientModel::class => 'ingredient',
                RecipeModel::class => 'recipe',
            };
        $this->id = $composable->id;
        $this->title =
            match($this->type) {
                'ingredient' => $composable->title,
                'recipe' => $composable->title
            };
        $this->unit =  $unit ?? $composable->unit;
        $this->amount = $amount ?? $composable->amount;
    }
}
