<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import BasicRegister from '@/Pages/Auth/Partials/BasicRegister.vue';
import StudentRegister from '@/Pages/Auth/Partials/StudentRegister.vue';
import { ref, defineProps, watch } from 'vue';
import Accordion from '@/Components/Additional/Accordion.vue';
import CharacterRegister from '@/Pages/Auth/Partials/CharacterRegister.vue';

const props = defineProps({
    step: {
        type: String,
        default: 'basic',
    },
    name: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <Accordion :model-value="step === 'basic'" #default="{ updHeight }">
            <BasicRegister @setRegStep="setRegStep" @updHeight="updHeight" />
        </Accordion>
        <Accordion :model-value="step === 'student'" #default="{ updHeight }">
            <StudentRegister
                @setRegStep="setRegStep"
                :name="name"
                @updHeight="updHeight"
            />
        </Accordion>
        <Accordion :model-value="step === 'character'"  #default="{ updHeight }">
            <CharacterRegister @updHeight="updHeight" />
        </Accordion>
    </GuestLayout>
</template>
