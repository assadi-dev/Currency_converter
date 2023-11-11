<script setup lang="ts">
import InputText from 'primevue/inputtext';
import Button from "primevue/button"
import { onMounted, ref, watch } from 'vue';
import PairCurrencyFormValue from '../../../services/types/Form.types'
import { useField, useForm } from 'vee-validate';
import { PairCurrencyForm } from "./SchemaValidation"
import InlineMessage from 'primevue/inlinemessage';
import { PairCurrencyType } from '../../../services/types/pairCurrency.type';



const props = defineProps<FormPropsType>()

type FormPropsType = {
    values?:Omit<PairCurrencyType,"id" | "count">
    onSubmit?: Function
    onCancel?: Function
    isLoading?: boolean
}



const { errors, defineInputBinds, handleSubmit } = useForm({
    initialValues:props.values,
    validationSchema:PairCurrencyForm
});


const emit = defineEmits(["formValues"])


    const codeFromCurrency= defineInputBinds("codeFromCurrency")
    const nameFromCurrency= defineInputBinds("nameFromCurrency")
    const codeToCurrency= defineInputBinds("codeToCurrency")
    const nameToCurrency= defineInputBinds("nameToCurrency")
    const exchange_rate= defineInputBinds("exchange_rate")


const save = handleSubmit(values => {
  
    emit("formValues",values)
})

</script>

<template>

        <form @submit="save" >
            <div class="field text-center mb-3">
                <i class="my-3"> <span class="pi-exclamation-circle pi pi-fw" style="font-size: 1rem"  ></span> Seule le taux d'échange est modifiable </i>
            </div>

            <div class="field">
                <label for="codeFromCurrency">Code devise entrant</label>
                <InputText :class="errors.codeFromCurrency && 'p-invalid'"  v-bind="codeFromCurrency" id="codeFromCurrency" name="codeFromCurrency"   placeholder="EX: EUR, GBR," disabled  />
               
            </div>
        <div class="field">
            <label for="nameFromCurrency">Nom devise entrant</label>
            <InputText v-bind="nameFromCurrency" id="nameFromCurrency" name="nameFromCurrency"  placeholder="Nom de la devise entrant" disabled />
        </div>
            <div class="field">
                <label for="codeToCurrency">Code devise sortant</label>
                <InputText  v-bind="codeToCurrency" id="codeToCurrency" name="codeToCurrency"   placeholder="EX: EUR, GBR, " disabled  />
               
            </div>
        <div class="field">
            <label for="nameToCurrency">Nom devise sortant</label>
            <InputText v-bind="nameToCurrency" id="nameToCurrency" nam="nameToCurrency"  placeholder="Nom de la devise sortant" disabled />
         

        </div>
        <div class="field">
            <label for="exchange_rate">Taux d'echange</label>
            <InputText v-bind="exchange_rate" id="exchange_rate" name="exchange_rate"  placeholder="0.00000" />
            <small class="p-error" id="texchange_rate">{{ errors.exchange_rate || '&nbsp;' }}</small>

        </div>
     
        <div class="p-dialog-footer py-3" >
            <Button  type="button" label="Annuler" icon="pi pi-times" class="p-button-text" @click="props.onCancel" />
            <Button type="submit" label="Modifier" icon="pi pi-check" class="p-button-text" :loading="props.isLoading" />
        </div>
</form>

</template>



<style scoped></style>