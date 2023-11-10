
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
import FormPairCurrencyView from './FormPairCurrencyView.vue'

    
    const first = ref(0);
    //const loading = ref(false);
    const totalRecords = ref(8);
    const selectAll = ref(false);
    const toast = useToast()
    
    
    //Fetching des devises vers le serveur
   // const {isLoading,currencies,error}=  useFetchCurrencies()

   const pairCurrencies = ref([])
    

    const selectedPairCurrency = ref([]);
    const metaKey = ref(true);
    const dt = ref()
    
       //Crud operations
 

    //Affichage des modal
    const deletePairCurrencyDialog = ref(false)
    const deleteSelectedPairCurrencyDialog = ref(false)
    const newPairurrencyDialog = ref(false)

        const openNew = () => {
     
        
        newPairurrencyDialog.value = !newPairurrencyDialog.value
    }
    
    const editProduct = (currency) => {
       console.log(currency);  
    }

    const toogleDeleteConfirm = (currency) => {
        deleteCurrencyDialog.value = !deleteCurrencyDialog.value;
    };

    const toogleSelectedConfirm = () => {
        deleteSelectedPairCurrencyDialog.value = !deleteSelectedPairCurrencyDialog.value;
    };
const deleteSelectedCurrency = () => {
  try {
    pairCurrencies.value.data = pairCurrencies.value.data.filter((val) => !selectedPairCurrency.value.includes(val));
    deleteSelectedPairCurrencyDialog.value = false
     toast.add({ severity: 'success', summary: 'Opération réussie', detail: 'Devise supprimé', life: 3000 });
  } catch (error) {
    toast.add({ severity: 'error', summary: `Echec de l'opération`, detail: 'La devise pas pu etre supprimé', life: 5000 });

  }
};
    
  
        const postFormValues = (values:any) => {
                    console.log(values);
                pairCurrencies.value.push(values)
    
        }
    
    </script>

<template>

    <div class="grid">
    <div  class="col-12 mx-auto">


<div class="card" >
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
            <h2 class="m-0">Gestion des Taux de conversions</h2>            
        </div>
    </template>

    <Column selectionMode="multiple" style="width: 3rem" ></Column>
    <Column field="id" header="ID" style="min-width:3rem"></Column>
    <Column field="code" header="Devise entrant" style="min-width:5rem" ></Column>
    <Column field="name" header="Devise sortant" style="min-width:5rem" > </Column>
    <Column field="name" header="Taux" > </Column>
    <Column field="id" header="Nombre d'utilisation" ></Column>
    <Column  style="min-width:5rem">
        <template #body="rowData" >
            <Button icon="pi pi-pencil" outlined rounded class="mr-2" />
            <Button icon="pi pi-trash" outlined rounded severity="danger"   />
        </template>
    </Column>
</DataTable>

<!-- modal de suppression des elements selectionnés -->
<Dialog v-model:visible="deleteSelectedCurrencyDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
    <DialogDeleteSelected message="Etes vous sur de vouloir suprimé les devises selectionné ?" />
    <template #footer>
        <Button label="Non" icon="pi pi-times" class="p-button-text" />
        <Button label="Oui" icon="pi pi-check" class="p-button-text"/>
    </template>
</Dialog>            

<!-- Modal d'ajout  -->

<Dialog  v-model:visible="newPairurrencyDialog" :style="{ width: '450px' }" header="Product Details" :modal="true" class="p-fluid">


        <FormPairCurrencyView @form-values="postFormValues"  />



</Dialog>




</div>

</div>
</div>
</template>


<style scoped>

</style>


