<template>
    <Select v-bind="$attrs" :name="name" :label="label" :options="options" :disabled="isLoading || isLoadingCurrencies || disabled" :hint="hint" />
</template>

<script setup lang="ts">
import Select from '@/components/ui/inputs/Select.vue'
import { useCurrencies } from '@/composables/useCurrencies'
import type { CurrencySelectOption } from '@/lib/types/currency-types'
import { computed, onMounted } from 'vue'

const props = withDefaults(
    defineProps<{
        name?: string
        label?: string
        hint?: string
        disabled?: boolean
        isLoading?: boolean
    }>(),
    {
        name: 'currency',
        label: 'Base Currency',
        hint: 'Select the base currency for this portfolio',
        disabled: false,
        isLoading: false,
    },
)

const { currencies, isLoading: isLoadingCurrencies, fetchCurrencies } = useCurrencies()

const options = computed<CurrencySelectOption[]>(() => currencies.value)

onMounted(async () => {
    await fetchCurrencies()
})
</script>
