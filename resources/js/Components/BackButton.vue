<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";

const back = () => {
    window.history.back();
}
</script>

<template>
    <SecondaryButton @click="back" class="mb-4">
        Back
    </SecondaryButton>
</template>

<style scoped>

</style>
