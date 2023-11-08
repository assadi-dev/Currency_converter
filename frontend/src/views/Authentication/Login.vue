<template>
    <form @submit="onSubmit">

        <div class="card flex justify-content-center">
            <span class="p-input-icon-left">
                <i class="pi pi-search" />
                <InputText v-model="username" placeholder="Seaemailch" />
            </span>
        </div>

        <div class="card flex justify-content-center">
            <Password v-model="password" toggleMask weakLabel="Faible" mediumLabel="Moyen"  strong-label="Fort" />
        </div>

        
        <Button type="submit" label="CONNEXION" aria-label="Submit" :loading="loading"  />
    </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';


const password = ref(null)

const username = ref(null)


const loading = false

const onSubmit = (e) => {
    e.preventDefault()
    console.log("subbmit",password.value);
    
}


</script>

<style scoped>

</style>