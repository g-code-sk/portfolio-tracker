<template>
    <div class="mb-4">
        <label v-if="label" :for="id" class="mb-2 block text-sm font-medium text-gray-700">
            {{ label }}
        </label>
        <input
            :id="id"
            :value="modelValue"
            :type="type"
            :required="required"
            :minlength="minlength"
            :placeholder="placeholder"
            :disabled="disabled"
            :class="inputClasses"
            @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
            @blur="$emit('blur', $event)"
            @focus="$emit('focus', $event)"
        />
        <p v-if="hint" class="mt-1 text-xs text-gray-500">{{ hint }}</p>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    id: string;
    modelValue: string;
    type?: 'text' | 'email' | 'password' | 'tel' | 'number' | 'url' | 'search' | 'date' | 'time' | 'datetime-local';
    label?: string;
    placeholder?: string;
    required?: boolean;
    minlength?: number;
    disabled?: boolean;
    hint?: string;
}

withDefaults(defineProps<Props>(), {
    type: 'text',
    required: false,
    disabled: false,
});

defineEmits<{
    'update:modelValue': [value: string];
    blur: [event: FocusEvent];
    focus: [event: FocusEvent];
}>();

const inputClasses = computed(() => {
    const baseClasses =
        'w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none';
    const disabledClasses = 'disabled:bg-gray-100 disabled:cursor-not-allowed disabled:text-gray-500';
    return `${baseClasses} ${disabledClasses}`;
});
</script>
