<script setup lang="ts">
const { message } = defineProps<{ message?: string }>();
</script>

<template>
    <div v-if="message">
        <p class="text-sm text-red-600 dark:text-red-500">
            {{ message }}
        </p>
    </div>
</template>
