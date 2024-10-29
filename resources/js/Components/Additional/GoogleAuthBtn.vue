<template>
    <div>
        <button @click="loginWithGoogle" class="google-button">
            {{ text }}
        </button>
    </div>
</template>

<script setup>
const loginWithGoogle = () => {
    window.location.href = route('google.redirect');
};
defineProps({
    text: {
        type: String,
        default: 'Увійти через Google',
    },
});
</script>

<style>
.google-button {
    background-color: #4285f4;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

.google-button:hover {
    background-color: #3367d6;
}
</style>
