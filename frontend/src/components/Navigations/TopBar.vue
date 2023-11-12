<script setup lang="ts">
import Button from "primevue/button"
import { onMounted,ref, watch } from "vue";

const sidebarElement = ref<HTMLDivElement >()
const isOpen  = ref(false)

onMounted(() => {
    sidebarElement.value = document.querySelector(".layout-sidebar");
})

const toggleMenu = () => {
    isOpen.value = !isOpen.value 
    console.log(sidebarElement.value);
    
    
}

 watch(isOpen,() => {
    if (isOpen.value) {
        sidebarElement.value.classList.add("isOpen")
    } else {
        sidebarElement.value.classList.remove("isOpen")
   }
}) 

</script>
<template>
    <div class="layout-topbar flex align-item-center">

    

            <Button class="toggle-menu" text icon="pi pi-align-justify" severity="secondary" size="large" @click="toggleMenu" />

        

    </div>
</template>


<style scoped>

.toggle-menu{
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);

}

@media screen and (min-width:992px) {
    .toggle-menu{
        display: none;
    }
}


</style>