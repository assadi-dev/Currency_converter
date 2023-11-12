
export const AUTH_KEY_STORAGE = `${import.meta.env.VITE_APP_NAME}_auth_token`


export const setItem = (key:string, data:any) => {
  try {
    const dataToStore = JSON.stringify(data)
    localStorage.setItem(key, dataToStore)
    
    return dataToStore
  } catch (error) {
    throw new Error("Une reerur est survenue lors de l'enregistrement dans la mémoire local")
  }

}


export const getItem = (key: string) => {
    try {
      const result: any = localStorage.getItem(key)
      
        return JSON.parse(result)
        
    } catch (error) {
        throw new Error("Une reerur est survenue lors de la récuperation dans la mémoire local")

    }
}


export const clearStorage = (key?: string) => {
  if (key) return localStorage.removeItem(key)
  localStorage.clear()
}