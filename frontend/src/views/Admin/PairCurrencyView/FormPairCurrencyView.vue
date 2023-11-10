<script setup lang="ts">
import InputText from 'primevue/inputtext';
import Button from "primevue/button"
import { onMounted, ref, watch } from 'vue';
import PairCurrencyFormValue from '../../../services/types/Form.types'
import { useField, useForm } from 'vee-validate';
import { PairCurrencyForm } from "./SchemaValidation"
import InlineMessage from 'primevue/inlinemessage';



type FormPropsType = {
    onSubmit?: Function
    onCancel?: Function
}

const {errors, defineInputBinds, handleSubmit } = useForm({
    validationSchema:PairCurrencyForm
});




const emit = defineEmits(["formValues"])

const props = defineProps<FormPropsType>()

    const idFromCurrency= defineInputBinds("idFromCurrency")
    const codeFromCurrency= defineInputBinds("codeFromCurrency")
    const nameFromCurrency= defineInputBinds("nameFromCurrency")
    const idToCurrency= defineInputBinds("idToCurrency")
    const codeToCurrency= defineInputBinds("codeToCurrency")
    const nameToCurrency= defineInputBinds("nameToCurrency")
    const exchange_rate= defineInputBinds("exchange_rate")


const save = handleSubmit(values => {
    emit("formValues",values)
})

</script>

<template>

        <form @submit="save" >
            <div class="field">
                <label for="codeFromCurrency">Code devise entrant</label>
                <InputText :class="errors.codeFromCurrency && 'p-invalid'"  v-bind="codeFromCurrency" id="codeFromCurrency" name="codeFromCurrency"   placeholder="EX: EUR, GBR, "  />
                <small class="p-error" id="codeFromCurrency">{{ errors.codeFromCurrency || '&nbsp;' }}</small>
            </div>
        <div class="field">
            <label for="nameFromCurrency">Nom devise entrant</label>
            <InputText v-bind="nameFromCurrency" id="nameFromCurrency" name="nameFromCurrency"  placeholder="Nom de la devise entrant" />
            <small class="p-error" id="nameFromCurrency">{{ errors.nameFromCurrency || '&nbsp;' }}</small>
        </div>
            <div class="field">
                <label for="codeToCurrency">Code devise sortant</label>
                <InputText :class="errors.codeToCurrency && 'p-invalid'"  v-bind="codeToCurrency" id="codeToCurrency" name="codeToCurrency"   placeholder="EX: EUR, GBR, "  />
                <small class="p-error" id="codeToCurrency">{{ errors.codeToCurrency || '&nbsp;' }}</small>
            </div>
        <div class="field">
            <label for="nameToCurrency">Nom devise sortant</label>
            <InputText v-bind="nameToCurrency" id="nameToCurrency" nam="nameToCurrency"  placeholder="Nom de la devise sortant" />
            <small class="p-error" id="nameToCurrency">{{ errors.nameToCurrency || '&nbsp;' }}</small>

        </div>
        <div class="field">
            <label for="exchange_rate">Taux d'echange</label>
            <InputText v-bind="exchange_rate" id="exchange_rate" name="exchange_rate"  placeholder="0.00000" />
            <small class="p-error" id="texchange_rate">{{ errors.exchange_rate || '&nbsp;' }}</small>

        </div>

        <div class="p-dialog-footer py-3" >
            <Button  type="button" label="Annuler" icon="pi pi-times" class="p-button-text" @click="props.onCancel" />
            <Button type="submit" label="Ajouter" icon="pi pi-check" class="p-button-text" />
        </div>
</form>

</template>



<style scoped></style>