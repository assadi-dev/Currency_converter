import { ref } from "vue"
import { ApiCurrencySuccess, ApiCurrencyListSuccess } from "../services/types/currency.type"
import * as CurrencyApi from "../services/api/Currency.api"


export const useFetchCurrencies = () => {
    const currencies = ref<ApiCurrencySuccess[] | null>(null)

    const error = ref<string | null>(null)
  
    const isLoading = ref(false)
    async function fetchData(page?:number) {
        isLoading.value = true
    
      try {
        if (page) {
          const params = {page}
          const response = await CurrencyApi.fetchAll(params)
          currencies.value = response.data
          }
       
        } catch (err: unknown) {
          error.value = (err as Error).message
        } finally {
          isLoading.value = false
        }
      }
    
      fetchData(1)
      return { currencies, error, isLoading,fetchData  }

}


export const useFetchListCurrencies = () => {

  const currencyList = ref<ApiCurrencyListSuccess| null>(null)

  const error = ref<string | null>(null)

  const isLoading = ref(false)

  const fetchingData = async () => {
    try {
      isLoading.value = true
      const response = await CurrencyApi.fetchListOfCurrencies()
      currencyList.value = response.data
  
    } catch (err:unknown) {
      error.value = (err as Error).message
    } finally {
      isLoading.value = false
    }
  
  }
  
  fetchingData()

  return { currencyList, error, isLoading}
}