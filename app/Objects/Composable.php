<?php

namespace App\Objects;

use App\Models\IngredientModel;
use App\Models\RecipeModel;
use Illuminate\Database\Eloquent\Model;

class Composable
{
    public readonly string $type;
    public readonly int $id;
    public readonly string $name;
    public readonly ?string $unit;
    public readonly ?float $amount;

    public function __construct(Model $composable, ?float $amount = null, ?string $unit = null)
    {
        throw_unless(
            $composable instanceof IngredientModel || $composable instanceof RecipeModel,
        );

        $this->type =
            match(get_class($composable)) {
                IngredientModel::class => 'ingredient',
                RecipeModel::class => 'recipe',
            };
        $this->id = $composable->id;
        $this->name =
            match($this->type) {
                'ingredient' => $composable->name,
                'recipe' => $composable->title
            };
        $this->unit =  $unit ?? $composable->unit;
        $this->amount = $amount ?? $composable->amount;
    }
}
