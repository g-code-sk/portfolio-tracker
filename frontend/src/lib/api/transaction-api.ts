import { api } from '@/lib/client'
import type { ApiResponse } from '@/lib/types/api-types'
import type {
    CreateUserTransactionPayloadData,
    ImportUserTransactionsPayloadData,
    ImportUserTransactionsResponse,
    UserTransactionResource,
} from '@/lib/types/transaction-types'

export async function fetchUserTransactionsApi(): Promise<UserTransactionResource[]> {
    const response = await api.get<ApiResponse<UserTransactionResource[]>>('/user/transactions')
    return response.data.data
}

export async function fetchUserPortfolioTransactionsApi(portfolioId: number): Promise<UserTransactionResource[]> {
    const response = await api.get<ApiResponse<UserTransactionResource[]>>(`/user/portfolios/${portfolioId}/transactions`)
    return response.data.data
}

export async function createUserTransactionApi(data: CreateUserTransactionPayloadData): Promise<UserTransactionResource> {
    const response = await api.post<ApiResponse<UserTransactionResource>>('/user/transactions', data)
    return response.data.data
}

export async function importUserTransactionsApi(data: ImportUserTransactionsPayloadData): Promise<ImportUserTransactionsResponse> {
    const formData = new FormData()

    // formData is used to send the file to the server
    formData.append('portfolioId', data.portfolioId.toString())
    formData.append('brokerId', data.brokerId.toString())
    formData.append('file', data.file)

    const response = await api.post<ApiResponse<ImportUserTransactionsResponse>>('/user/transactions/import', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })

    return response.data.data
}
