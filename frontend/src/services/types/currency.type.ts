
export type Currency= {
    id: Number,
    code: String,
    name:String
    
}

export type CurrencyWithoutId = Omit<Currency,'id'>