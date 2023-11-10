import { ref } from "vue"
import * as pairCurrencyApi from "../services/api/PairCurrency.api"
import { ApiPairCurrencySuccess } from "../services/types/pairCurrency.type"


export const useFetchPairCurrencies = () => {
    const pairCurrencies = ref<ApiPairCurrencySuccess | null>(null)

    const error = ref<string | null>(null)
  
    const isLoading = ref(false)
    async function fetchData() {
        isLoading.value = true
    
        try {
          const response = await pairCurrencyApi.fetchAll()
          pairCurrencies.value = response.data
        } catch (err: unknown) {
          error.value = (err as Error).message
        } finally {
          isLoading.value = false
        }
      }
    
      fetchData()
    return {
        pairCurrencies,
        error,
        isLoading
    }

}