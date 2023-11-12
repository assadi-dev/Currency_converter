<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, rgba(33, 150, 243, 0.4) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8 flex flex-column align-items-center" style="border-radius: 53px">
                    <span class="text-blue-500 font-bold text-3xl">404</span>
                    <h1 class="text-900 font-bold text-3xl lg:text-5xl mb-2">Erreur !</h1>
                    <div class="text-600 mb-5">Desolé vous essayé d'acceder à une page qui n'existe pas.</div>
                    <Button label="Revenire à la page d'accueil" icon="pi pi-home" class="p-button-text" @click="goHome" />

                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router"
import Button from "primevue/button"
const router = useRouter()


const goHome = () => {
    router.push({name:"home"})
}

</script>

<style scoped>

</style>