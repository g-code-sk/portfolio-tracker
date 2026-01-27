import { fetchUserPortfoliosApi } from '@/lib/api/portfolio-api'
import type { UserPortfolioResource } from '@/lib/types/portfolio-types'
import { ref } from 'vue'
import { useToast } from 'vue-toastification'

const portfolios = ref<UserPortfolioResource[]>([])
const isLoading = ref(false)
const isLoaded = ref(false)
const toast = useToast()

async function fetchUserPortfolios(force = false): Promise<void> {
    if (isLoading.value) {
        return
    }

    if (isLoaded.value && !force) {
        return
    }

    try {
        isLoading.value = true
        portfolios.value = await fetchUserPortfoliosApi()
        isLoaded.value = true
    } catch (error) {
        toast.error('Unable to load portfolios. Please try again.')
        throw error
    } finally {
        isLoading.value = false
    }
}

async function refreshUserPortfolios(): Promise<void> {
    await fetchUserPortfolios(true)
}

function hasNoPortfolios(): boolean {
    return portfolios.value.length === 0
}

export function useUserPortfolios() {
    return {
        portfolios,
        isLoading,
        isLoaded,
        fetchUserPortfolios,
        refreshUserPortfolios,
        hasNoPortfolios,
    }
}
