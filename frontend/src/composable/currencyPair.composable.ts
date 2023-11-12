import { ref } from "vue"
import * as pairCurrencyApi from "../services/api/PairCurrency.api"
import { ApiPairCurrencySuccess } from "../services/types/pairCurrency.type"


export const useFetchPairCurrencies = () => {

 
  
  //const props = def

    const pairCurrencies = ref<ApiPairCurrencySuccess | null>(null)

    const error = ref<string | null>(null)
  
    const isLoading = ref(false)
  

    async function fetchData(page:number) {
        isLoading.value = true
    
      try {
          const params = {page}
          const response = await pairCurrencyApi.fetchAll(params)
          pairCurrencies.value = response.data
        } catch (err: unknown) {
          error.value = (err as Error).message
        } finally {
          isLoading.value = false
        }
      }
    fetchData(1)
    
    return {
        pairCurrencies,
        error,
      isLoading,
      fetchData
    }

}