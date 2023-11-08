import { ref } from "vue"
import { Currency } from "../services/types/currency.type"
import * CurrencyApi from "../services/api/Currency.api"


export const useFetchCurrencies = () => {
    const currencies = ref<Currency[] | null>(null)

    const error = ref<String | null>(null)
  
    const isLoading = ref(false)
    async function fetchData() {
        isLoading.value = true
    
        try {
          const response = await CurrencyApi.fetchAll()
          currencies.value = response
        } catch (err: unknown) {
          error.value = (err as Error).message
        } finally {
          isLoading.value = false
        }
      }
    
      fetchData()
      return { currencies, error, isLoading }

}