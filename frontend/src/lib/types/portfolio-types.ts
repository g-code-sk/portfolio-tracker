export interface UserPortfolioResource {
    id: number
    name: string
    baseCurrency: string
    totalValue: number
    changePct: number
    assetCount: number
}

export interface CreateUserPortfolioPayloadData {
    name: string
    currency_id: number
}
