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
                    $this->composeApples(),

                    (new CompositionModel([
                        'composable_id' => 1,
                        'composable_type' => 'recipe',
                        'amount' => 1,
                        'unit' => 'tray',
                    ]))->setRelation(
                        'composable',
                        $this->recipePizza()
                    )
                ])
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
                    $this->composePepperoni(),

                    (new CompositionModel([
                        'composable_id' => 2,
                        'composable_type' => 'recipe',
                        'amount' => 800,
                        'unit' => 'g',
                    ]))->setRelation(
                        'composable',
                        $this->recipePizzaDough()
                    )
                ])
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

        $meal = $this->meal();

        $result = $sut->toFlatCollection($meal);

        $expected = collect([
            $this->composeApples(),
            $this->composePepperoni(),
            $this->composeFlour(),
        ]);

        $this->assertEquals($expected, $result);
    }
}
