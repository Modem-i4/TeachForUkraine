<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import GradeSelector from '@/Components/Additional/GradeSelector.vue';
import OblastSelector from '@/Components/Additional/OblastSelector.vue';

defineProps({
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    oblast: user.oblast,
    city: user.city,
    grade: user.grade,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Більше про тебе</h2>

            <p class="mt-1 text-sm text-gray-600">Познайомимося!</p>
        </header>

        <form
            @submit.prevent="
                form.patch(route('student.update'), {
                    preserveScroll: true,
                })
            "
            class="mt-6 space-y-6"
        >
            <div>
                <GradeSelector
                    @setGrade="(grade) => (form.grade = grade)"
                    :grade="form.grade"
                />
                <InputError class="mt-2" :message="form.errors.grade" />
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
                    autocomplete="city"
                />
                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing"
                    >Зберегти
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Збережено!
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
