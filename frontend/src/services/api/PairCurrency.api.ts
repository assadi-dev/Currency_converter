
import { AxiosError, AxiosResponse } from "axios"
import { PairCurrencyFormValue } from "../types/Form.types"
import { PairCurrencyForm, PairCurrencyType } from "../types/pairCurrency.type"
import { adminInstance } from "./instance.tsx"


export const fetchAll = () => {
   return adminInstance.get("/currency_convert_pairs")
}
export const fetchOne = (id:string) => {
   return adminInstance.get(`/currency_convert_pair/${id}`)
}

export const add = (data:PairCurrencyFormValue):Promise<ApiPairCurrencySuccessAdd> => {

   return adminInstance.post(`/currency_convert_pair/code`, data)

 }

export const update = (id:string,data:PairCurrencyFormValue) => {
   return adminInstance.put(`/currency_convert_pair/${id}`,data)
}

export const remove = async (id: string) => {
   return adminInstance.delete(`/currency_convert_pair/${id}`)
}

export type APISuccess = {
 
}
   
   type ResponseData = {
       message:string
      data: PairCurrencyType
    }
   

export type ApiPairCurrencySuccessAdd = Omit<AxiosResponse,"data"> & {
   data: ResponseData
}