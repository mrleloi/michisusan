<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold leading-[33px] mb-3">新規追加</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[30px] text-[14px] text-sm flex items-center">
            <span class="text-[#FF0000] text-[12px] font-semibold">
                ※
            </span>
            <span>
               は入力必須項目です。
            </span>
        </div>
        <form :action="props.path" @submit.prevent="onSubmit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" :value="props.csrfToken">
            <div class="border border-[#DFE7EF] px-[25px] py-24 rounded-b font-[Inter]">
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">カテゴリー</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <Select
                                    v-model="category"
                                    :options="categories"
                                    optionLabel="name"
                                    placeholder="選択してください"
                                    class="w-80"
                                />
                                <input type="hidden" name="video_category_id" :value="category.id" />
                            </div>

                            <Button size="small" label="カテゴリーの新規追加" rounded @click="visible = true" />
                            <Dialog v-model:visible="visible" header="カテゴリー新規追加" :style="{ width: '60rem' }">
                                <form @submit.prevent="handleSubmit">
                                    <div class="border">
                                        <div class="bg-zinc-200 p-4">
                                            <span class="text-red-500">※</span>は入力必須項目です。
                                        </div>
                                        <div class="p-4">
                                            <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8]">
                                                <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                                                    <span class="text-base">カテゴリー名</span><span class="text-[#FF0000]">※</span>
                                                </div>
                                                <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                                                    <InputText class="w-full h-[38px]" v-model.trim="categoryName" name="name" maxLength="80"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center gap-[32px] mt-16">
                                        <button class="text-white bg-[#4CD07D] w-[174px] h-[40px] text-sm font-bold rounded-full" type="submit">
                                            登録
                                        </button>
                                    </div>
                                </form>
                            </Dialog>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">動画</span>
                    </div>
                    <div class="border-l border-[#bdbdbd] px-[18px] py-[28px] w-full">
                        <div class="flex justify-start items-center">
                            <Button size="small" label="ファイルを選択" class="mr-4" rounded @click="triggerFileInput"/>
                            <input type="file" ref="fileInput" name="file" accept="video/*" @change="handleFileChange" hidden />
                            <span v-if="fileName">{{ fileName }}</span>
                            <span v-else>選択されていません</span>
                        </div>
                        <p class="mt-4 text-sm text-gray-700 font-semibold">動画は1本のみ選択可能です（1本当り10MB以内）</p>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-[32px] mt-16">
                    <Button v-slot="slotProps" asChild>
                        <button
                            v-bind="slotProps.a11yAttrs"
                            class="text-white bg-[#FF3D32] w-[174px] h-[40px] text-sm font-bold rounded-full"
                            type="button"
                            @click="goBackToList"
                        >
                            一覧に戻る
                        </button>
                    </Button>
                    <Button v-slot="slotProps" asChild>
                        <button
                            v-bind="slotProps.a11yAttrs"
                            class="text-white bg-[#4CD07D] w-[174px] h-[40px] text-sm font-bold rounded-full"
                            type="submit"
                        >
                            登録
                        </button>
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import Button from 'primevue/button'
import Select from 'primevue/select'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import {reactive, defineProps, ref} from 'vue'

const props = defineProps(['categories', 'path', 'csrfToken', 'errormessage', 'oldInput', 'selectedCategory'])


const categories = ref([...props.categories])
const selectedCategory = ref(categories.value.find((value) => {
    return value.id === props.selectedCategory
}))
const category = ref(selectedCategory.value ? selectedCategory.value : '')

const fileInput = ref(null)
const visible = ref(false)
const categoryName = ref('')
const fileName = ref('')

function triggerFileInput() {
    fileInput.value.click()
}

function handleFileChange(event) {
    const files = event.target.files;
    if (files.length > 0) {
        const file = files[0];
        if (file.size > 10485760) { // 10 MB in bytes
            alert('ファイルサイズは10MB以下でご用意ください。')
            fileName.value = ''
            fileInput.value.value = ''
        } else {
            fileName.value = file.name
        }
    } else {
        fileName.value = ''
    }
}

const goBackToList = () => {
    window.location.href = '/admin/videos'
}

function handleSubmit() {
    const formData = new FormData();
    formData.append('name', categoryName.value)
    const route = getBaseUrl(props.path) + 'video_categories/add'

    fetch(route, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': props.csrfToken
        }
    }).then(response => {
        if (response.ok) {
            alert('動画カテゴリーを追加しました')
            window.location.reload()
        } else {
            alert('ビデオカテゴリを追加できません')
        }
    })
}

function getBaseUrl(url) {
    return url.replace(/(\/admin\/).*/, '$1');
}

const onSubmit = async e => {
    e.target.submit()
}
</script>
