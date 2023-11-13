import axios, { AxiosError, AxiosInstance } from "axios"
import { AUTH_KEY_STORAGE } from "../utils/storage"
import {getItem} from "../utils/storage.ts"


const BASE_URL = import.meta.env.VITE_SERVER_API_URL

/**
 * Instance api pour la partie non authentification
 */
export const instance:AxiosInstance = axios.create({
    baseURL: BASE_URL,
    headers: {
        "Content-Type":"application/json"
    }
})


const TOKEN_AUTHORIZATION = getItem(AUTH_KEY_STORAGE)




export const adminInstance:AxiosInstance = axios.create({
    baseURL: BASE_URL,
    headers: {
        "Content-Type": "application/json",
       
    }
})





adminInstance.interceptors.request.use(
    (request) => {
        request.headers.Authorization = `Bearer ${TOKEN_AUTHORIZATION?.token}`;
        return request;
    },
    (error: AxiosError) => {
      if (error.response) {
        const apiError = error.response?.data
        return Promise.reject(apiError)
      }
      return Promise.reject(error)
    }


  )
  