<template>
    <div class="mb-4">
        <label v-if="label" :for="computedId" class="mb-2 block text-sm font-medium text-gray-700">
            {{ label }}
        </label>
        <input
            :id="computedId"
            :value="inputValue"
            :type="type"
            :required="required"
            :minlength="minlength"
            :placeholder="placeholder"
            :disabled="disabled"
            :autocomplete="autocomplete"
            :class="inputClasses"
            @input="handleInput"
            @blur="handleBlur"
            @focus="handleFocus"
        />
        <p v-if="showError" class="mt-1 text-xs text-red-600">{{ activeError }}</p>
        <p v-else-if="hint" class="mt-1 text-xs text-gray-500">{{ hint }}</p>
    </div>
</template>

<script setup lang="ts">
import { useField } from 'vee-validate'
import { computed } from 'vue'

interface Props {
    name?: string
    id?: string
    modelValue?: string
    type?: 'text' | 'email' | 'password' | 'tel' | 'number' | 'url' | 'search' | 'date' | 'time' | 'datetime-local'
    label?: string
    placeholder?: string
    required?: boolean
    minlength?: number
    disabled?: boolean
    hint?: string
    autocomplete?: string
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    required: false,
    disabled: false,
    modelValue: '',
})

const emit = defineEmits<{
    'update:modelValue': [value: string]
    blur: [event: FocusEvent]
    focus: [event: FocusEvent]
}>()

type FieldContext = ReturnType<typeof useField<string>>
let field: FieldContext | null = null

if (props.name) {
    field = useField<string>(() => props.name as string)
}

const inputValue = computed(() => {
    if (field) {
        return field.value.value ?? ''
    }
    return props.modelValue ?? ''
})

const handleInput = (event: Event) => {
    const newValue = (event.target as HTMLInputElement).value
    if (field) {
        field.handleChange(event)
    } else {
        emit('update:modelValue', newValue)
    }
}

const handleBlur = (event: FocusEvent) => {
    if (field) {
        field.handleBlur(event)
    }
    emit('blur', event)
}

const handleFocus = (event: FocusEvent) => {
    emit('focus', event)
}

const computedId = computed(() => props.id ?? props.name ?? '')

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

const inputClasses = computed(() => {
    const baseClasses = 'w-full rounded-lg border px-4 py-2.5 text-gray-900 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500'
    const borderClasses = showError.value ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500'
    const disabledClasses = 'disabled:bg-gray-100 disabled:cursor-not-allowed disabled:text-gray-500'
    return `${baseClasses} ${borderClasses} ${disabledClasses}`
})
</script>
