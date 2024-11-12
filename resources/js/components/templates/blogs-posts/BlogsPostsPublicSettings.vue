<template>
    <h1 class="font-bold px-5 mb-6">公開設定</h1>
    <div class="w-full px-14 flex gap-x-14">
        <div class="flex items-center">
            <RadioButton v-model="expandForm.publish_status" inputId="public" name="publish_status" value="public" />
            <label class="ml-2" for="public">公開</label>
        </div>
        <div class="flex items-center">
            <RadioButton v-model="expandForm.publish_status" inputId="private" name="publish_status" value="private" />
            <label class="ml-2" for="private">非公開</label>
        </div>
    </div>
    <div class="border-t w-full my-6"></div>
    <h1 class="font-bold px-5 mb-6">テンプレート</h1>
    <div class="w-full px-14">
        <Checkbox v-model="expandForm.is_template" inputId="is_template" name="is_template" binary :value="expandForm.is_template"/>
        <label for="is_template" class="ml-2">新規テンプレートとして登録</label>
    </div>
    <div class="border-t w-full my-6"></div>
    <h1 class="font-bold px-5 mb-6">公開日時</h1>
    <div class="w-full px-14">
        <DatePicker name="published_at" id="datepicker-24h" v-model="expandForm.published_at" dateFormat="yy-mm-dd" hourFormat="24"
                    showTime />
    </div>
    <div class="border-t w-full my-6"></div>
    <h1 class="font-bold px-5 mb-6">SNS連動</h1>
    <div class="w-full px-14 flex flex-wrap gap-x-14">
        <div v-for="sns of snsOptions" :key="sns.id" class="flex items-center">
            <Checkbox v-model="expandForm.sns_id" :inputId="'sns_' + sns.id" name="sns_id[]" :value="sns.id"/>
            <label :for="'sns_' + sns.id" class="ml-2">{{ sns.name }}</label>
        </div>
    </div>
    <div class="border-t w-full my-6"></div>
    <h1 class="font-bold px-5 mb-6">カテゴリー</h1>
    <div class="w-full px-14 flex flex-wrap gap-x-14 gap-y-2">
        <div v-for="category of categoryOptions" :key="category.id" class="flex items-center">
            <Checkbox v-model="expandForm.category_id" :inputId="'category_' + category.id" :value="category.id"
                      name="category_id[]" />
            <label :for="'category_' + category.id" class="ml-2">{{ category.name }}</label>
        </div>
    </div>
</template>

<script setup>

import Checkbox from 'primevue/checkbox'
import DatePicker from 'primevue/datepicker'
import RadioButton from 'primevue/radiobutton'
import {ref, defineProps, reactive} from 'vue'
const props = defineProps(['snses', 'categories', 'errorMessage', 'dataUpdate', 'oldInput'])
const snsOptions = ref(props.snses)
const categoryOptions = ref(props.categories)
const errorMessage = ref(props.errorMessage)
const dataUpdate = reactive(props.dataUpdate)

/*const publicForm = ref({
    publish_status: '',
    published_at: '',
    sns_id: [''],
    category_id: [''],
    is_template: false
})*/

const expandForm = reactive({
    publish_status: props.oldInput.publish_status ?? dataUpdate?.publish_status ?? 'public',
    published_at: props.oldInput.published_at ?? dataUpdate?.published_at ?? '',
    sns_id: props.oldInput.sns_id ?? dataUpdate?.sns_id ?? [''],
    category_id: props.oldInput.category_id ?? dataUpdate?.category_id ?? [''],
    is_template: props.oldInput.is_template ?? dataUpdate?.is_template ?? false,
})

</script>
