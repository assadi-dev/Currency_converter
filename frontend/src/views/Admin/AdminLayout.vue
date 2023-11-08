<template>
    <div>

        <RouterView />
    </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router';
import { AUTH_KEY_STORAGE } from '../../services/utils/storage';

const authStorage = localStorage.getItem(AUTH_KEY_STORAGE)
const router = useRouter()

if(!authStorage) router.push({name: "admin-login"})

</script>

<style scoped>

</style>