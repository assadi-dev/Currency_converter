<template>
    <div class="layout-wrapper">
        <div class="layout-topbar">


        </div>

        <main class="layout-main-container">
            <SidebarView />

            <div class="main-content">
                <RouterView />
            </div>

        </main>
    </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router';
import { AUTH_KEY_STORAGE } from '../../services/utils/storage';
import SidebarView from "../../components/Navigations/SidebarView.vue"


const authStorage = localStorage.getItem(AUTH_KEY_STORAGE)
const router = useRouter()

if (!authStorage) router.push({ name: "admin-login" })

</script>

<style scoped></style>