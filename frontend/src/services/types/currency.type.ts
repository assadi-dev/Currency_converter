
export type Currency= {
    id: Number
    code: string
    name: string
    created_at?: any
    updated_at?:any
    
}

export type CurrencyWithoutId = Omit<Currency, 'id'>

export type ApiCurrencySuccess = {
    data:Currency[]
}