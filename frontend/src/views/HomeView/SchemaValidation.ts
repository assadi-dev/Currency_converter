import { number, object, string } from 'yup';


export const CurrencyFormSchema = object({
    amount:number().required("Champs obligatoire").positive("Le montant doit etre positive"),

   
})



export type ResultConversionType = {
    result?: string|null
    fromCurrencyCode?: string|null
    toCurrencyCode?: string|null
    fromCurrencyRate?: string|null
    toCurrencyRate?: string|null
    
    
}