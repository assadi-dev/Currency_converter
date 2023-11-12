<template>
    <div class="card loading-section">
        <ProgressSpinner />

    </div>
</template>

<script setup lang="ts">

import ProgressSpinner from 'primevue/progressspinner';


</script>

<style scoped>
.loading-section {
    width: 100%;
    min-height: 10rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>