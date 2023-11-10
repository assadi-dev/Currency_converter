import { object, string, number, date, InferType } from 'yup';


export const PairCurrencyForm = object({
    idFromCurrency:number().nullable(),
    codeFromCurrency:string().required("Code devise entrant est obligatoire"),
    nameFromCurrency: string().required("Nom de la devise sortant est obligatoire"),
    idToCurrency:number().nullable(),
    codeToCurrency: string().required("Code devise sortant est obligatoire"),
    nameToCurrency: string().required("Nom de la devise sortant est obligatoire"),
    exchange_rate: number().positive().required("le taux d'echange est obligatoire"),
})


