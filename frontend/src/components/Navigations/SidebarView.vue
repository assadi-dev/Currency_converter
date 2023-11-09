<script setup lang="ts">
import LogoutBtn from './LogoutBtn.vue';
import MenuItem from './MenuItem.vue';

const sidebarRoutes = [
    {
        name: "Tableau de board",
        to: "/admin/dashboard",
        icon:"pi-home",
    },
    {
        name: "Devises",
        to: "/admin/currencies",
        icon:"pi-money-bill"
    },
    {
        name: "Taux de conversion",
        to: "/admin/pair-currencies", 
        icon:"pi-bitcoin"
    },


]
        
</script>
<template>
         <div class="layout-sidebar">

<ul class="layout-menu" >
    <li class="layout-root-menuitem">
        <div class="layout-menuitem-root-text">Menu</div>
      
       <template v-for="item in sidebarRoutes" :key="item.name" >
        <MenuItem :item="item"   />
    </template>
        
    </li>
    <li class="layout-root-menuitem">
        <LogoutBtn />
    </li>
</ul>



</div>
</template>


<style scoped>

</style>