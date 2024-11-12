<template>
    <form method="POST" :action="props.formPath" class="flex flex-wrap items-center gap-2" id="sortable-list-main-form">
        <input type="hidden" name="_token"  :value="props.csrfToken">
        <Select v-model="category" :options="categories" optionLabel="name" placeholder="カテゴリー 一覧" class="h-[38px] flex items-center justify-center text-center"></Select>
        <input type="hidden" name="news_article_category_id" :value="category.id">
        <Select v-model="maxViewOption" :options="maxViewOptions" optionLabel="text" class="h-[38px] w-48"></Select>
        <input type="hidden" name="news_article_max_view" :value="maxViewOption.value">
        <Button size="small" label="表示更新" rounded type="submit"></Button>
    </form>
</template>

<script setup>
import Button from 'primevue/button'
import Select from 'primevue/select'
import { ref, reactive } from 'vue'

const props = defineProps(['formPath', 'categories', 'maxViewOptions', 'csrfToken', 'selectedOption', 'selectedCategory'])

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
</script>
