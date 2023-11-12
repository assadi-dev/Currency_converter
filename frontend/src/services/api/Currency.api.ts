import {ApiConvertSuccess, CurrencyType, CurrencyWithoutId } from "../types/currency.type"
import { adminInstance } from "./instance"


export const fetchAll = (params:any) => {

   
   return adminInstance.get("/currencies",{params})
}

export const fetchByPaginate = (page:number) => {
   return adminInstance.get("/currencies",{params:{page}})
}

export const fetchListOfCurrencies = () => {
   return adminInstance.get(`/currencies/lists`)
}

export const fetchOne = (id:any) => {
   return adminInstance.get(`/currency/${id}`)
}

export const add = (data:Omit<CurrencyWithoutId, "created_at" | "updated_at">) => {
    return adminInstance.post(`/currency`,data)
 }

export const update = (id:any,data:Omit<CurrencyWithoutId, "created_at" | "updated_at">) => {
   return adminInstance.put(`/currency/${id}`,data)
}
export const remove = (id:any) => {
   return adminInstance.delete(`/currency/${id}`)
}


export const convertCurrency = (from:string,to:string,amount:number):Promise<ApiConvertSuccess> => {
   return adminInstance.get(`/currency_converter/${from}/${to}/${amount}`)
}


export type APISuccess = {
    message: string
}

export type ApiSuccessAdd = APISuccess & {inserted:CurrencyType}