<?php

namespace App\Models;

use App\Objects\ComposableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RecipeModel extends Model implements ComposableInterface
{
    use HasFactory;

    protected $table = 'recipes';

    protected $guarded = [];

    protected $casts = [
        'ingredients' => 'array',
    ];

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
