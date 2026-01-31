import { api } from '@/lib/client'
import type { ApiResponse } from '@/lib/types/api-types'
import type { SelectOption } from '@/lib/types/generic-types'

export async function fetchBrokerTypesInputApi(): Promise<SelectOption[]> {
    const response = await api.get<ApiResponse<SelectOption[]>>('/broker-types/input')
    return response.data.data
}
