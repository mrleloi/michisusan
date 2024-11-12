<template>
    <form method="POST" :action="props.formPath" class="flex flex-wrap items-center gap-2" id="sortable-list-main-form">
        <div class="flex gap-[12px]">
            <input type="hidden" name="_token"  :value="props.csrfToken">
            <Select v-model="maxViewOption" :options="maxViewOptions" optionLabel="text" class="h-[38px] w-48"></Select>
            <input type="hidden" name="news_category_max_view" :value="maxViewOption.value">
            <InputText v-model.trim="filledKeyword" placeholder="キーワード" class="w-[141px] h-[38px]" :value="filledKeyword" name="news_category_keyword"/>
            <Button size="small" label="表示更新" rounded type="submit"></Button>
        </div>
    </form>
</template>

<script setup>
import Button from 'primevue/button'
import Select from 'primevue/select'
import InputText from 'primevue/inputtext'
import { ref, reactive } from 'vue'

const props = defineProps(['formPath', 'maxViewOptions', 'csrfToken', 'selectedOption', 'filledKeyword'])

const filledKeyword = ref(props.filledKeyword ?? '')
const selectedOption = ref(props.selectedOption ?? '')
const maxViewOption = ref(selectedOption.value.length ? {text: selectedOption.value + '件表示', value: parseInt(selectedOption.value)} : {text: '10件表示', value: 10})
const maxViewOptions = reactive(props.maxViewOptions.map((value) => {
    return {text: value + '件表示', value}
}))
</script>
