<?php

namespace App\Models;

use App\Objects\Ingredient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

class RecipeModel extends Model
{
    use HasFactory;

    protected $table = 'recipes';

    protected $guarded = [];

    protected $casts = [
        'ingredients' => 'array',
    ];

    public function ingredients(): Collection
    {
        $ingredientModels = IngredientModel::whereIn('id', collect($this->ingredients)->pluck('id'))->get();

        return collect($this->ingredients)->map(function ($ingredient) use ($ingredientModels) {
            return new Ingredient($ingredientModels->find($ingredient['id']));
        });
    }

    public function composition(): MorphMany
    {
        return $this->morphMany(CompositionModel::class, 'parent')
            ->with('composable');
    }
}
