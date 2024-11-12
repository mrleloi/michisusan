<template>
    <form method="POST" :action="props.formPath" class="flex flex-wrap items-center gap-2" id="sortable-list-main-form">
        <input type="hidden" name="_token"  :value="props.csrfToken">
        <Select v-model="category" :options="categories" optionLabel="name" placeholder="カテゴリー 一覧" class="h-[38px]"></Select>
        <input type="hidden" name="blogs_post_category_id" :value="category.id">
        <Select v-model="maxViewOption" :options="maxViewOptions" optionLabel="text" class="h-[38px]"></Select>
        <input type="hidden" name="blogs_post_max_view" :value="maxViewOption.value">
        <InputText v-model.trim="filledKeyword" placeholder="キーワード" class="w-[141px] h-[38px]" :value="filledKeyword" name="blogs_post_keyword"/>
        <Select v-model="publicStatus" :options="publicStatusOptions" optionLabel="text" placeholder="公開設定" class="h-[38px]"></Select>
        <input type="hidden" name="blogs_post_public_status" :value="publicStatus.value">
        <Button size="small" label="表示更新" rounded type="submit"></Button>
    </form>
</template>

<script setup>
import Button from 'primevue/button'
import Select from 'primevue/select'
import { ref, reactive } from 'vue'
import InputText from "primevue/inputtext";

const props = defineProps(['formPath', 'categories', 'maxViewOptions', 'csrfToken', 'selectedOption', 'selectedCategory', 'filledKeyword', 'selectedPublicStatus'])

const filledKeyword = ref(props.filledKeyword ?? '')
const categories = ref([...[{name: 'カテゴリー 一覧', id: ''}], ...props.categories])
const selectedCategory = ref(categories.value.find((value) => {
    return value.id == props.selectedCategory
}))
const category = ref(selectedCategory.value ? selectedCategory.value : '')
const selectedOption = ref(props.selectedOption ?? '')
const maxViewOption = ref(selectedOption.value.length ? {text: selectedOption.value + '件表示', value: parseInt(selectedOption.value)} : {text: '10件表示', value: 10})
const maxViewOptions = reactive(props.maxViewOptions.map((value) => {
    return {text: value + '件表示', value}
}))

const publicStatusOptions = ref([
    { text: '公開', value: 1 },
    { text: '非公開', value: 0 },
    { text: '公開予約', value: 2}
])
const selectedPublicStatus = ref(publicStatusOptions.value.find((value) => {
    return value.value == props.selectedPublicStatus
}))
const publicStatus = ref(selectedPublicStatus.value ? selectedPublicStatus.value : '')
</script>
