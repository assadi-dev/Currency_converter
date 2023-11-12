
import { AxiosError, AxiosResponse } from "axios"
import { PairCurrencyFormValue } from "../types/Form.types"
import { PairCurrencyType } from "../types/pairCurrency.type"
import { adminInstance } from "./instance.tsx"


export const fetchAll = (params) => {
   return adminInstance.get(`/currency_convert_pairs`,{params})
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

export const remove = (id: string) => {
   return adminInstance.delete(`/currency_convert_pair/${id}`)
}

export const removeMultiple = async (collections: PairCurrencyType[]) =>
   {
   const promiseList = []

   for (const item of collections) {
      const id = item.id
      const endpoint = adminInstance.delete(`/currency_convert_pair/${id}`)
      promiseList.push(endpoint)
   }


   return Promise.all(promiseList)


         
   }

export type APISuccess = {
 
}
   
   type ResponseData = {
       message:string
      data: [PairCurrencyType]
    }
   

export type ApiPairCurrencySuccessAdd = Omit<AxiosResponse,"data"> & {
   data: ResponseData
}