<template>
    <div>
        <label v-if="label" :for="computedId" class="mb-2 block text-sm font-medium text-gray-700">
            {{ label }}
        </label>

        <div class="relative">
            <select :id="computedId" :name="name" :disabled="disabled" :class="selectClasses" :value="currentValue" @change="handleChange" @blur="handleBlur">
                <option value="" disabled hidden></option>
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>

            <div v-if="!currentValue" class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <span class="text-gray-500">{{ placeholder }}</span>
            </div>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
            </div>
        </div>

        <p v-if="showError" class="mt-1 text-xs text-red-600">{{ activeError }}</p>
        <p v-else-if="hint" class="mt-1 text-xs text-gray-500">{{ hint }}</p>
    </div>
</template>

<script setup lang="ts">
import { SelectOption } from '@/lib/types/generic-types'
import { useField } from 'vee-validate'
import { computed } from 'vue'

const props = withDefaults(
    defineProps<{
        label?: string
        name?: string
        id?: string
        modelValue?: string
        options: SelectOption[]
        hint?: string
        disabled?: boolean
        placeholder?: string
    }>(),
    {
        modelValue: '',
        options: () => [],
        disabled: false,
        placeholder: 'Select an option',
    },
)

const computedId = computed(() => props.id ?? props.name ?? '')
const emit = defineEmits<{
    'update:modelValue': [value: string]
    blur: [event: FocusEvent]
}>()

type FieldContext = ReturnType<typeof useField<string>>
let field: FieldContext | null = null

if (props.name) {
    field = useField<string>(() => props.name as string)
}

const currentValue = computed(() => {
    if (field) {
        return field.value.value ?? ''
    }
    return props.modelValue
})

const selectClasses = computed(() => {
    const baseClasses =
        'block w-full appearance-none rounded-lg border px-4 py-2.5 pr-10 text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500'
    const stateClasses = showError.value ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'
    return `${baseClasses} ${stateClasses}`
})

const handleChange = (event: Event) => {
    const value = (event.target as HTMLSelectElement).value
    if (field) {
        field.handleChange(event)
    } else {
        emit('update:modelValue', value)
    }
}

const handleBlur = (event: FocusEvent) => {
    if (field) {
        field.handleBlur(event)
    }
    emit('blur', event)
}

const activeError = computed(() => {
    if (field) {
        return field.errorMessage.value
    }
    return ''
})

const showError = computed(() => {
    if (field) {
        return field.meta.touched && Boolean(field.errorMessage.value)
    }
    return false
})
</script>
