import { ref } from "vue"
import { Currency,ApiCurrencySuccess } from "../services/types/currency.type"
import * as CurrencyApi from "../services/api/Currency.api"


export const useFetchCurrencies = () => {
    const currencies = ref<ApiCurrencySuccess[] | null>(null)

    const error = ref<string | null>(null)
  
    const isLoading = ref(false)
    async function fetchData() {
        isLoading.value = true
    
        try {
          const response = await CurrencyApi.fetchAll()
          currencies.value = response.data
        } catch (err: unknown) {
          error.value = (err as Error).message
        } finally {
          isLoading.value = false
        }
      }
    
      fetchData()
      return { currencies, error, isLoading }

}