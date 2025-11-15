import { api } from '@/lib/client'
import type { ApiResponse } from '@/lib/types/api-types'
import type { UserPortfolioResource } from '@/lib/types/portfolio-types'

export async function fetchPortfoliosApi(): Promise<UserPortfolioResource[]> {
    const response = await api.get<ApiResponse<UserPortfolioResource[]>>('/user/portfolios')
    return response.data.data
}
