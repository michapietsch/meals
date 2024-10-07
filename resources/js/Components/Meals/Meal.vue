<script setup>
import {Link, useForm} from '@inertiajs/vue3'

import MealModel from "@/Objects/Meal";
import IngredientsList from "@/Components/Meals/IngredientsList.vue";

const props = defineProps({
    meal: {
        type: Object,
        required: true,
        validator: (value) => {
            return value instanceof MealModel;
        },
    },
});

const deleteDish = (dish) => {
    useForm({}).delete(route(`meals.dishes.destroy`, {
        meal: props.meal.id,
        dish: dish.id,
    }), {
        preserveScroll: true,
        onSuccess: () => {
        },
    })
}
</script>

<template>
    <h1 class="pt-6 px-6 text-3xl font-bold">
        {{ meal.title }}
    </h1>

    <p class="px-6 mb-4 text-sm/relaxed">
        Meal
    </p>

    <IngredientsList :ingredients="meal.composition" :deleteIngredient="deleteDish"/>

    <div class="flex items-center justify-between ml-6 mt-4 mb-6">
        <Link class="btn-indigo" :href="`/meals/${meal.id}/dishes/create`">
            <span>Add</span>

            <span class="hidden md:inline">&nbsp;a dish</span>
        </Link>
    </div>
</template>
