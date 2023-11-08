<template>
    <div>
<h2>Devise</h2>

<div  >
<Toolbar class="mb-4">
    <template #start>
        <Button label="New" icon="pi pi-plus" severity="success" class="mr-2" />
        <Button label="Delete" icon="pi pi-trash" severity="danger"  />
    </template>

</Toolbar>
<DataTable dataKey="id" 
    :value="currencies"
    :paginator="true" :rows="10" 
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products">

    <Column selectionMode="multiple" style="width: 3rem" ></Column>
    <Column field="id" header="ID" style="min-width:12rem"></Column>
    <Column field="code" header="Code" style="min-width:16rem"></Column>
    <Column field="name" header="Nom"  style="min-width:10rem"></Column>
    <Column  style="min-width:8rem">
        <template >
            <Button icon="pi pi-pencil" outlined rounded class="mr-2" />
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
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { useToast } from 'primevue/usetoast';
import Toolbar from "primevue/toolbar"
import Button from "primevue/button"
import InputText from 'primevue/inputtext';
import { Currency } from '../../../services/types/currency.type';


const currencies = ref<Currency[]|null>(null)
 onMounted(() => {
     currencies.value = [
		{
			id: 1,
			code: "GBR",
			name: "Livre sterling",
			created_at: "2023-11-06T22:34:41.000000Z",
			updated_at: "2023-11-07T12:41:22.000000Z"
		},
		{
			id: 2,
			code: "EUR",
			name: "euro",
			created_at: "2023-11-06T22:35:18.000000Z",
			updated_at: "2023-11-06T22:35:18.000000Z"
		},
		{
			id: 5,
			code: "BIT",
			name: "Bitcoins",
			created_at: "2023-11-06T22:59:25.000000Z",
			updated_at: "2023-11-06T22:59:25.000000Z"
		},
		{
			id: 6,
			code: "EUR-22",
			name: "euro-22",
			created_at: "2023-11-06T23:09:05.000000Z",
			updated_at: "2023-11-06T23:09:05.000000Z"
		}
	]
}); 

console.log(currencies.value);



</script>

<style scoped>

</style>