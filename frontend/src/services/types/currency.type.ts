
export type Currency= {
    id: Number,
    code: string,
    name:string
    
}

export type CurrencyWithoutId = Omit<Currency,'id'>