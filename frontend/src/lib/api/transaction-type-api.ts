import { api } from '@/lib/client'
import type { ApiResponse } from '@/lib/types/api-types'
import type { SelectOption } from '@/lib/types/generic-types'

export async function fetchTransactionTypesInputApi(): Promise<SelectOption[]> {
    const response = await api.get<ApiResponse<SelectOption[]>>('/transaction-types/input')
    return response.data.data
}
