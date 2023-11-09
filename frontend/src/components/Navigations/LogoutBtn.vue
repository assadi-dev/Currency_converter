<template>
    <button class="logout-btn" @click="onLogout" >
        <i  class="pi-sign-out pi pi-fw layout-menuitem-icon layout-menuitem-icon"></i>
    <span class="layout-menuitem-text">Deconnexion</span>
    </button>

</template>

<script setup lang="ts">
import { useRouter } from "vue-router"
import {useUserAuth} from "../../composable/auth.composable"

const router  = useRouter()

const { logout } = useUserAuth()

const onLogout = () => {
    logout()
    router.push({name:"admin-login",replace:true })
}

</script>

<style scoped>

.logout-btn{
    outline: none;
    background-color: transparent;
    border: none;
    padding: 0.75rem 1rem;
    cursor: pointer;

}

</style>