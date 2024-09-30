<script setup>
import {Link, useForm} from '@inertiajs/vue3'

import Icon from '@/Components/Icon.vue'

import MealModel from "@/Objects/Meal";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    meal: {
        type: Object,
        required: true,
        validator: (value) => {
            return value instanceof MealModel;
        },
    },
});

const form = useForm({});

const deleteDish = (dish) => {
    form.delete(route(`meals.dishes.destroy`, {
        meal: props.meal.id,
        type: dish.type,
        id: dish.id,
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

    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead>
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6" colspan="2">Dishes</th>

                <th/>
            </tr>
            </thead>

            <tbody>
            <tr v-for="dish in meal.dishes" :key="dish.id" class="hover:bg-gray-100 focus-within:bg-gray-100 group">
                <td class="border-t">
                    <button class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/dishes/${dish.id}/edit`">
                        {{ dish.amount }} {{ dish.unit }} {{ dish.amount && dish.unit ? 'of' : '' }} {{ dish.name }}
                        <icon v-if="dish.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400"/>

                        <Link
                            v-if="dish.type === 'recipe'"
                            class="underline text-indigo-500 ml-4"
                            :href="`/recipes/${dish.id}`"
                        >
                            show recipe
                        </Link>

                    </button>
                </td>

                <td class="w-px border-t">
                    <DangerButton class="hidden group-hover:block" @click="() => deleteDish(dish)">
                        Remove
                    </DangerButton>
                </td>

                <td class="w-px border-t">
                    <Link class="flex items-center px-4" :href="`/dishes/${dish.id}/edit`" tabindex="-1">
                        <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400"/>
                    </Link>
                </td>
            </tr>

            <tr v-if="meal.dishes.length === 0">
                <td class="px-6 py-4 border-t" colspan="3">No dishes, yet.</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between ml-6 mt-4 mb-6">
        <Link class="btn-indigo" :href="`/meals/${meal.id}/dishes/create`">
            <span>Add</span>

            <span class="hidden md:inline">&nbsp;a dish</span>
        </Link>
    </div>
</template>
