import axios, { AxiosInstance } from "axios"

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

export const adminInstance:AxiosInstance = axios.create({
    baseURL: BASE_URL,
    headers: {
        "Content-Type": "application/json",
        "Authorization":`bearer 123sdqdqsqs`
    }
})