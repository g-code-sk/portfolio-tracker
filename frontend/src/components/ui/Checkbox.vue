<template>
    <div class="mb-6">
        <div class="flex items-center">
            <input
                :id="computedId"
                type="checkbox"
                :checked="checkboxValue"
                :required="required"
                :disabled="disabled"
                :class="checkboxClasses"
                @change="handleChange"
                @blur="handleBlur"
            />
            <label v-if="label" :for="computedId" class="ml-2 text-sm text-gray-700">
                <slot>{{ label }}</slot>
            </label>
        </div>
        <p v-if="showError" class="mt-1 text-xs text-red-600">
            {{ activeError }}
        </p>
    </div>
</template>

<script setup lang="ts">
import { useField } from 'vee-validate'
import { computed } from 'vue'

interface Props {
    name?: string
    id?: string
    modelValue?: boolean
    required?: boolean
    label?: string
    disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    required: false,
    modelValue: false,
    disabled: false,
})

const emit = defineEmits<{
    'update:modelValue': [value: boolean]
}>()

const field = props.name
    ? useField<boolean>(() => props.name as string, undefined, {
          type: 'checkbox',
          checkedValue: true,
          uncheckedValue: false,
      })
    : null

const checkboxValue = computed(() => {
    if (field) {
        return Boolean(field.value.value)
    }
    return Boolean(props.modelValue)
})

const handleChange = (event: Event) => {
    const checked = (event.target as HTMLInputElement).checked
    if (field) {
        field.handleChange(event)
        field.setTouched(true)
    } else {
        emit('update:modelValue', checked)
    }
}

const handleBlur = (event: FocusEvent) => {
    if (field) {
        field.handleBlur(event)
    }
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

const checkboxClasses = computed(() => {
    const baseClasses = 'h-4 w-4 rounded border'
    const stateClasses = showError.value ? 'border-red-500 text-red-600 focus:ring-red-500' : 'border-gray-300 text-blue-600 focus:ring-blue-500'
    const disabledClasses = 'disabled:bg-gray-100 disabled:cursor-not-allowed disabled:text-gray-500'
    return `${baseClasses} ${stateClasses} focus:ring-2 ${disabledClasses}`
})
</script>
