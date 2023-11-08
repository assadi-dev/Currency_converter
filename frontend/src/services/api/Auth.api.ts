import { AxiosResponse } from "axios"
import { ApiUserLoginResponse, UserLogin } from "../types/Authentication.type"
import { instance } from "./instance"


export const userConnect = async (body:UserLogin):Promise<ApiUserLoginResponse> => {
    const res:AxiosResponse = await instance.post(`/auth/login`, body)
    return res.data
}