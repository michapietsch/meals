<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import MealModel from "@/Objects/Meal";
import Meal from "@/Components/Meals/Meal.vue";
import {computed} from "vue";

const props = defineProps({
    meal: Object,
    time: String,
});

const mealObject = computed(() => new MealModel(props.meal.id, props.meal.title, props.meal.dishes));

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Meal :meal="mealObject"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
