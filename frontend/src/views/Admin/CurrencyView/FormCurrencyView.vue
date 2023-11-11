<script setup lang="ts">
import { useField, useForm } from 'vee-validate';
import { CurrencyForm } from "./SchemaValidation";
import InputText from 'primevue/inputtext';
import Button from "primevue/button"
import { onMounted } from 'vue';
import {defaultFormCurrency} from "./SchemaValidation"


type FormPropsType = {
    labelSubmitButton?:string
    onCancel?: Function
    defaultvalues?: defaultFormCurrency
    isLoading:boolean
}



const props = defineProps<FormPropsType>()

const { errors, defineInputBinds, handleSubmit } = useForm({
    initialValues:props.defaultvalues,
    validationSchema: CurrencyForm,

});

const code = defineInputBinds("code")
const name = defineInputBinds("name")






const emit = defineEmits(["submitForm"])


const save = handleSubmit(values => {
  
    
    emit("submitForm",values)
 
})

</script>
<template>
    <form @submit="save">
        <div class="field">
            <label for="code">Code</label>
            <InputText v-bind="code" name="code" :class="errors.code && 'p-invalid'"  id="code" autofocus placeholder="EX: EUR, GBP,"   />
            <small class="p-error" id="codeFromCurrency">{{ errors.code || '&nbsp;' }}</small>

        </div>
        <div class="field">
            <label for="name">Nom</label>
            <InputText v-bind="name" id="name" name="name"  placeholder="Nom de la devise" />
            <small class="p-error" id="name">{{ errors.name || '&nbsp;' }}</small>

        </div>
        <div class="p-dialog-footer py-3">
            <Button type="button" label="Annuler" icon="pi pi-times" class="p-button-text" @click="props.onCancel" />
            <Button type="submit" :label="props.labelSubmitButton" icon="pi pi-check" class="p-button-text" :loading="props.isLoading" />
        </div>
    </form>
</template>


<style scoped></style>