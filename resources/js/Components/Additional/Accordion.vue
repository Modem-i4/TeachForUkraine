<template>
    <div class="accordion" :class="{ 'accordion-with-frame': withFrame }">
        <div
            class="accordion-header"
            @click="toggle"
            :class="{ active: isActive }"
            v-if="withHeader"
        >
            <slot name="header">Accordion Header</slot>
        </div>
        <div
            class="accordion-content"
            :style="{ maxHeight: isActive ? contentHeight + 'px' : '0' }"
            ref="content"
        >
            <slot :updHeight="updHeight">Accordion Content</slot>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, defineProps, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
    withFrame: {
        type: Boolean,
        default: false,
    },
    withHeader: {
        type: Boolean,
        default: false,
    },
});

const isActive = ref(props.modelValue);
const contentHeight = ref(0);
const content = ref(null);

const toggle = () => {
    isActive.value = !isActive.value;
};

watch(
    () => props.modelValue,
    (newVal) => {
        isActive.value = newVal;
    },
);

const updHeight = () => {
    contentHeight.value = content.value.scrollHeight;
};
defineExpose({ updHeight });

onMounted(updHeight);
</script>

<style>
.accordion-with-frame {
    border: 1px solid #ccc;
    border-radius: 4px;
}

.accordion-header {
    padding: 10px;
    cursor: pointer;
    background: #f1f1f1;
    transition: background 0.3s ease;
}

.accordion-header.active {
    background: #007bff;
    color: white;
}

.accordion-content {
    overflow: hidden;
    transition: max-height 0.75s ease;
    padding: 0 10px;
}
</style>
