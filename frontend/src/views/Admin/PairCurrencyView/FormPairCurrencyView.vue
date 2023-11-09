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

const codeFromCurrency = defineInputBinds("codeFromCurrency")


const emit = defineEmits(["code"])

const props = defineProps<FormPropsType>()

watch(codeFromCurrency, async codeFromCurrency => {

    emit("code",codeFromCurrency)
})


const save = handleSubmit(values => {
    console.log(values);
    
    //props.onSubmit
})

</script>

<template>

        <form @submit="save" >
            <div class="field">
            <label for="codeFromCurrency">Code</label>
            <InputText :class="errors.codeFromCurrency && 'p-invalid'"  v-bind="codeFromCurrency" id="codeFromCurrency" name="codeFromCurrency"  autofocus placeholder="Code en 3 lettre" maxlength="3" />
<InlineMessage severity="error"  v-if="errors.codeFromCurrency">{{ errors.codeFromCurrency }}</InlineMessage>

        </div>
        <div class="field">
            <label for="name">Nom</label>
            <InputText id="name"  placeholder="Nom de la devise" />
        </div>

        <div class="p-dialog-footer py-3" >
            <Button  type="button" label="Annuler" icon="pi pi-times" class="p-button-text" @click="props.onCancel" />
            <Button type="submit" label="Ajouter" icon="pi pi-check" class="p-button-text" />
        </div>
</form>

</template>



<style scoped></style>