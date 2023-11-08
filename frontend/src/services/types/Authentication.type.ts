export type UserLogin ={
    email?: string
    password?:string
    
}

export type ApiUserLoginResponse ={
    message?:string
    token:string
}