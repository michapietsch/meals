<?php

namespace App\Providers;

use App\Models\IngredientModel;
use App\Models\RecipeModel;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'ingredient' => IngredientModel::class,
            'recipe' => RecipeModel::class,
        ]);
    }
}
