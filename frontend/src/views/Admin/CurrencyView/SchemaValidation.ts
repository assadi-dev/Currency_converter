import { object, string } from 'yup';


export const CurrencyForm = object({
    code:string().required("Code devise est obligatoire"),
    name:string().required("Nom de la devise est obligatoire"),
   
})


export type defaultFormCurrency = {
    code?: string
    name?:string
}