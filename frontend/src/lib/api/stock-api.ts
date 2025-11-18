import { api } from '@/lib/client'
import type { ApiResponse } from '@/lib/types/api-types'
import type { FinnhubStockSearchResource } from '@/lib/types/stock-types'

export async function searchStocksApi(query: string): Promise<FinnhubStockSearchResource> {
    const response = await api.get<ApiResponse<FinnhubStockSearchResource>>('/finnhub/stocks/search', {
        params: { q: query },
    })
    return response.data.data
}
