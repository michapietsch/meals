<?php

namespace Tests\Feature\Actions\IngredientsList;

use App\Actions\IngredientsList\CollectIngredientsRecursively;
use App\Models\CompositionModel;
use App\Models\IngredientModel;
use App\Models\MealModel;
use App\Models\RecipeModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CollectIngredientsRecursivelyTest extends TestCase
{
    private function meal()
    {
        return
            (new MealModel())
            ->setRelation(
                'composition',
                collect([
                    (new CompositionModel([
                        'composable_id' => 1,
                        'composable_type' => 'recipe',
                        'amount' => 3,
                        'unit' => 'tray',
                    ]))->setRelation(
                        'composable',
                        $this->recipePizza()
                    )
                ])->filter()
            );
    }

    private function recipePizza()
    {
        return
            (new RecipeModel([
                'id' => 1,
                'title' => 'Peperoni pizza',
            ]))->setRelation(
                'composition',
                collect([
                    (new CompositionModel([
                        'composable_id' => 2,
                        'composable_type' => 'recipe',
                        'amount' => 2,
                        'unit' => 'tray',
                    ]))->setRelation(
                        'composable',
                        $this->recipePizzaDough()
                    )
                ])->filter()
            );
    }

    private function recipePizzaDough()
    {
        return
            (new RecipeModel([
                'id' => 2,
                'title' => 'Pizza dough',
            ]))
            ->setRelation(
                'composition',
                collect([
                    $this->composeFlour(),
                ])
            );
    }

    private function composeApples()
    {
        return
            (new CompositionModel([
            'composable_id' => 1,
            'composable_type' => 'ingredient',
            'amount' => 2,
            'unit' => 'pcs',
        ]))->setRelation(
            'composable',
            (new IngredientModel([
                'id' => 1,
                'title' => 'Apples',
            ]))
        );
    }

    private function composePepperoni()
    {
        return
            (new CompositionModel([
                'composable_id' => 2,
                'composable_type' => 'ingredient',
                'amount' => 1,
                'unit' => 'bunch',
            ]))->setRelation(
                'composable',
                (new IngredientModel([
                    'id' => 2,
                    'title' => 'Peperoni',
                ]))
            );
    }

    private function composeFlour()
    {
        return
            (new CompositionModel([
                'composable_id' => 3,
                'composable_type' => 'ingredient',
                'amount' => 450,
                'unit' => 'g',
            ]))->setRelation(
                'composable',
                (new IngredientModel([
                    'id' => 3,
                    'title' => 'Flour',
                ]))
            );
    }

    #[Test]
    public function returns_flat_collection()
    {
        $sut = new CollectIngredientsRecursively();

        $meal = (new MealModel())
            ->setRelation(
                'composition',
                collect([$this->composeApples()])
            );

        $result =
            $sut->toFlatCollection($meal)
                ->pluck('amount');

        $expected = collect([2.0]);

        $this->assertEquals($expected, $result);
    }

    #[Test]
    public function handles_ingredient_amount_on_meal_level_correctly()
    {
        $sut = new CollectIngredientsRecursively();

        $meal = $this->meal();

        $meal->composition->push($this->composeApples());
        $meal->composition->first()->composable->composition->push($this->composePepperoni());

        $result =
            $sut->toFlatCollection($meal)
            ->map(fn ($item) => [
                $item->amount,
                $item->composable->title
            ]);

        $expected = collect([
            [2700.00, 'Flour'],
            [3.0, 'Peperoni'],
            [2.0, 'Apples'],
        ]);

        $this->assertEquals($expected, $result);
    }

    #[Test]
    public function multiplies_recipe_components_with_amount_recursively_with_recipe_produced_amount_of_one()
    {
        $sut = new CollectIngredientsRecursively();

        $meal = $this->meal();

        // trays of pepperoni pizza:
        $meal->composition->last()->amount = 3;

        // one tray requires pizza dough for number of trays:
        $meal->composition->last()->composable->composition->last()->amount = 2;

        // ... and requires amount of flour:
        $meal->composition->last()->composable->composition->last()->composable->composition->first()->amount = 450;

        $result = $sut->toFlatCollection($meal);

        $amountOfFlourNeeded = $result->last()->amount;

        $expected = 450 * 2 * 3;

        $this->assertEquals($expected, $amountOfFlourNeeded);
    }
}
