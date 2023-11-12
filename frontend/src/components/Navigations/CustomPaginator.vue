<template>
    <div class="my-5 flex align-items-center gap-1">
        <Button icon="pi pi-angle-double-left" severity="secondary" rounded outlined text @click="props.goFirstPage"
            :disabled="canPrev" />
        <Button icon="pi pi-angle-left" severity="secondary" rounded text outlined @click="props.goPrevPage"
            :disabled="canPrev" />
        <div>{{ props.indexPage }} sur {{ props.totalPage }} </div>
        <Button icon="pi pi-angle-right" severity="secondary" rounded outlined text @click="props.goNextPage"
            :disabled="canNext" />
        <Button icon="pi pi-angle-double-right" severity="secondary" rounded outlined text @click="props.goLastPage"
            :disabled="canNext" />
    </div>
</template>

<script setup lang="ts">

import Button from 'primevue/button';
import {  watch } from 'vue';
import { ref } from 'vue';

type propsType = {
    goFirstPage?: Function,
    goPrevPage?: Function,
    goNextPage?: Function,
    goLastPage?: Function,
    indexPage?: number,
    lastPage: number,
    totalRecords?: number
    totalPage?: number


}

const canNext = ref(false)
const canPrev = ref(false)

const props = defineProps<propsType>()

watch(props, () => {

    if (props?.indexPage) {

        if (props.indexPage == props.totalPage) canNext.value = true
        else if (props.indexPage < props.totalPage) canNext.value = false


        if (props.indexPage == 1) canPrev.value = true
        else if (props.indexPage > 1) canPrev.value = false
    }


})





</script>

<style scoped></style>