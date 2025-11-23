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
