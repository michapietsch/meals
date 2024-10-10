<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Recipe from "@/Components/Meals/Recipe.vue";

const props = defineProps({
    recipe: Object,
});
</script>

<template>
    <AppLayout title="Recipe">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Recipes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Recipe :recipe="recipe"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
