<template>
    <div class="mb-4">
        <label v-if="label" :for="computedId" class="mb-2 block text-sm font-medium text-gray-700">
            {{ label }}
        </label>
        <input :id="computedId" ref="fileInputRef" type="file" :accept="accept" :disabled="disabled" :class="inputClasses" @change="handleChange" @blur="handleBlur" />
        <p v-if="showError" class="mt-1 text-xs text-red-600">{{ activeError }}</p>
        <p v-else-if="hint" class="mt-1 text-xs text-gray-500">{{ hint }}</p>
    </div>
</template>

<script setup lang="ts">
import { useField } from 'vee-validate'
import { computed, ref } from 'vue'

interface Props {
    name?: string
    id?: string
    label?: string
    accept?: string
    disabled?: boolean
    hint?: string
}

const props = withDefaults(defineProps<Props>(), {
    disabled: false,
})

const emit = defineEmits<{
    'update:modelValue': [value: File | null]
    blur: [event: FocusEvent]
}>()

const fileInputRef = ref<HTMLInputElement | null>(null)

type FieldContext = ReturnType<typeof useField<File | null>>
let field: FieldContext | null = null

if (props.name) {
    field = useField<File | null>(() => props.name as string)
}

const handleChange = (event: Event) => {
    const target = event.target as HTMLInputElement
    const file = target.files?.[0] || null

    if (field) {
        field.setValue(file)
    } else {
        emit('update:modelValue', file)
    }
}

const handleBlur = (event: FocusEvent) => {
    if (field) {
        field.handleBlur(event)
    }
    emit('blur', event)
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
    const baseClasses =
        'block w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 transition-colors file:mr-4 file:cursor-pointer file:rounded-md file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500'
    const borderClasses = showError.value ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500'
    const disabledClasses = 'disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500'
    return `${baseClasses} ${borderClasses} ${disabledClasses}`
})
</script>
