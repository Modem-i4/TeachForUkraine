<script setup>
import { defineEmits, onMounted, onUnmounted, ref, watch } from 'vue';
import axios from 'axios';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    oblast: {
        type: String,
        default: '',
    },
});
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

const emit = defineEmits(['setOblast']);

const selectOblast = (newOblast) => {
    emit('setOblast', newOblast);
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
</script>

<template>
    <InputLabel for="oblast" value="Область" />
    <div class="relative">
        <TextInput
            id="oblast"
            type="text"
            class="mt-1 block w-full"
            v-model="searchQuery"
            :placeholder="oblast ? oblast : 'Пошук області'"
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
</template>

<style scoped></style>
