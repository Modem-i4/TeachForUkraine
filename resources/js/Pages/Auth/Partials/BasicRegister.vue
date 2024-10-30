<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GoogleAuthBtn from '@/Components/Additional/GoogleAuthBtn.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const form = useForm({
    email: '',
    password: '',
    password_confirmation: '',
});

const emit = defineEmits(['setRegStep', 'updHeight']);

const submit = () => {
    form.post(route('register'), {
        onSuccess: () => {
            emit('setRegStep', 1);
        },
        onFinish: () => {
            form.reset('password', 'password_confirmation');
            emit('updHeight');
        },
    });
};
</script>

<template>
    <InputLabel
        for="googleAuth"
        value="Рекомендуємо зареєструватися через Google!"
    />
    <GoogleAuthBtn text="Зареєстрвуватися з Google" id="googleAuth" />
    <form @submit.prevent="submit">
        <div class="mt-4">
            <InputLabel for="email" value="Email" />

            <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
            />

            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="Пароль" />

            <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autocomplete="off"
            />

            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel for="password_confirmation" value="Повтор пораля" />

            <TextInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                required
                autocomplete="off"
            />

            <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
            />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <Link
                :href="route('login')"
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                Я маю акаунт
            </Link>

            <PrimaryButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Зареєструватися
            </PrimaryButton>
        </div>
    </form>
</template>

<style scoped></style>
