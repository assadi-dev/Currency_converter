<template>
    <div>
        <script setup lang="ts">
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import ColumnGroup from 'primevue/columngroup';   // optional
    import Row from 'primevue/row';  
    import { ref, onMounted, computed } from 'vue';
    import { FilterMatchMode } from 'primevue/api';
    import { useToast } from 'primevue/usetoast';
    import Toolbar from "primevue/toolbar"
    import Button from "primevue/button"
    import InputText from 'primevue/inputtext';
    import { Currency,ApiCurrencySuccess } from '../../../services/types/currency.type';
    import { useFetchCurrencies } from '../../../composable/currency.composable';
    import DialogDeleteSelected from "../../../components/Dialog/DialogDeleteSelected.vue"

    import Toast from 'primevue/toast';
import Dialog from 'primevue/dialog';
    
    const first = ref(0);
    //const loading = ref(false);
    const totalRecords = ref(8);
    const selectAll = ref(false);
    const toast = useToast()
    
    
    //Fetching des devises vers le serveur
   // const {isLoading,currencies,error}=  useFetchCurrencies()

   const pairCurrencies = []
    
    
/*     const currenciesCollections = computed<ApiCurrencySuccess| null>(() => {
        const { data } = currencies.value
        return data
    }) */
    
    const selectedPairCurrency = ref();
    const metaKey = ref(true);
    const dt = ref()
    
    
    //Crud 

    //Affichage des modal
    const deleteCurrencyDialog = ref(false)
    const deleteSelectedCurrencyDialog = ref(false)
    const newCurrencyDialog = ref(false)

    const openNew = () => {
        newCurrencyDialog.value = !newCurrencyDialog.value
    }
    
    const editProduct = (currency) => {
       console.log(currency);  
    }

    const toogleDeleteConfirm = (currency) => {
        deleteCurrencyDialog.value = !deleteCurrencyDialog.value;
    };

    const toogleSelectedConfirm = () => {
        deleteSelectedCurrencyDialog.value = !deleteSelectedCurrencyDialog.value;
    };
const deleteSelectedCurrency = () => {
  try {
    currencies.value.data = currencies.value.data.filter((val) => !selectedCurrency.value.includes(val));
    deleteSelectedCurrencyDialog.value = false
     toast.add({ severity: 'success', summary: 'Opération réussie', detail: 'Devise supprimé', life: 3000 });
  } catch (error) {
    toast.add({ severity: 'error', summary: `Echec de l'opération`, detail: 'La devise pas pu etre supprimé', life: 5000 });

  }
};
    
    
  
    
    </script>

<template>
    <div class="grid">
    <div  class="col-12 mx-auto">


<div class="card" v-if="!isLoading" >
    <Toast />
<Toolbar class="mb-4">
    <template #start>
        <Button label="Ajouter une devise" icon="pi pi-plus" class="p-button-success mr-2" @click="openNew"   />
        <Button label="Supprimer" icon="pi pi-trash" class="p-button-danger"  @click="toogleSelectedConfirm" :disabled="!selectedCurrency || !selectedCurrency.length"  />
    </template>

</Toolbar>
<DataTable  dataKey="id" 
    ref="dt"
    :value="pairCurrencies"
    :paginator="true" :rows="5" 
    v-model:selection="selectedPairCurrency"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" 
    :rowsPerPageOptions="[5,10,25]"
    currentPageReportTemplate="Afficher {first} à {last} sur {totalRecords} Devises"
    :totalRecords="8"
    >

    <template #header>
        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
            <h2 class="m-0">Gestion des Devises</h2>            
        </div>
    </template>

    <Column selectionMode="multiple" style="width: 3rem" ></Column>
    <Column field="id" header="ID" style="min-width:12rem"></Column>
    <Column field="code" header="Code" style="min-width:16rem"></Column>
    <Column field="name" header="Nom"  style="min-width:10rem"> </Column>
    <Column  style="min-width:8rem">
        <template #body="rowData" >
            <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct(rowData.data)" />
            <Button icon="pi pi-trash" outlined rounded severity="danger" @click="toogleDeleteConfirm(rowData.data)"  />
        </template>
    </Column>
</DataTable>

<!-- modal de suppression des elements selectionnés -->
<Dialog v-model:visible="deleteSelectedCurrencyDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
    <DialogDeleteSelected message="Etes vous sur de vouloir suprimé les devises selectionné ?" />
    <template #footer>
        <Button label="Non" icon="pi pi-times" class="p-button-text" @click="toogleSelectedConfirm" />
        <Button label="Oui" icon="pi pi-check" class="p-button-text" @click="deleteSelectedCurrency" />
    </template>
</Dialog>            

<!-- Modal d'ajout  -->
<Dialog v-model:visible="newCurrencyDialog" :style="{ width: '450px' }" header="Product Details" :modal="true" class="p-fluid">
        <div class="field">
                <label for="code">Code</label>
            <InputText id="code"  required="true" autofocus placeholder="Code en 3 lettre"  maxlength="3" />
                       
        </div>
                    <div class="field">
                        <label for="name">Nom</label>
                        <InputText id="name"  required="true" placeholder="Nom de la devise"   />
                    </div>

                    <template #footer>
                        <Button label="Annuler" icon="pi pi-times" class="p-button-text" @click="openNew"  />
                        <Button label="Ajouter" icon="pi pi-check" class="p-button-text" />
                    </template>
    </Dialog>

</div>

</div>
</div>
</template>


<style scoped>

</style>

    </div>
</template>

<script setup lang="ts">

</script>

<style scoped>

</style>