<script setup>
import {Link, useForm} from '@inertiajs/vue3'

import RecipeModel from "@/Objects/Recipe";
import IngredientsList from "@/Components/Meals/IngredientsList.vue";

const props = defineProps({
    recipe: {
        type: Object,
        required: true,
        validator: (value) => {
            return value instanceof RecipeModel;
        },
    },
});

const deleteIngredient = (ingredient) => {
    useForm({}).delete(route('recipes.composables.destroy', {
        recipe: props.recipe.id,
        composable: ingredient.id,
    }), {
        preserveScroll: true,
        onSuccess: () => {
        },
    })
}
</script>

<template>
    <h1 class="pt-6 px-6 text-3xl font-bold">
        {{ recipe.title }}
    </h1>

    <p class="px-6 mb-4 text-sm/relaxed">
        Recipe
    </p>

    <IngredientsList :ingredients="recipe.composition" :deleteIngredient="deleteIngredient"/>

    <div class="flex items-center justify-between ml-6 mt-4 mb-6">
        <Link class="btn-indigo" :href="`/recipes/${recipe.id}/composables/create`">
            <span>Add</span>

            <span class="hidden md:inline">&nbsp;ingredient</span>
        </Link>
    </div>
</template>
