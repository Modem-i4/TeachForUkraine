<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import BasicRegister from '@/Components/Additional/RegisterSteps/BasicRegister.vue';
import StudentRegister from '@/Components/Additional/RegisterSteps/StudentRegister.vue';
import { ref, defineProps, watch } from 'vue';
import Accordion from '@/Components/Additional/Accordion.vue';
import CharacterRegister from '@/Components/Additional/RegisterSteps/CharacterRegister.vue';

const props = defineProps({
    r: {
        type: Number,
        default: 0,
    },
    name: {
        type: String,
        default: '',
    },
});

const regStep = ref(props.r);

function getAccordions(val) {
    return {
        basic: val === 0,
        student: val === 1,
        character: val === 2,
    };
}

let accordions = ref(getAccordions(regStep.value));

watch(regStep, (newVal) => {
    accordions.value = getAccordions(newVal);
});

function setRegStep(val) {
    regStep.value = val;
}
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <Accordion v-model="accordions.basic">
            <BasicRegister @setRegStep="setRegStep" />
        </Accordion>
        <Accordion v-model="accordions.student">
            <StudentRegister @setRegStep="setRegStep" :name="name" />
        </Accordion>
        <Accordion v-model="accordions.character">
            <CharacterRegister />
        </Accordion>
    </GuestLayout>
</template>
