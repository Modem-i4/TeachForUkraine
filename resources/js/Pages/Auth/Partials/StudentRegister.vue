<script setup>
import { defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import OblastSelector from '@/Components/Additional/OblastSelector.vue';
import GradeSelector from '@/Components/Additional/GradeSelector.vue';

const form = useForm({
    name: '',
    grade: null,
    oblast: '',
    city: '',
});

const emit = defineEmits(['setRegStep', 'updHeight']);
const submit = () => {
    form.patch(route('student.register'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            emit('setRegStep', 2);
        },
        onFinish: () => {
            emit('updHeight');
        },
    });
};
const props = defineProps({
    name: {
        type: String,
        default: '',
    },
});
form.name = props.name === 'Учень/учениця' ? '' : props.name;
</script>

<template>
    <h1>Чудово, ти зареєструвався! Тепер давай з тобою познайомимося</h1>
    <form @submit.prevent="submit" class="py-5">
        <div>
            <InputLabel for="name" value="Ім'я та прізвище" />
            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
            />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div>
            <OblastSelector
                @setOblast="(oblast) => (form.oblast = oblast)"
                :oblast="form.oblast"
            />
            <InputError class="mt-2" :message="form.errors.oblast" />
        </div>
        <div>
            <InputLabel for="city" value="Місто" />
            <TextInput
                id="city"
                type="text"
                class="mt-1 block w-full"
                v-model="form.city"
                required
                autofocus
                autocomplete="city"
            />
            <InputError class="mt-2" :message="form.errors.city" />
        </div>

        <div>
            <GradeSelector
                @setGrade="(grade) => (form.grade = grade)"
                :grade="form.grade"
            />
            <InputError class="mt-2" :message="form.errors.grade" />
        </div>
        <PrimaryButton class="mt-4">Далі</PrimaryButton>
    </form>
</template>

<style scoped>
form > div {
    margin: 0.7em 0;
}
</style>
