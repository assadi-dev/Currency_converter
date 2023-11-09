<template>
    <RouterLink v-if="item.to" :to="item.to" >
        <i :class="item.icon" class="pi pi-fw layout-menuitem-icon layout-menuitem-icon"></i>
        <span class="layout-menuitem-text">{{item.name}}</span>
    </RouterLink>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router';

type MenuItemLink = {
    name?: string
    to?: string
    icon?:string
}

defineProps<{
    item:MenuItemLink
}>()

</script>

<style scoped>

</style>