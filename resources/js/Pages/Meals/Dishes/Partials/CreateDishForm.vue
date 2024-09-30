<script setup>
import {computed} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';
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

const page = usePage()

const dishes = computed(() => {
    return [
        ...page.props.composables.filter(ingredient => form.name === '' || ingredient.name.toLowerCase().includes(form.name.toLowerCase())),
        // ...page.props.recipes.filter(recipe => form.name === '' || recipe.name.toLowerCase().includes(form.name.toLowerCase()))
    ];
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
                <InputLabel for="name" value="Name"/>

                <Dropdown align="left" width="full">
                    <template #trigger="{close}">
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="block w-full mt-1"
                            autofocus
                            @blur="close"
                        />
                    </template>

                    <template #content>
                        <DropdownLink as="a" v-for="dish in dishes"
                                      @click="form.name = dish.name; form.id = dish.id; form.type = dish.type"
                                      :key="dish.id">
                            {{ dish.name }} <span
                            class="inline-block ml-2 bg-amber-500 rounded px-1 py-0.5 text-white">
                                {{ dish.type }}
                        </span>
                        </DropdownLink>
                    </template>
                </Dropdown>

                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="amount" value="Amount"/>

                <TextInput
                    id="amount"
                    v-model="form.amount"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />

                <InputError :message="form.errors.amount" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="unit" value="Unit"/>

                <TextInput
                    id="unit"
                    v-model="form.unit"
                    type="text"
                    class="block w-full mt-1"
                    autofocus
                />

                <InputError :message="form.errors.unit" class="mt-2"/>
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Add
            </PrimaryButton>
        </template>
    </FormSection>
</template>
