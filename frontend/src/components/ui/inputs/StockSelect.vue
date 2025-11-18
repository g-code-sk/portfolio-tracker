<template>
    <Select v-bind="$attrs" :name="name" :label="label" :options="options" :disabled="disabled" :hint="hint" />
</template>

<script setup lang="ts">
import Select from '@/components/ui/inputs/Select.vue'
import type { SelectOption } from '@/lib/types/generic-types'
import { computed } from 'vue'

const props = withDefaults(
    defineProps<{
        name?: string
        label?: string
        hint?: string
        disabled?: boolean
    }>(),
    {
        name: 'stockId',
        label: 'Stock',
        hint: 'Select a stock',
        disabled: false,
    },
)

// Dummy stock list
const dummyStocks: SelectOption[] = [
    { label: 'Apple Inc. (AAPL)', value: 'AAPL' },
    { label: 'Microsoft Corporation (MSFT)', value: 'MSFT' },
    { label: 'Amazon.com Inc. (AMZN)', value: 'AMZN' },
    { label: 'Alphabet Inc. (GOOGL)', value: 'GOOGL' },
    { label: 'Tesla Inc. (TSLA)', value: 'TSLA' },
    { label: 'Meta Platforms Inc. (META)', value: 'META' },
    { label: 'NVIDIA Corporation (NVDA)', value: 'NVDA' },
    { label: 'JPMorgan Chase & Co. (JPM)', value: 'JPM' },
    { label: 'Visa Inc. (V)', value: 'V' },
    { label: 'Johnson & Johnson (JNJ)', value: 'JNJ' },
]

const options = computed<SelectOption[]>(() => dummyStocks)
</script>
