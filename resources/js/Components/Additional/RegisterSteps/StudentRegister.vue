<script setup>
import { ref, watch, onMounted, onUnmounted, defineEmits } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';

const studForm = useForm({
    name: '',
    grade: null,
    oblast: '',
    city: '',
});

// Список областей
const oblastList = ref([]);
const searchQuery = ref('');
var filteredOblasts;
const showDropdown = ref(false);

const fetchOblasts = async () => {
    try {
        const response = await axios.get('/constants/oblasts');
        oblastList.value = response.data;
        filteredOblasts = ref([...oblastList.value]);
    } catch (error) {
        console.error('Error fetching oblasts:', error);
    }
};

onMounted(() => {
    fetchOblasts();
});
const searchOblasts = () => {
    if (searchQuery.value) {
        filteredOblasts.value = oblastList.value.filter((oblast) =>
            oblast.toLowerCase().includes(searchQuery.value.toLowerCase()),
        );
    } else {
        filteredOblasts.value = [...oblastList.value];
    }
};

// Функція для вибору області
const selectOblast = (oblast) => {
    studForm.oblast = oblast;
    searchQuery.value = '';
    showDropdown.value = false;
};

watch(searchQuery, () => {
    searchOblasts();
});

const handleClickOutside = (event) => {
    const dropdown = document.getElementById('oblast-dropdown');
    const input = document.getElementById('oblast');
    if (
        dropdown &&
        !dropdown.contains(event.target) &&
        !input.contains(event.target)
    ) {
        showDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

// SUBMIT
const emit = defineEmits(['setRegStep']);
const submit = () => {
    studForm.patch(route('registerStudent'), {
        onSuccess: () => {
            emit('setRegStep', 2);
        },
    });
};
const props = defineProps({
    name: {
        type: String,
        default: 'as',
    },
});
studForm.name = props.name;
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
                v-model="studForm.name"
                required
                autofocus
                autocomplete="name"
            />
            <InputError class="mt-2" :message="studForm.errors.name" />
        </div>

        <div>
            <InputLabel for="oblast" value="Область" />
            <div class="relative">
                <TextInput
                    id="oblast"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="searchQuery"
                    :placeholder="studForm.oblast ? studForm.oblast : 'Пошук області'"
                    @focus="showDropdown = true"
                />
                <div
                    v-if="showDropdown"
                    id="oblast-dropdown"
                    class="absolute z-10 mt-1 w-full overflow-y-auto rounded-md border border-gray-300 bg-white shadow-lg"
                    style="max-height: 12rem"
                >
                    <ul>
                        <li
                            v-for="oblast in filteredOblasts"
                            :key="oblast"
                            @click="selectOblast(oblast)"
                            class="cursor-pointer p-2 hover:bg-blue-500 hover:text-white"
                        >
                            {{ oblast }}
                        </li>
                    </ul>
                    <p v-if="!filteredOblasts.length" class="p-2 text-gray-500">
                        Область не знайдена
                    </p>
                </div>
            </div>
            <InputError class="mt-2" :message="studForm.errors.oblast" />
        </div>
        <div>
            <InputLabel for="city" value="Місто" />
            <TextInput
                id="city"
                type="text"
                class="mt-1 block w-full"
                v-model="studForm.city"
                required
                autofocus
                autocomplete="city"
            />
            <InputError class="mt-2" :message="studForm.errors.city" />
        </div>

        <div>
            <InputLabel value="Клас" />
            <div class="mt-2 flex space-x-2">
                <template v-for="i in 11" :key="i">
                    <div
                        @click="studForm.grade = i"
                        class="cursor-pointer rounded border p-2 text-center"
                        :class="{
                            'bg-blue-500 text-white': studForm.grade === i,
                            'bg-white': studForm.grade !== i,
                        }"
                    >
                        {{ i }}
                    </div>
                </template>
            </div>
            <InputError class="mt-2" :message="studForm.errors.grade" />
        </div>
        <PrimaryButton class="mt-4">Submit</PrimaryButton>
    </form>
</template>

<style scoped>
form > div {
    margin: 0.7em 0;
}
</style>
