import { fetchCurrenciesApi } from '@/lib/api/currency-api'
import type { CurrencySelectOption } from '@/lib/types/currency-types'
import { ref } from 'vue'
import { useToast } from 'vue-toastification'

const currencies = ref<CurrencySelectOption[]>([])
const isLoading = ref(false)
const isLoaded = ref(false)
const toast = useToast()

async function fetchCurrencies(force = false) {
    if (isLoading.value) {
        return
    }

    if (isLoaded.value && !force) {
        return
    }

    try {
        isLoading.value = true
        const data = await fetchCurrenciesApi()
        currencies.value = data
        isLoaded.value = true

        if (!data.length) {
            toast.warning('No currencies available yet. Please add one first.')
        }
    } catch (error) {
        toast.error('Unable to load currencies. Please try again.')
        throw error
    } finally {
        isLoading.value = false
    }
}

export function useCurrencies() {
    return {
        currencies,
        isLoading,
        isLoaded,
        fetchCurrencies,
    }
}
