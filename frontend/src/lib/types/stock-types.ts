export interface FinnhubStockSearchItem {
    description: string
    displaySymbol: string
    symbol: string
    type: string
}

export interface FinnhubStockSearchResource {
    count: number
    items: FinnhubStockSearchItem[]
}
