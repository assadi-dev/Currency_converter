<template>
    <div class="my-5 flex align-items-center gap-1">
        <Button icon="pi pi-angle-double-left" severity="secondary" rounded outlined text @click="props.goFirstPage" :disabled="!canPrev" />
        <Button icon="pi pi-angle-left" severity="secondary" rounded text outlined @click="props.goPrevPage" :disabled="!canPrev" />
        <div>{{ props.indexPage }} sur {{ props.totalRecords }} </div>
        <Button icon="pi pi-angle-right" severity="secondary" rounded outlined text @click="props.goNextPage" :disabled="!canNext" />
        <Button icon="pi pi-angle-double-right" severity="secondary" rounded outlined text @click="props.goLastPage" :disabled="!canNext" />
    </div>
</template>

<script setup lang="ts">

import Button from 'primevue/button';
import { onMounted } from 'vue';
import { ref } from 'vue';

type propsType = {
    goFirstPage?: Function,
    goPrevPage?: Function,
    goNextPage?: Function,
    goLastPage?: Function,
    indexPage?: number,
    lastPage: number,
    totalRecords?: number


}

const canNext = ref(false)
const canPrev = ref(false)

const props = defineProps<propsType>()

onMounted(() => {
    if (props?.indexPage) {
        if (props.indexPage < props.lastPage) canNext.value = true
        if (props.indexPage > 1) canPrev.value = true
    }

})


</script>

<style scoped></style>