<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateComposableForm from '@/Pages/Recipes/Composables/Partials/CreateComposableForm.vue';
import BackButton from "@/Components/BackButton.vue";
</script>

<template>
    <AppLayout title="Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Add ingredient to recipe
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <BackButton/>

                <CreateComposableForm/>
            </div>
        </div>
    </AppLayout>
</template>
