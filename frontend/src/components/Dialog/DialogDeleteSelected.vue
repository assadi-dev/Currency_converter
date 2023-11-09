<script setup lang="ts">
import Button from 'primevue/button';



 type Props = {

    message?: string

} 

const props = defineProps<Props>() 






        
</script>
<template>
    <div class="flex align-items-center justify-content-center">
        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
        <span >{{ props.message }}</span>
    </div> 
</template>


<style scoped>

</style>