export interface SecurityResource {
    id: number
    symbol: string
    description: string
    displaySymbol: string
    type: string
}

export interface UserTransactionResource {
    id: number
    portfolioId: number
    security: SecurityResource
    amount: string
    price: string
    date: string
    fee: string
    formattedDate: string
    formattedAmount: string
    formattedPrice: string
    formattedFee: string
    formattedTotal: string
    createdAt: string
    updatedAt: string
}

export interface CreateUserTransactionPayloadData {
    portfolioId: number
    stockSymbol: string
    amount: number
    price: number
    date: string
    fee: number
}

export interface TransactionTypeInputResource {
    id: number
    name: string
}

export interface ImportUserTransactionsPayloadData {
    portfolioId: number
    brokerTypeId: number
    file: File
}

export interface ImportUserTransactionsResponse {
    headers: string[]
    data: Record<string, unknown>[]
    portfolioId: number
    rowCount: number
}
