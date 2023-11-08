<template>
    <div>

        <RouterView />
    </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router';

const KEY_STORAGE = import.meta.env.VITE_APP_NAME
const authStorage = localStorage.getItem(KEY_STORAGE + "_auth_token")
const router = useRouter()

if(!authStorage) router.push({name: "admin-login"})

</script>

<style scoped>

</style>