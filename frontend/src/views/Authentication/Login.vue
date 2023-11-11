<template>
  <div class="surface-ground flex align-items-center justify-content-center page-container ">
        <div class="flex flex-column align-items-center justify-content-center">
            <!--<img :src="logoUrl" alt="logo" class="mb-5 w-6rem flex-shrink-0" />-->
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
            
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <form @submit="onSubmit" >
                    <div class="text-center mb-5">
                      <!--  <img src="/demo/images/login/avatar.png" alt="Image" height="50" class="mb-3" />-->
                        <div class="text-900 text-3xl font-medium mb-3">Connexion</div>
                    
                    </div>

                    <div>
                        <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
                        <InputText id="email1" type="email" placeholder="Email" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="email" />

                        <label for="password1" class="block text-900 font-medium text-xl mb-2">Mot de passe</label>
                        <Password id="password1" v-model="password" placeholder="Mot de passe" :toggleMask="true" class="w-full mb-3" inputClass="w-full" :inputStyle="{ padding: '1rem' }"></Password>

                        <div class="flex align-items-center justify-content-between mt-5 gap-5">
                            <Button :loading="loading" type="submit" label="Se connecter" class="w-full p-3 text-xl"></Button>
                        </div>
                      
                    </div>
             
                </form>
                </div>
             
            </div>
        </div>
    </div>
    <Toast  position="bottom-center" group="bc"  />
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import { userConnect } from '../../services/api/Auth.api';
import { AUTH_KEY_STORAGE,  setItem } from '../../services/utils/storage';
import { useRouter } from 'vue-router';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

const toast = useToast();

const router = useRouter()

const password = ref<string|null>(null)

const email = ref<string|null>(null)

const loading = ref(false)

//Toast Action

const showSuccesToast = (message:string) => {
  
        toast.add({ severity: 'success', summary: 'OK', detail: message,group:"bc",life: 3000  });
       
    
};

const showErrorToast = (message:string) => {
   
        toast.add({ severity: 'error', summary: 'Erreur', detail: message,group:"bc" ,life: 3000 });
       
};


const onSubmit = async(e) => {
    e.preventDefault()

    loading.value = true

    try {
        const data = { email:email.value, password:password.value }
        const res = await userConnect(data)

        showSuccesToast("Connexion reussie !")

        const token = res.token

        setItem(AUTH_KEY_STORAGE,token)
        setTimeout(()=> router.push({name:"dashboard",replace:true}),1000)
       
        

    } catch (error: any) {

    
        
        let message = error.message
        if (error?.response) {
         message = error?.response?.data.message
        }
      

        showErrorToast(message)
        
    } finally {
        loading.value = false
    }
 
    
}


</script>

<style scoped>

.page-container{
    height: 100vh;
    width:100%;
    overflow: hidden;
}

</style>