<template>
    <form @submit="onSubmit">

        <div class="card flex justify-content-center">
            <span class="p-input-icon-left">
                <i class="pi pi-search" />
                <InputText type="email" v-model="email" placeholder="Email" />
            </span>
        </div>

        <div class="card flex justify-content-center">
            <Password v-model="password" toggleMask weakLabel="Faible" mediumLabel="Moyen"  strong-label="Fort" placeholder="Mot de passe"  />
        </div>
        <Button type="submit" label="CONNEXION" aria-label="Submit" :loading="loading"  />
    </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import { userConnect } from '../../services/api/Auth.api';
import { AUTH_KEY_STORAGE, getItem, setItem } from '../../services/utils/storage';
import { useRouter } from 'vue-router';

const router = useRouter()

const password = ref<string|null>(null)

const email = ref<string|null>(null)

const loading = ref(false)




const onSubmit = async(e) => {
    e.preventDefault()

    loading.value = true

    try {
        const data = { email:email.value, password:password.value }
        const res = await userConnect(data)

        const token = res.token

        setItem(AUTH_KEY_STORAGE,token)

        router.push({name:"dashboard"})
        

    } catch (error:Error) {
        console.log(error.message);
        
    } finally {
        loading.value = false
    }
 
    
}


</script>

<style scoped>

</style>