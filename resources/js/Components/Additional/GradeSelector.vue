<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import { defineEmits } from 'vue';

const emit = defineEmits(['setGrade']);
defineProps({
    grade: Number,
});
const setGrade = (gr) => {
    emit('setGrade', gr);
};
</script>
<template>
    <InputLabel value="Клас" />
    <div class="mt-2 flex space-x-2">
        <template v-for="i in 11" :key="i">
            <div
                @click="setGrade(i)"
                class="cursor-pointer rounded border p-2 text-center"
                :class="{
                    'bg-blue-500 text-white': grade === i,
                    'bg-white': grade !== i,
                }"
            >
                {{ i }}
            </div>
        </template>
    </div>
</template>

<style scoped>
form > div {
    margin: 0.7em 0;
}
</style>
