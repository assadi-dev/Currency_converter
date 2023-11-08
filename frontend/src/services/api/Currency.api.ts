import { Currency, CurrencyWithoutId } from "../types/currency.type"
import { instance } from "./instance"


export const fetchAll = () => {
   return instance.get("/currencies")
}
export const fetchOne = (id:String) => {
   return instance.get(`/currency/${id}`)
}

export const add = (data:CurrencyWithoutId) => {
    return instance.post(`/currencies`,data)
 }

export const update = (id:String,data:CurrencyWithoutId) => {
   return instance.put(`/currencies/${id}`,data)
}

export type APISuccess = {
    message: string
}

export type ApiSuccessAdd = APISuccess & {inserted:Currency}