
import { PairCurrencyType, PairCurrencyTypeWithoutId } from "../types/pairCurrency.type"
import { instance } from "./instance"


export const fetchAll = () => {
   return instance.get("/currency_convert_pairs")
}
export const fetchOne = (id:string) => {
   return instance.get(`/currency_convert_pairs/${id}`)
}

export const add = (data:PairCurrencyTypeWithoutId) => {
    return instance.post(`/currency_convert_pairs/code`,data)
 }

export const update = (id:string,data:PairCurrencyTypeWithoutId) => {
   return instance.put(`/currency_convert_pairs/${id}`,data)
}

export type APISuccess = {
    message: string
}

export type ApiPairCurrencySuccessAdd = APISuccess & {inserted:PairCurrencyType}