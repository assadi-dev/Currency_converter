
import { clearStorage } from "../services/utils/storage"



export const useUserAuth = () => {
    

    const logout = () => {
        clearStorage()
      
    }

    const userCredential = {}
    
    return {
        logout,
        userCredential
    }
}