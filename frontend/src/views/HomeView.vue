<script setup lang="ts"  >
import InputNumber from "primevue/inputnumber"
import Dropdown from 'primevue/dropdown';
import { ref } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import { useForm, useField } from "vee-validate";
import {ErrorWithMessage} from "../services/types/Other"


const { handleSubmit, setValues} = useForm();

const fromCurrency = useField("fromCurrency")
const toCurrency = useField("toCurrency")
const isSwitch = ref(false)
const toast = useToast()
const isProcess = ref(false)




const onSubmitConvert = handleSubmit(values => {
   
try {
    const fromCurency = values.fromCurrency?.code
    const toCurency = values.toCurrency?.code
    isProcess.value = true
    if (!fromCurency || !toCurency) {
        throw new Error("Veuillez definir les devises ");
    }

    //Procedure de la conversion
    console.log(fromCurency,toCurency);
    


} catch (error:ErrorWithMessage| any) {
    toast.add({ severity: 'error', summary: 'Erreur', detail: error.message,group:"bc" ,life: 3000 });
} finally {
    isProcess.value = false
}
})



const currencyOption = ref([
    { name: 'Euro', code: 'EUR' },
    { name: 'Livre sterling britannique', code: 'GBP' },
    { name: 'Dollar des Etat unies', code: 'USD' },
    { name: 'Maroc Dirham', code: 'MAD' },
    { name: 'Franc', code: 'FRA' }
]);



const switchCurrency = () => {
    const from = fromCurrency.value.value
    const to = toCurrency.value.value

    try {
        if (!from && !to) {
            throw new Error("Veuillez selectionnez les devises");
        }
        fromCurrency.setValue(to) 
        toCurrency.setValue(from)

   
 } catch (error:ErrorWithMessage|any) {

        toast.add({ severity: 'error', summary: 'Erreur', detail: error.message,group:"bc" ,life: 3000 });

    }
 
}





</script>
<template>
  
    <div class="surface-ground flex align-items-center justify-content-center page-container ">
       
        <div class="flex flex-column align-items-center justify-content-center">
            <!--<img :src="logoUrl" alt="logo" class="mb-5 w-6rem flex-shrink-0" />-->
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)" >

                <div class="w-full surface-card py-8 px-3 sm:px-8" style="border-radius: 53px">
                    <form @submit="onSubmitConvert">
                        <div class="text-center mb-5">
                            <!--  <img src="/demo/images/login/avatar.png" alt="Image" height="50" class="mb-3" />-->
                            <div class="text-900 text-3xl font-medium mb-3">Convertisseur de devises</div>
                        </div>

                        <div  class="row-select-input">
                            <div class="input-container">
                                <label for="fromCurrency" class="block text-900 text-xl font-medium mb-2">De </label>
                                <Dropdown v-if="!isSwitch" v-model="fromCurrency.value.value"  editable :options="currencyOption" optionLabel="name" placeholder="Selectionner une devise" class="input-select w-full md:w-14rem " />
                            </div>
                            <div class="switch-section " >

                      
                                <Button icon="pi pi-arrow-right-arrow-left"  severity="info" rounded outlined size="large" aria-label="Switch currency" @click="switchCurrency"  />

                            </div>
                            <div class="input-container">
                                <label for="toCurrency" class="block text-900 text-xl font-medium mb-2">Vers</label>
                                <Dropdown v-if="!isSwitch" v-model="toCurrency.value.value"  editable :options="currencyOption" optionLabel="name" placeholder="Selectionner une devise" class="input-select w-full md:w-14rem" />
                            </div>

                        </div>

                        <div class="flex align-items-center justify-content-between mt-5 gap-5"> 
                            <Button :loading="isProcess" type="submit" label="Convertir" class="mx-auto py-3 px-5 text-xl" aria-label="Convertir" />
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <Toast  position="bottom-center" group="bc" />
    </div>
</template>


<style  scoped>
.page-container {
    height: 100vh;
    width: 100%;
    overflow: hidden;
}

.row-select-input
{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 1rem 0;
    align-items: center;
    grid-gap: 1rem;
}

.input-container{
    display: flex;
    flex-direction: column;
align-items: flex-start;
justify-content: center;
width: 100%;

}

.switch-section
{
    display: grid;
    place-items: center;
   min-width: 10rem;
   justify-self: center;
   align-self: center;
   text-align: center;
}

/** Responsive **/

@media screen and (min-width: 992px) {

    .row-select-input{
        display: grid;
        grid-template-columns: 1fr 0.25fr 1fr;
      

    }
}


</style>