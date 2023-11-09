
/**
 * Formulaire de paire de conversion
 */

export type PairCurrencyFormValue = {
    idFromCurrency?:number
    codeFromCurrency?: string
    nameFromCurrency?: string
    idToCurrency?:number
    codeToCurrency?: string
    nameToCurrency?: string
    exchange_rate?: number
}
