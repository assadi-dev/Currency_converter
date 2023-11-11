<script setup lang="ts"  >
import InputNumber from "primevue/inputnumber"
import Dropdown from 'primevue/dropdown';
import { ref } from 'vue'

const fromCurrency = ref();
const toCurrency = ref();

const currencyOption = ref([
    { name: 'Euro', code: 'EUR' },
    { name: 'Livre sterling britannique', code: 'RM' },
    { name: 'Dollar des Etat unies', code: 'LDN' },
    { name: 'Maroc Dirham', code: 'MAD' },
    { name: 'Franc', code: 'FRA' }
]);






</script>
<template>
          <h1>Salut le guez</h1>
    <div class="flex justify-center" style="width:43rem" >
  
        <div class="card">

            <div class="container p-3">
                <div>
                    <Dropdown v-model="fromCurrency" editable :options="currencyOption" optionLabel="name"
                        placeholder="Selectionner une devise" class="w-full md:w-14rem" />
                </div>
            </div>
            <div class="container p-3">
                <div>
                    <Dropdown v-model="fromCurrency" editable :options="currencyOption" optionLabel="name"
                        placeholder="Selectionner une devise" class="w-full md:w-14rem" />
                </div>
            </div>

        </div>

    </div>
</template>


<style scoped></style>