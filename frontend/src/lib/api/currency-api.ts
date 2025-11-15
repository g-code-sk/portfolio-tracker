import { api } from '@/lib/client'
import type { ApiResponse } from '@/lib/types/api-types'
import type { CurrencySelectOption } from '@/lib/types/currency-types'

export async function fetchCurrenciesApi(): Promise<CurrencySelectOption[]> {
    const response = await api.get<ApiResponse<CurrencySelectOption[]>>('/currencies')
    return response.data.data
}
