<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { defineEmits } from 'vue';

const form = useForm({
    charName: '',
    character: {
        skin: '',
    },
    skills: {
        math: 0,
        language: 0,
    },
});
const emit = defineEmits(['updHeight']);
const submit = () => {
    form.patch(route('character.register'), {
        onFinish: () => {
            emit('updHeight');
        },
    });
};
</script>

<template>
    <h1>
        Прекрасно! А тепер останнє: давай познайомимося із твоїм персонажем!
    </h1>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="name" value="Ім'я персонажа" />

            <TextInput
                id="charName"
                type="text"
                class="mt-1 block w-full"
                v-model="form.charName"
                required
                autofocus
                autocomplete="name"
            />

            <InputError class="mt-2" :message="form.errors.charName" />
        </div>
        <PrimaryButton class="mt-4">Готово!</PrimaryButton>
    </form>
</template>

<style scoped></style>
