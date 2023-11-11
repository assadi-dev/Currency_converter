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



const first = ref(0);
//const loading = ref(false);
const totalRecords = ref(8);
const selectAll = ref(false);
const toast = useToast()

const stateSelectedCurrency = ref<Omit<CurrencyType, "created_at" | "updated_at"> | null>()
const startloading = ref(false)


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

const toggleDeleteConfirm = (currency) => {
    deleteCurrencyDialog.value = !deleteCurrencyDialog.value;

};


const submitData = async (data: defaultFormCurrency) => {
  try {
    console.log(data);
  } catch (error) {
    
  } finally {
    newCurrencyDialog.value = false
  }

}

const submitUpdateData = async (data: CurrencyType) => {

    try {

  
        const id = data.id 
    
        if(!id)return 

    await CurencyApi.update(id,data)

    const updatedCollections = [...currencies.value.data].map(v => {
        if (v.id == id) {
        return {...v,...data} 
        }
    return v
    })

    currencies.value.data = updatedCollections


} catch (error) {
    
} finally {
   
    stateSelectedCurrency.value = null
    editToggleEditDialog.value = false
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
                <DataTable dataKey="id" ref="dt" :value="currenciesCollections" v-if="!isLoading">

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
                            <Button icon="pi pi-trash" outlined rounded severity="danger"
                                @click="toggleDeleteConfirm(rowData.data)" />
                        </template>
                    </Column>
                </DataTable>

                <!-- modal de suppression des elements selectionnés -->
                <Dialog :style="{ width: '450px' }" header="Confirm" :modal="true">

                    <template #footer>
                        <Button label="Non" icon="pi pi-times" class="p-button-text" />
                        <Button label="Oui" icon="pi pi-check" class="p-button-text" />
                    </template>
                </Dialog>

                <!-- Modal d'ajout  -->
                <Dialog v-model:visible="newCurrencyDialog" :style="{ width: '450px' }" header="Ajouter une devise"
                    :modal="true" class="p-fluid">

                    <FormCurrencyView label-submit-button="Ajouter" :on-cancel="toggleNewCurrency"
                        @submitForm="submitData" />

                </Dialog>

                <!-- Modal d'Edit  -->
                <Dialog v-model:visible="editToggleEditDialog" :style="{ width: '450px' }" header="Modifier la devise"
                    :modal="true" class="p-fluid">
                    <FormCurrencyView label-submit-button="Modifier" :on-cancel="toggleEditCurrency"
                        @submitForm="submitUpdateData" :defaultvalues="stateSelectedCurrency" />
                </Dialog>

            </div>

        </div>
    </div>
</template>


<style scoped></style>