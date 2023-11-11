<script setup lang="ts"  >
import InputNumber from "primevue/inputnumber"
import Dropdown from 'primevue/dropdown';
import { computed, ref } from 'vue';
import Button from 'primevue/button';

import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import { useForm, useField } from "vee-validate";
import { ErrorWithMessage } from "../../services/types/Other"
import { useFetchListCurrencies } from "../../composable/currency.composable";
import { CurrencyList } from "../../services/types/currency.type";
import Message from "primevue/message";
import * as CurrencyApi from "../../services/api/Currency.api"
import InputText from "primevue/inputtext";
import {CurrencyFormSchema,ResultConversionType} from "./SchemaValidation"

const { currencyList, isLoading, error } = useFetchListCurrencies()

const { handleSubmit,defineInputBinds, errors } = useForm({
    initialValues:{amount:1.00,fromCurrency:null,toCurrency:null},
    validationSchema: CurrencyFormSchema
});



const fromCurrency = useField("fromCurrency")
const toCurrency = useField("toCurrency")
const amount = defineInputBinds("amount")
const isSwitch = ref(false)
const toast = useToast()
const isProcess = ref(false)

const stateResultConversion = ref<ResultConversionType | null>({fromCurrencyCode:"",toCurrencyCode:"",fromCurrencyRate:"",toCurrencyRate:"",result:""})


const currencyOption = computed<CurrencyList[] | []>(() => {
    let list = currencyList?.value?.data

    if (list) {
        return [...list]?.map(v => {
            return { code: v.code, name: `${v.code}-${v.name}` }

        })

    }

    return []

});





const onSubmitConvert = handleSubmit(async values => {

    try {
    
        
        const fromCurrency = values?.fromCurrency?.code
        const toCurrency = values?.toCurrency?.code
        const amount = values?.amount
        isProcess.value = true
        if (!fromCurrency || !toCurrency) {
            throw new Error("Veuillez definir les devises ");
        }
        if (fromCurrency === toCurrency) {
            throw new Error("Les devises doivent etres differentes");

        }

        //Procedure de la conversion
        if (amount && fromCurrency && toCurrency ) {
            const result = await CurrencyApi.convertCurrency(fromCurrency, toCurrency, amount)
            stateResultConversion.value.fromCurrencyCode = result.data.from
            stateResultConversion.value.toCurrencyCode = result.data.to
            stateResultConversion.value.result = result.data.result
            stateResultConversion.value.fromCurrencyRate = `1 ${result.data.from} = ${result.data.pairCurrency} ${result.data.to}`
            stateResultConversion.value.toCurrencyRate = `1 ${result.data.to} = ${calculateReverseRateCurrency(result.data.pairCurrency)} ${result.data.from}`
            
        }
     







    } catch (err: ErrorWithMessage | any) {
        console.log(err);
        
        toast.add({ severity: 'error', summary: 'Erreur', detail: err.message, group: "bc", life: 3000 });
    } finally {
        isProcess.value = false
    }
})



const calculateReverseRateCurrency = (pairCurrency:number) => {
    return  (1/Number(pairCurrency)).toFixed(5)
}



const switchCurrency = () => {
    const from = fromCurrency.value.value
    const to = toCurrency.value.value

    try {
        if (!from && !to) {
            throw new Error("Veuillez selectionnez les devises");
        }
        fromCurrency.setValue(to)
        toCurrency.setValue(from)


    } catch (error: ErrorWithMessage | any) {

        toast.add({ severity: 'error', summary: 'Erreur', detail: error.message, group: "bc", life: 3000 });

    }

}





</script>
<template>
    <div class="surface-ground flex align-items-center justify-content-center page-container ">


        <div class="flex flex-column align-items-center justify-content-center">

            <!--<img :src="logoUrl" alt="logo" class="mb-5 w-6rem flex-shrink-0" />-->
            <div
                style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">

                <div class="w-full surface-card py-8 px-3 sm:px-8" style="border-radius: 53px">
                    <div class="error-section">
                        <Message v-if="error" severity="error">{{ error }}</Message>
                    </div>
                    <form v-if="!error" @submit="onSubmitConvert">
                        <div class="mb-5">
                            <!--  <img src="/demo/images/login/avatar.png" alt="Image" height="50" class="mb-3" />-->
                            <div class="field text-center w-full md:w-18rem mx-auto">
                                <label for="amount" class="block text-900 text-xl font-medium mb-2">Montant</label>
                                <InputText v-bind="amount" name="amount"
                                    :class="['text-center input-select w-full md:w-18rem', errors.amount && 'p-invalid']"
                                    id="amount" autofocus placeholder="1.00" />
                                <small class="p-error" id="amount">{{ errors.amount || '&nbsp;' }}</small>

                            </div>

                        </div>

                        <div class="row-select-input">
                            <div class="input-container">
                                <label for="fromCurrency" class="block text-900 text-xl font-medium mb-2">De </label>
                                <Dropdown :loading="isLoading" v-if="!isSwitch" v-model="fromCurrency.value.value" filter
                                    :options="currencyOption" optionLabel="name" placeholder="Selectionner une devise"
                                    :class="['input-select w-full md:w-18rem']" />
                            </div>
                            <div class="switch-section ">


                                <Button icon="pi pi-arrow-right-arrow-left" severity="info" rounded outlined size="large"
                                    aria-label="Switch currency" @click="switchCurrency" />

                            </div>
                            <div class="input-container">
                                <label for="toCurrency" class="block text-900 text-xl font-medium mb-2">Vers</label>
                                <Dropdown :loading="isLoading" v-if="!isSwitch" v-model="toCurrency.value.value" filter
                                    :options="currencyOption" optionLabel="name" placeholder="Selectionner une devise"
                                    :class="['input-select w-full md:w-18rem']" />
                            </div>

                        </div>

                        <div class="row-footer  mt-5 gap-5">
                            <div class="result-section">
                                <p v-if="stateResultConversion"  class="text-900 text-3xl font-medium mb-3">{{ `${stateResultConversion.result}  ${stateResultConversion.toCurrencyCode}`}}</p>
                                <small v-if="stateResultConversion"  >{{stateResultConversion.fromCurrencyRate  }}</small>
                                <small v-if="stateResultConversion" >{{stateResultConversion.toCurrencyRate}}</small>
                            </div>
                            <Button :loading="isProcess" type="submit" label="Convertir" class="py-3 px-5 text-xl"
                                aria-label="Convertir" />
                        </div>

                    </form>


                </div>

            </div>
        </div>
        <Toast position="bottom-center" group="bc" />
    </div>
</template>


<style  scoped>
.error-section {
    min-width: 100%;
}

.page-container {
    height: 100vh;
    width: 100%;
    overflow: hidden;
}

.row-select-input {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 1rem 0;
    align-items: center;
    grid-gap: 1rem;
}

.input-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    width: 100%;

}

.switch-section {
    display: grid;
    place-items: center;
    min-width: 10rem;
    justify-self: center;
    align-self: center;
    text-align: center;
}


.row-footer {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.result-section {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/** Responsive **/

@media screen and (min-width: 992px) {

    .error-section {
        min-width: 32rem;
    }

    .row-select-input {
        display: grid;
        grid-template-columns: 1fr 0.25fr 1fr;


    }

    .result-section{
       align-items: flex-start;
    }

    .row-footer {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}
</style>