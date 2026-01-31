import { api } from '@/lib/client'
import type { ApiResponse } from '@/lib/types/api-types'
import type { SelectOption } from '@/lib/types/generic-types'

export async function fetchBrokersInputApi(): Promise<SelectOption[]> {
    const response = await api.get<ApiResponse<SelectOption[]>>('/brokers/input')
    return response.data.data
}
