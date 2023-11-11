
export type CurrencyType= {
    id?: Number
    code?: string
    name?: string
    count?: number
    created_at?: any
    updated_at?:any
    
}

export type CurrencyWithoutId = Omit<CurrencyType, 'id'>

export type ApiCurrencySuccess = {
    data:CurrencyType[]
}