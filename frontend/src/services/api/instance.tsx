import axios from "axios"

const BASE_URL = import.meta.env.VITE_SERVER_API_URL

/**
 * Instance api pour la partie non authentification
 */
export const instance = axios.create({
    baseURL: BASE_URL,
    headers: {
        "Content-Type":"application/json"
    }
})

export const adminInstance = axios.create({
    baseURL: BASE_URL,
    headers: {
        "Content-Type": "application/json",
        "Authorization":`bearer 123sdqdqsqs`
    }
})