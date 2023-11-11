<script setup lang="ts">
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref, computed } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { useToast } from 'primevue/usetoast';
import Toolbar from "primevue/toolbar"
import Button from "primevue/button"
import { CurrencyType, ApiCurrencySuccess } from '../../../services/types/currency.type';
import { useFetchCurrencies } from '../../../composable/currency.composable';
import Toast from 'primevue/toast';
import Dialog from 'primevue/dialog';
import FormCurrencyView from './FormCurrencyView.vue';
import { defaultFormCurrency } from './SchemaValidation';
import * as CurencyApi from "../../../services/api/Currency.api"
import * as CurrencyDialogMessage from "../../../services/dialogmessage/Currency"
import { string } from 'yup';
import DialogDeleteSelected from '../../../components/Dialog/DialogDeleteSelected.vue';




const first = ref(0);
//const loading = ref(false);
const totalRecords = ref(8);
const selectAll = ref(false);
const toast = useToast()

const stateSelectedCurrency = ref<Omit<CurrencyType, "created_at" | "updated_at"> | null>()
const startloading = ref(false)
const deleteMessage = ref<string>("")


//Fetching des devises vers le serveur
const { isLoading, currencies, error } = useFetchCurrencies()


const currenciesCollections = computed<ApiCurrencySuccess | null>(() => {
    const { data } = currencies.value
    return data
})

/** Stocage de devise selectionnée */
const selectedCurrency = ref();
const metaKey = ref(true);
const dt = ref()


//Crud 

//Affichage des modal
const deleteCurrencyDialog = ref(false)
const newCurrencyDialog = ref(false)
const editToggleEditDialog = ref(false)

const toggleNewCurrency = () => {
    newCurrencyDialog.value = !newCurrencyDialog.value
     stateSelectedCurrency.value = null
}

const toggleEditCurrency = (currency: Omit<CurrencyType, "created_at" | "updated_at">) => {
    stateSelectedCurrency.value = currency
    editToggleEditDialog.value = !editToggleEditDialog.value
}

const toggleDeleteConfirm = (currency: Omit<CurrencyType, "created_at" | "updated_at">) => {
    if(currency?.count == 0) return
    deleteMessage.value = `Etes vous sur de vouloir supprimer la devise ${currency.code}-${currency.name} ?`
    stateSelectedCurrency.value = currency
    deleteCurrencyDialog.value = !deleteCurrencyDialog.value;

};


const submitData = async (data: defaultFormCurrency) => {
    try {
        startloading.value = true

        const res = await CurencyApi.add(data)
        const payload = {id:res.data.id,code:res.data.code,name:res.data.name}

        currencies.value.data.push(payload)

        toast.add({ severity: 'success', summary: CurrencyDialogMessage.TITLE_SUCCESS, detail: CurrencyDialogMessage.ADD_CURRENCY_SUCCESS, life: 3000 });

  } catch (error) {
    toast.add({ severity: 'error', summary: CurrencyDialogMessage.TITLE_FAILED, detail: CurrencyDialogMessage.ADD_CURRENCY_FAILED, life: 3000 });
    } finally {
        startloading.value = false
    newCurrencyDialog.value = false
  }

}




const submitUpdateData = async (data: CurrencyType) => {

    try {

        startloading.value = true
  
        const id = data.id 
    
     

    await CurencyApi.update(id,data)

    const updatedCollections = [...currencies.value.data].map(v => {
        if (v.id == id) {
        return {...v,...data} 
        }
    return v
    })

    currencies.value.data = updatedCollections
    
    toast.add({ severity: 'success', summary: CurrencyDialogMessage.TITLE_SUCCESS, detail: CurrencyDialogMessage.EDIT_CURRENCY_SUCCESS, life: 3000 });


} catch (error) {
    toast.add({ severity: 'error', summary: CurrencyDialogMessage.TITLE_FAILED, detail: CurrencyDialogMessage.EDIT_CURRENCY_FAILED, life: 3000 });

} finally {
    startloading.value = false
    stateSelectedCurrency.value = null
    editToggleEditDialog.value = false
}

}

const deleteCurrency = async() => {
    try {
        startloading.value = true
        const id = stateSelectedCurrency.value?.id

        const removedCurrency = [...currencies.value.data].filter(v => v.id != id)

        await CurencyApi.remove(id)

        currencies.value.data = removedCurrency
        toast.add({ severity: 'success', summary: CurrencyDialogMessage.TITLE_SUCCESS, detail: CurrencyDialogMessage.DELETE_CURRENCY_SUCCESS, life: 3000 });

    } catch (error) {
        toast.add({ severity: 'error', summary: CurrencyDialogMessage.TITLE_FAILED, detail: CurrencyDialogMessage.DELETE_CURRENCY_FAILED, life: 3000 });

    } finally {
        startloading.value = false
        deleteCurrencyDialog.value = false
        stateSelectedCurrency.value = null
    }
}


</script>

<template>
    <div class="grid">
        <div class="col-12 mx-auto">


            <div class="card">
                <Toast />
                <Toolbar class="mb-4">
                    <template #start>
                        <Button label="Ajouter une devise" icon="pi pi-plus" class="p-button-success mr-2"
                            @click="toggleNewCurrency" />
                    </template>

                </Toolbar>
                <DataTable  :rows="5" dataKey="id" ref="dt" :value="currenciesCollections" v-if="!isLoading"   >

                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h2 class="m-0">Gestion des Devises</h2>
                        </div>
                    </template>

                    <Column field="id" header="ID" style="min-width:3rem"></Column>
                    <Column field="code" header="Code"></Column>
                    <Column field="name" header="Nom"> </Column>
                    <Column style="min-width:8rem">
                        <template #body="rowData">
                            <Button icon="pi pi-pencil" outlined rounded class="mr-2"
                                @click="toggleEditCurrency(rowData.data)" />
                            <Button v-if="rowData.data.count == 0 " icon="pi pi-trash" outlined rounded severity="danger"
                                @click="toggleDeleteConfirm(rowData.data)" />
                        </template>
                    </Column>
                </DataTable>

                <!-- modal de suppression des elements selectionnés -->
                <Dialog v-model:visible="deleteCurrencyDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                    <DialogDeleteSelected :message="deleteMessage" />

                    <template #footer>
                        <Button label="Non" icon="pi pi-times" class="p-button-text" @click="toggleDeleteConfirm" />
                        <Button label="Oui" icon="pi pi-check" class="p-button-text" @click="deleteCurrency" :loading="startloading"  />
                    </template>
                </Dialog>

                <!-- Modal d'ajout  -->
                <Dialog v-model:visible="newCurrencyDialog" :style="{ width: '450px' }" header="Ajouter une devise"
                    :modal="true" class="p-fluid">

                    <FormCurrencyView label-submit-button="Ajouter" :on-cancel="toggleNewCurrency"
                        @submitForm="submitData" :is-loading="startloading" />

                </Dialog>

                <!-- Modal d'Edit  -->
                <Dialog v-model:visible="editToggleEditDialog" :style="{ width: '450px' }" header="Modifier la devise"
                    :modal="true" class="p-fluid">
                    <FormCurrencyView label-submit-button="Modifier" :on-cancel="toggleEditCurrency"
                        @submitForm="submitUpdateData" :defaultvalues="stateSelectedCurrency" :is-loading="startloading" />
                </Dialog>

            </div>

        </div>
    </div>
</template>


<style scoped></style>