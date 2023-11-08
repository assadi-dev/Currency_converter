<template>
    <div>
<h2>Devise</h2>

<div class="card" v-if="!isLoading" >
<Toolbar class="mb-4">
    <template #start>
        <Button label="New" icon="pi pi-plus" class="p-button-success mr-2"  />
                            <Button label="Delete" icon="pi pi-trash" class="p-button-danger"  />
    </template>

</Toolbar>
<DataTable  dataKey="id" 
    ref="dt"
    :value="currenciesCollections"
    :paginator="true" :rows="5" 
    v-model:selection="selectedCurrency"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" 
    :rowsPerPageOptions="[5,10,25]"
    currentPageReportTemplate="Afficher {first} à {last} sur {totalRecords} Devises"
    @rowSelect="onRowSelect"
    @rowUnselect="onRowUnselect"
    :totalRecords="8"

 
   
    
    >

    <Column selectionMode="multiple" style="width: 3rem" ></Column>
    <Column field="id" header="ID" style="min-width:12rem"></Column>
    <Column field="code" header="Code" style="min-width:16rem"></Column>
    <Column field="name" header="Nom"  style="min-width:10rem"> </Column>
    <Column  style="min-width:8rem">
        <template >
            <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editProduct" />
            <Button icon="pi pi-trash" outlined rounded severity="danger" />
        </template>
    </Column>
</DataTable>

</div>

    </div>
</template>

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

const first = ref(0);
//const loading = ref(false);
const totalRecords = ref(8);
const selectAll = ref(false);

const pageEvent = (event) => {
    console.log(event);
    
}
//Fetching des devises vers le serveur
const {isLoading,currencies,error}=  useFetchCurrencies()


const currenciesCollections = computed<ApiCurrencySuccess| null>(() => {
    const { data } = currencies.value
    return data
})

const selectedCurrency = ref();
const metaKey = ref(true);




const editProduct = () => {
   console.log("edit");  
}

const dt = ref()

const onRowSelect = (event:any) => {
    console.log(event.data.id); 
   console.log(selectedCurrency.value);
   
};
const onRowUnselect = (event: any) => {
    console.log(selectedCurrency.value);
    console.log(event.data.id); 
}


</script>

<style scoped>

</style>