import {CurrencyType, CurrencyWithoutId } from "../types/currency.type"
import { adminInstance } from "./instance"


export const fetchAll = () => {
   return adminInstance.get("/currencies")
}
export const fetchOne = (id:string) => {
   return adminInstance.get(`/currency/${id}`)
}

export const add = (data:Omit<CurrencyWithoutId, "created_at" | "updated_at">) => {
    return adminInstance.post(`/currency`,data)
 }

export const update = (id:string,data:Omit<CurrencyWithoutId, "created_at" | "updated_at">) => {
   return adminInstance.put(`/currency/${id}`,data)
}
export const remove = (id:string) => {
   return adminInstance.delete(`/currency/${id}`)
}

export type APISuccess = {
    message: string
}

export type ApiSuccessAdd = APISuccess & {inserted:CurrencyType}