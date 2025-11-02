<template>
    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-2xl font-bold text-white">
        {{ text }}
    </div>
</template>

<script setup lang="ts">
withDefaults(defineProps<{ text?: string }>(), {
    text: 'PT',
});
</script>
