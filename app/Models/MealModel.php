<?php

namespace App\Models;

use App\Objects\Composable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

class MealModel extends Model
{
    use HasFactory;

    protected $table = 'meals';

    protected $casts = [
        'dishes' => 'array',
    ];

    public function dishes(): Collection
    {
        $ingredients = IngredientModel::whereIn('id', collect($this->dishes)->where('type', 'ingredient')->pluck('id'))->get();
        $recipes = RecipeModel::whereIn('id', collect($this->dishes)->where('type', 'recipe')->pluck('id'))->get();

        return collect($this->dishes)->map(function ($dish) use ($ingredients, $recipes) {
            $collectionToSearch =
                match($dish['type']) {
                    'ingredient' => $ingredients,
                    'recipe' => $recipes
                };

            return new Composable(
                $collectionToSearch
                ->find($dish['id']),
                $dish['type'] === 'recipe' ? $dish['amount'] : null,
                $dish['type'] === 'recipe' ? $dish['unit'] : null
            );
        });
    }

    public function composition(): MorphMany
    {
        return $this->morphMany(CompositionModel::class, 'parent')
            ->with('composable');
    }

    public function composeIngredient(?int $id, string $title, ?float $amount = null, ?string $unit = null): void
    {
        $this->composition()->create([
            'composable_id' => IngredientModel::firstOrCreate(
                [ 'id' => $id ],
                [ 'title' => $title ]
            )->id,
            'composable_type' => 'ingredient',
            'amount' => $amount,
            'unit' => $unit,
        ]);
    }

    public function composeRecipe(int $id, ?float $amount = null, ?string $unit = null): void
    {
        $this->composition()->create([
            'composable_id' => $id,
            'composable_type' => 'recipe',
            'amount' => $amount,
            'unit' => $unit,
        ]);
    }
}
