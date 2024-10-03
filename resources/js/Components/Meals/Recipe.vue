<script setup>
import {Link, useForm} from '@inertiajs/vue3'

import Icon from '@/Components/Icon.vue'

import RecipeModel from "@/Objects/Recipe";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    recipe: {
        type: Object,
        required: true,
        validator: (value) => {
            return value instanceof RecipeModel;
        },
    },
});

const form = useForm({});

const deleteIngredient = (ingredient) => {
    form.delete(route('recipes.composables.destroy', {
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

    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead>
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6" colspan="2">Ingredients</th>

                <th/>
            </tr>
            </thead>

            <tbody>
            <tr v-for="ingredient in recipe.composition" :key="ingredient.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100 group">
                <td class="border-t">
                    <button class="flex items-center px-6 py-4 focus:text-indigo-500"
                            :href="`/ingredients/${ingredient.id}/edit`">
                        {{ ingredient.amount }} {{ ingredient.unit }}
                        {{ ingredient.amount && ingredient.unit ? 'of' : '' }} {{ ingredient.composable.title }}
                        <icon v-if="ingredient.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400"/>

                        <Link
                            v-if="ingredient.composable_type === 'recipe'"
                            class="underline text-indigo-500 ml-4"
                            :href="`/recipes/${ingredient.composable.id}`"
                        >
                            show recipe
                        </Link>
                    </button>
                </td>

                <td class="w-px border-t">
                    <DangerButton class="hidden group-hover:block" @click="() => deleteIngredient(ingredient)">
                        Remove
                    </DangerButton>
                </td>

                <td class="w-px border-t">
                    <Link class="flex items-center px-4" :href="`/ingredients/${ingredient.id}/edit`" tabindex="-1">
                        <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400"/>
                    </Link>
                </td>
            </tr>

            <tr v-if="recipe.composition.length === 0">
                <td class="px-6 py-4 border-t" colspan="3">No ingredients, yet.</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between ml-6 mt-4 mb-6">
        <Link class="btn-indigo" :href="`/recipes/${recipe.id}/composables/create`">
            <span>Add</span>

            <span class="hidden md:inline">&nbsp;an ingredient</span>
        </Link>
    </div>
</template>
