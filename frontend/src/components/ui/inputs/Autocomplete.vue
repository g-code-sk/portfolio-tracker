<template>
    <div class="relative">
        <label v-if="label" :for="computedId" class="mb-2 block text-sm font-medium text-gray-700">
            {{ label }}
        </label>

        <div class="relative">
            <input
                :id="computedId"
                :name="name"
                :value="displayValue"
                :disabled="disabled || isLoading"
                :class="inputClasses"
                :placeholder="placeholder"
                autocomplete="off"
                @input="handleInput"
                @focus="handleFocus"
                @blur="handleBlur"
                @keydown.enter.prevent="handleEnter"
                @keydown.arrow-down.prevent="handleArrowDown"
                @keydown.arrow-up.prevent="handleArrowUp"
                @keydown.escape="handleEscape"
            />

            <!-- Loading Spinner -->
            <div v-if="isLoading" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 animate-spin text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                </svg>
            </div>

            <!-- Dropdown Arrow -->
            <div v-else class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
            </div>

            <!-- Dropdown Results -->
            <div
                v-if="showDropdown && filteredOptions.length > 0"
                class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-lg border border-gray-300 bg-white shadow-lg"
            >
                <ul class="list-none py-1 pl-1">
                    <li
                        v-for="(option, index) in filteredOptions"
                        :key="option.value"
                        :class="[
                            'cursor-pointer px-4 py-2 text-sm transition-colors',
                            index === selectedIndex ? 'bg-blue-50 text-blue-900' : 'text-gray-900 hover:bg-gray-100',
                        ]"
                        @mousedown.prevent="selectOption(option)"
                        @mouseenter="selectedIndex = index"
                    >
                        <slot name="option" :option="option">
                            {{ option.label }}
                        </slot>
                    </li>
                </ul>
            </div>

            <!-- No Results Message -->
            <div
                v-if="showDropdown && searchQuery && filteredOptions.length === 0 && !isLoading"
                class="absolute z-50 mt-1 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-500 shadow-lg"
            >
                No results found
            </div>
        </div>

        <p v-if="showError" class="mt-1 text-xs text-red-600">{{ activeError }}</p>
        <p v-else-if="hint" class="mt-1 text-xs text-gray-500">{{ hint }}</p>
    </div>
</template>

<script setup lang="ts">
import type { SelectOption } from '@/lib/types/generic-types'
import { useField } from 'vee-validate'
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue'

interface Props {
    label?: string
    name?: string
    id?: string
    modelValue?: string
    options?: SelectOption[]
    hint?: string
    disabled?: boolean
    placeholder?: string
    searchQuery?: string
    isLoading?: boolean
    onSearch?: (query: string) => void
    getOptionLabel?: (option: SelectOption) => string
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: '',
    options: () => [],
    disabled: false,
    placeholder: 'Type to search...',
    isLoading: false,
    getOptionLabel: (option: SelectOption) => option.label,
})

const emit = defineEmits<{
    'update:modelValue': [value: string]
    'update:searchQuery': [query: string]
    select: [option: SelectOption]
    blur: [event: FocusEvent]
}>()

const computedId = computed(() => props.id ?? props.name ?? '')
const searchInput = ref('')
const showDropdown = ref(false)
const selectedIndex = ref(-1)
let debounceTimer: ReturnType<typeof setTimeout> | null = null

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

const displayValue = computed(() => {
    if (searchInput.value) {
        return searchInput.value
    }
    if (currentValue.value) {
        const selected = props.options.find((opt) => opt.value === currentValue.value)
        return selected ? props.getOptionLabel(selected) : ''
    }
    return ''
})

const filteredOptions = computed(() => {
    // If using external search (onSearch prop), show all provided options
    // Otherwise, filter locally
    if (props.onSearch) {
        return props.options
    }
    if (!props.searchQuery && !searchInput.value) {
        return props.options
    }
    const query = (props.searchQuery || searchInput.value).toLowerCase()
    return props.options.filter((option) => {
        const label = props.getOptionLabel(option).toLowerCase()
        return label.includes(query)
    })
})

const inputClasses = computed(() => {
    const baseClasses =
        'block w-full rounded-lg border px-4 py-2.5 pr-10 text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500'
    const stateClasses = showError.value ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'
    return `${baseClasses} ${stateClasses}`
})

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

const handleInput = (event: Event) => {
    const value = (event.target as HTMLInputElement).value
    searchInput.value = value
    selectedIndex.value = -1

    if (debounceTimer) {
        clearTimeout(debounceTimer)
    }

    if (props.onSearch) {
        debounceTimer = setTimeout(() => {
            props.onSearch?.(value)
        }, 300)
    } else {
        emit('update:searchQuery', value)
    }

    if (!showDropdown.value && value) {
        showDropdown.value = true
    }
}

const handleFocus = () => {
    showDropdown.value = true
    if (props.options.length > 0) {
        selectedIndex.value = -1
    }
}

const handleBlur = (event: FocusEvent) => {
    // Delay to allow option click to register
    setTimeout(() => {
        showDropdown.value = false
        if (field) {
            field.handleBlur(event)
        }
        emit('blur', event)
    }, 200)
}

const selectOption = (option: SelectOption) => {
    searchInput.value = ''
    const value = String(option.value)
    if (field) {
        field.setValue(value)
    } else {
        emit('update:modelValue', value)
    }
    emit('select', option)
    showDropdown.value = false
    selectedIndex.value = -1
}

const handleEnter = () => {
    if (selectedIndex.value >= 0 && filteredOptions.value[selectedIndex.value]) {
        selectOption(filteredOptions.value[selectedIndex.value])
    }
}

const handleArrowDown = () => {
    if (filteredOptions.value.length === 0) return
    selectedIndex.value = selectedIndex.value < filteredOptions.value.length - 1 ? selectedIndex.value + 1 : 0
    nextTick(() => {
        scrollToSelected()
    })
}

const handleArrowUp = () => {
    if (filteredOptions.value.length === 0) return
    selectedIndex.value = selectedIndex.value > 0 ? selectedIndex.value - 1 : filteredOptions.value.length - 1
    nextTick(() => {
        scrollToSelected()
    })
}

const handleEscape = () => {
    showDropdown.value = false
    selectedIndex.value = -1
}

const scrollToSelected = () => {
    const dropdown = document.querySelector('.absolute.z-50 ul')
    if (dropdown && selectedIndex.value >= 0) {
        const selectedElement = dropdown.children[selectedIndex.value] as HTMLElement
        if (selectedElement) {
            selectedElement.scrollIntoView({ block: 'nearest', behavior: 'smooth' })
        }
    }
}

watch(
    () => props.options,
    () => {
        if (props.options.length > 0 && searchInput.value) {
            showDropdown.value = true
        }
    },
    { deep: true },
)

watch(
    () => currentValue.value,
    (newValue) => {
        if (!newValue) {
            searchInput.value = ''
        }
    },
)

onMounted(() => {
    if (currentValue.value) {
        const selected = props.options.find((opt) => opt.value === currentValue.value)
        if (selected) {
            searchInput.value = props.getOptionLabel(selected)
        }
    }
})

onUnmounted(() => {
    if (debounceTimer) {
        clearTimeout(debounceTimer)
    }
})
</script>
