<template>
    <Autocomplete
        v-bind="$attrs"
        :name="name"
        :label="label"
        :options="stockOptions"
        :disabled="disabled"
        :hint="hint"
        :is-loading="isLoading"
        :placeholder="placeholder"
        :on-search="handleSearch"
        @select="handleSelect"
    >
        <template #option="{ option }">
            <div class="flex flex-col">
                <span class="font-medium">{{ option.label }}</span>
                <span v-if="option.description" class="text-xs text-gray-500">{{ option.description }}</span>
            </div>
        </template>
    </Autocomplete>
</template>

<script setup lang="ts">
import Autocomplete from '@/components/ui/inputs/Autocomplete.vue'
import { searchStocksApi } from '@/lib/api/stock-api'
import type { SelectOption } from '@/lib/types/generic-types'
import type { FinnhubStockSearchItem } from '@/lib/types/stock-types'
import { computed, ref } from 'vue'

const props = withDefaults(
    defineProps<{
        name?: string
        label?: string
        hint?: string
        disabled?: boolean
        placeholder?: string
    }>(),
    {
        name: 'stockSymbol',
        label: 'Stock',
        hint: 'Search for a stock by name or symbol',
        disabled: false,
        placeholder: 'Type to search stocks...',
    },
)

const searchQuery = ref('')
const searchResults = ref<FinnhubStockSearchItem[]>([])
const selectedStock = ref<FinnhubStockSearchItem | null>(null)
const isLoading = ref(false)

const stockOptions = computed<SelectOption[]>(() => {
    const options = searchResults.value.map((item) => ({
        label: `${item.description} (${item.displaySymbol})`,
        value: item.symbol,
        description: item.type,
    }))

    // Include selected stock if it's not in search results
    if (selectedStock.value && !searchResults.value.find((item) => item.symbol === selectedStock.value?.symbol)) {
        options.unshift({
            label: `${selectedStock.value.description} (${selectedStock.value.displaySymbol})`,
            value: selectedStock.value.symbol,
            description: selectedStock.value.type,
        })
    }

    return options
})

const handleSearch = async (query: string) => {
    searchQuery.value = query

    if (!query || query.length < 2) {
        searchResults.value = []
        return
    }

    isLoading.value = true

    try {
        const response = await searchStocksApi(query)
        searchResults.value = response.items || []

        // Update selectedStock if the current value matches a search result
        // This helps preserve the selected stock display when searching
        if (selectedStock.value) {
            const found = searchResults.value.find((item) => item.symbol === selectedStock.value?.symbol)
            if (found) {
                selectedStock.value = found
            }
        }
    } catch (error) {
        console.error('Failed to search stocks:', error)
        searchResults.value = []
    } finally {
        isLoading.value = false
    }
}

const handleSelect = (option: SelectOption) => {
    // Find the stock item that matches the selected option
    const stock = searchResults.value.find((item) => item.symbol === option.value)
    if (stock) {
        selectedStock.value = stock
    }
}
</script>
