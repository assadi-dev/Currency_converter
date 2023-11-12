
<script setup lang="ts">
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref, computed, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import Toolbar from "primevue/toolbar"
import Button from "primevue/button"
import { useFetchPairCurrencies } from '../../../composable/currencyPair.composable';
import DialogDeleteSelected from "../../../components/Dialog/DialogDeleteSelected.vue"
import Toast from 'primevue/toast';
import Dialog from 'primevue/dialog';
import FormPairCurrencyView from './FormPairCurrencyView.vue'
import { ApiPairCurrencySuccess, PairCurrencyType } from "../../../services/types/pairCurrency.type";
import * as PairCurencyApi from "../../../services/api/PairCurrency.api"
import { PairCurrencyFormValue } from "../../../services/types/Form.types"
import * as PairDialogMessage from "../../../services/dialogmessage/PairCurrency"
import FormEditPairCurrencyView from './FormEditPairCurrencyView.vue';
import CustomPaginator from '../../../components/Navigations/CustomPaginator.vue';




//Fetching des devises vers le serveur
const { pairCurrencies, isLoading, error, fetchData } = useFetchPairCurrencies()

const indexPage = ref<number | null>(1)
const totalRecords = ref<number | null>(1);
const selectAll = ref(false);
const toast = useToast()
const lastPage = ref(1)


const pairCurrenciesCollections = computed(() => {
    if (pairCurrencies.value) {
        const { data,meta } = pairCurrencies.value
        totalRecords.value = meta.total
        lastPage.value = meta.last_page
            return data
    }
        return []
    })


const goNextPage = () => {
    const nextPage = indexPage.value +=  1
    fetchData(nextPage)
}
const goPrevPage = () => {
    const prevPage = indexPage.value +=  -1
    fetchData(prevPage)
}

const goLastPage = () => {
    indexPage.value = lastPage.value
    fetchData(lastPage.value)
}
const goFirstPage = () => {
    indexPage.value = 1
    fetchData(1)
}




/**
 * Paire selectionné
 */
const selectedPairCurrency = ref([]);
const metaKey = ref(true);
const dt = ref()

const deleteMessage = ref<string>("")



//state des element selectionnées
const statePaireCurrency = ref<Omit<PairCurrencyType, "count">| null >()
//Activation du loading lors d'une action
const startProcess = ref(false)


//Affichage des modal
const deletePairCurrencyDialog = ref(false)
const deleteSelectedPairCurrencyDialog = ref(false)
const newPairurrencyDialog = ref(false)
const editPairCurrencyDialog = ref(false)

const openNew = () => {
    newPairurrencyDialog.value = !newPairurrencyDialog.value
}

const toggleEditConfirm = (pairCurrency: Omit<PairCurrencyType, "count">) => {

    editPairCurrencyDialog.value = !editPairCurrencyDialog.value;
    statePaireCurrency.value = pairCurrency



};

const toogleDeleteConfirm = (pairCurrency: Omit<PairCurrencyType, "count">) => {

    deletePairCurrencyDialog.value = !deletePairCurrencyDialog.value;
    statePaireCurrency.value = pairCurrency
    deleteMessage.value = `Etes vous sur de vouloir suprimé la pair ${pairCurrency.codeFromCurrency}-${pairCurrency.nameFromCurrency} vers ${pairCurrency.codeToCurrency}-${pairCurrency.nameToCurrency}  ?`
};

const toggleSelectedConfirm = () => {
    const sizeSelected = selectedPairCurrency.value.length
    deleteMessage.value = `Etes vous sur de vouloir supprimr ces ${sizeSelected} éléments ?`
    deleteSelectedPairCurrencyDialog.value = !deleteSelectedPairCurrencyDialog.value;
};

/** suppression multiple */
const deleteSelectedCurrency = async() => {
    try {
startProcess.value = true
       await  PairCurencyApi.removeMultiple(selectedPairCurrency.value);

        
    
        pairCurrencies.value.data = pairCurrencies.value.data.filter((val) => !selectedPairCurrency.value.includes(val));
    
        toast.add({ severity: 'success', summary: PairDialogMessage.TITLE_SUCCESS, detail: PairDialogMessage.DELETE_SELECTED_PAIR_SUCCESS, life: 3000 });
    } catch (error) {
        toast.add({ severity: 'error', summary: PairDialogMessage.TITLE_FAILED, detail: PairDialogMessage.DELETE_SELECTED_PAIR_FAILED, life: 5000 });
    } finally {
        startProcess.value = false
        deleteSelectedPairCurrencyDialog.value = false
    }
};

/** suppression d'une seul element **/
const deletePairCurrency = async () => {
    try {
        startProcess.value = true
        const id = statePaireCurrency.value?.id
         await PairCurencyApi.remove(id)

        const itemRemoved = [...pairCurrencies?.value?.data]?.filter(val => val?.id != id)

        pairCurrencies.value.data = itemRemoved

        statePaireCurrency.value = null

        toast.add({ severity: 'success', summary: PairDialogMessage.TITLE_SUCCESS, detail: PairDialogMessage.DELETE_PAIR_SUCCESS, life: 3000 });

    } catch (error) {
        toast.add({ severity: 'error', summary: PairDialogMessage.TITLE_FAILED, detail: PairDialogMessage.DELETE_PAIR_FAILED, life: 3000 });
    }
    finally {
        deletePairCurrencyDialog.value = false
        startProcess.value = false
        statePaireCurrency.value = null

    }


}
/**Envoie les donnée vers le serveur**/
const postFormValues = async (values: PairCurrencyFormValue) => {
    try {
        startProcess.value = true
        const res = await PairCurencyApi.add(values)
        const pairs = res.data.data



        for (const pair of pairs) {
         
            
            pairCurrencies?.value?.data.push(pair)
        }

      
        toast.add({ severity: 'success', summary: PairDialogMessage.TITLE_SUCCESS, detail: PairDialogMessage.ADD_PAIR_SUCCESS, life: 3000 });
    } catch (error) {

        toast.add({ severity: 'error', summary: PairDialogMessage.TITLE_FAILED, detail: PairDialogMessage.ADD_PAIR_FAILED, life: 3000 });
    } finally {
        newPairurrencyDialog.value = false
        startProcess.value = false
    }

}

/** Envoie des donnée pour l'edition au serveur**/
const updateFormValues = async (values: PairCurrencyType) => {
    try {

       
        startProcess.value = true
        
        const collectionUpdated = [...pairCurrencies.value.data]?.map(v => {
            if (v.id == values.id) {
                return { ...v, exchange_rate: values.exchange_rate }
            }

            return v
        })

        pairCurrencies.value.data = collectionUpdated

        const id = values.id
        const data = { exchange_rate: values.exchange_rate }

        await PairCurencyApi.update(id, data)

        toast.add({ severity: 'success', summary: PairDialogMessage.TITLE_SUCCESS, detail: PairDialogMessage.EDIT_PAIR_SUCCESS, life: 3000 });

    } catch (error) {
        toast.add({ severity: 'error', summary: PairDialogMessage.TITLE_FAILED, detail: PairDialogMessage.EDIT_PAIR_FAILED, life: 3000 });

    } finally {
        startProcess.value = false
        editPairCurrencyDialog.value = false
        statePaireCurrency = null
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
                            @click="openNew" />
                        <Button label="Supprimer" icon="pi pi-trash" class="p-button-danger" @click="toggleSelectedConfirm"
                            :disabled="!selectedPairCurrency || !selectedPairCurrency.length" />
                    </template>

                </Toolbar>
                <DataTable v-if="!isLoading" dataKey="id" ref="dt" :value="pairCurrenciesCollections" 
                 
                
                   
                    currentPageReportTemplate="Afficher {first} à {last} sur {totalRecords} Devises" :totalRecords="8">

                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h2 class="m-0">Gestion des Taux de conversions</h2>
                        </div>
                    </template>

                    <Column selectionMode="multiple" style="width: 3rem"></Column>
                    <Column field="id" header="ID" style="min-width:3rem"></Column>
                    <Column field="codeFromCurrency" header="Code Devise entrant" style="min-width:5rem"></Column>
                    <Column field="nameFromCurrency" header="Devise entrant" style="min-width:5rem"></Column>
                    <Column field="codeToCurrency" header="Code Devise sortant" style="min-width:5rem"></Column>
                    <Column field="nameToCurrency" header="Devise sortant" style="min-width:5rem"> </Column>
                    <Column field="exchange_rate" header="Taux"> </Column>
                    <Column field="count" header="Nombre d'utilisation"></Column>
                    <Column style="min-width:5rem">
                        <template #body="rowData">
                            <Button icon="pi pi-pencil" outlined rounded class="mr-2"
                                @click="toggleEditConfirm(rowData.data)" />
                            <Button icon="pi pi-trash" outlined rounded severity="danger"
                                @click="toogleDeleteConfirm(rowData.data)" />
                        </template>
                    </Column>
                </DataTable>
                
                <CustomPaginator />

             <!--    <Paginator :rows="5"  :pt="{
                    nextPageButton:next
                }"   :totalRecords="6" ></Paginator> # --->

                <!-- modal de suppression de la devise -->
                <Dialog v-model:visible="deletePairCurrencyDialog" :style="{ width: '450px' }" header="Suppression"
                    :modal="true">
                    <DialogDeleteSelected :message="deleteMessage" />
                    <template #footer>
                        <Button label="Non" icon="pi pi-times" class="p-button-text" @click="toogleDeleteConfirm" />
                        <Button label="Oui" icon="pi pi-check" class="p-button-text" @click="deletePairCurrency" :loading="startProcess" />
                    </template>
                </Dialog>
                <!-- modal de suppression des elements selectionnée -->
                <Dialog v-model:visible="deleteSelectedPairCurrencyDialog" :style="{ width: '450px' }" :header="`${selectedPairCurrency.length} élement(s) selectionnée`"
                    :modal="true">
                    <DialogDeleteSelected :message="deleteMessage" />
                    <template #footer>
                        <Button label="Non" icon="pi pi-times" class="p-button-text" @click="toggleSelectedConfirm" />
                        <Button label="Oui" icon="pi pi-check" class="p-button-text" @click="deleteSelectedCurrency" :loading="startProcess" />
                    </template>
                </Dialog>

                <!-- Modal d'ajout  -->
                <Dialog v-model:visible="newPairurrencyDialog" :style="{ width: '450px' }"
                    header="Ajouter une nouvelle paire de devise" :modal="true" class="p-fluid">
                    <FormPairCurrencyView @form-values="postFormValues" :on-cancel="openNew" :is-loading="startProcess" />
                </Dialog>

                <!-- Modal d'edition  -->
                <Dialog v-model:visible="editPairCurrencyDialog" :style="{ width: '450px' }"
                    header="Modifier le taux de conversion" :modal="true" class="p-fluid">
                    <FormEditPairCurrencyView :values="statePaireCurrency" @form-values="updateFormValues"
                        :on-cancel="toggleEditConfirm"  :is-loading="startProcess"  />
                </Dialog>




            </div>

        </div>
    </div>
</template>


<style scoped></style>


