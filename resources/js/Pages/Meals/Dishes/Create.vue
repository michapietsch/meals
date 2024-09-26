<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateDishForm from '@/Pages/Meals/Dishes/Partials/CreateDishForm.vue';
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Add dish to meal
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateDishForm />
            </div>
        </div>
    </AppLayout>
</template>
