<template>
    <Select v-bind="$attrs" :name="name" :label="label" :options="options" :disabled="isLoading || isLoadingPortfolios || disabled" :hint="hint" />
</template>

<script setup lang="ts">
import Select from '@/components/ui/inputs/Select.vue'
import { useUserPortfolios } from '@/composables/useUserPortfolios'
import type { SelectOption } from '@/lib/types/generic-types'
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
        name: 'portfolioId',
        label: 'Portfolio',
        hint: 'Select a portfolio',
        disabled: false,
        isLoading: false,
    },
)

const { portfolios, isLoading: isLoadingPortfolios, fetchUserPortfolios } = useUserPortfolios()

const options = computed<SelectOption[]>(() => {
    return portfolios.value.map((portfolio) => ({
        label: portfolio.name,
        value: portfolio.id,
    }))
})

onMounted(async () => {
    await fetchUserPortfolios()
})
</script>

