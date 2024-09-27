<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

const form = useForm({
    type: 'ingredient',
    id: null,
    name: '',
    amount: 1,
    unit: '',
});

const createDish = () => {
    form.post(route('meals.dishes.store', route().params.meal),
{
            errorBag: 'createDish',
            preserveScroll: true,
        });
};
</script>

<template>
    <FormSection @submitted="createDish">
        <template #title>
            Dish Details
        </template>

        <template #description>
            Add a new dish to this meal.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Name" />

                <Dropdown align="left" width="full">
                    <template #trigger>
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="block w-full mt-1"
                            autofocus
                        />
                    </template>

                    <template #content>
                        <DropdownLink as="a" v-for="ingredient in $page.props.ingredients" @click="form.name = ingredient.name; form.id = ingredient.id" :key="ingredient.id">
                            {{ ingredient.name }} <span class="inline-block ml-2 bg-amber-500 rounded px-1 py-0.5 text-white">ingredient</span>
                        </DropdownLink>
                    </template>
                </Dropdown>

                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="amount" value="Amount" />

                <TextInput
                    id="amount"
                    v-model="form.amount"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />

                <InputError :message="form.errors.amount" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="unit" value="Unit" />

                <TextInput
                    id="unit"
                    v-model="form.unit"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />

                <InputError :message="form.errors.unit" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Add
            </PrimaryButton>
        </template>
    </FormSection>
</template>
