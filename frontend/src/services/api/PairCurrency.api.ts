
import { AxiosError, AxiosResponse } from "axios"
import { PairCurrencyFormValue } from "../types/Form.types"
import { PairCurrencyForm, PairCurrencyType } from "../types/pairCurrency.type"
import { instance } from "./instance"


export const fetchAll = () => {
   return instance.get("/currency_convert_pairs")
}
export const fetchOne = (id:string) => {
   return instance.get(`/currency_convert_pairs/${id}`)
}

export const add = async (data:PairCurrencyFormValue):Promise<ApiPairCurrencySuccessAdd> => {

   return await instance.post(`/currency_convert_pairs/code`, data)

 }

export const update = (id:string,data:PairCurrencyFormValue) => {
   return instance.put(`/currency_convert_pairs/${id}`,data)
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