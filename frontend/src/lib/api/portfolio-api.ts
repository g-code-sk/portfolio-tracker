import { api } from '@/lib/client'
import type { ApiResponse } from '@/lib/types/api-types'
import type { CreateUserPortfolioPayloadData, UserPortfolioResource } from '@/lib/types/portfolio-types'

export async function fetchUserPortfoliosApi(): Promise<UserPortfolioResource[]> {
    const response = await api.get<ApiResponse<UserPortfolioResource[]>>('/user/portfolios')
    return response.data.data
}

export async function createUserPortfolioApi(data: CreateUserPortfolioPayloadData): Promise<UserPortfolioResource> {
    const response = await api.post<ApiResponse<UserPortfolioResource>>('/user/portfolios', data)
    return response.data.data
}

export async function fetchUserPortfolioApi(id: number): Promise<UserPortfolioResource> {
    const response = await api.get<ApiResponse<UserPortfolioResource>>(`/user/portfolios/${id}`)
    return response.data.data
}

export async function deleteUserPortfolioApi(id: number): Promise<void> {
    await api.delete(`/user/portfolios/${id}`)
}
