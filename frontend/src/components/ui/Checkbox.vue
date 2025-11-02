<template>
    <div class="mb-6 flex items-start">
        <input
            :id="id"
            :checked="modelValue"
            :required="required"
            type="checkbox"
            :class="checkboxClasses"
            @change="$emit('update:modelValue', ($event.target as HTMLInputElement).checked)"
        />
        <label v-if="label" :for="id" class="ml-2 text-sm text-gray-700">
            <slot>{{ label }}</slot>
        </label>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    id: string;
    modelValue: boolean;
    required?: boolean;
    label?: string;
}

withDefaults(defineProps<Props>(), {
    required: false,
});

defineEmits<{
    'update:modelValue': [value: boolean];
}>();

const checkboxClasses = computed(() => {
    return 'mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500';
});
</script>
