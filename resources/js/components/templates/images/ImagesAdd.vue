<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">新規追加</h1>
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
            <div class="border border-[#DFE7EF] px-[25px] py-24 rounded-b">
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">カテゴリー</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <Select
                                    v-model="category"
                                    :options="categories"
                                    optionLabel="name"
                                    placeholder="カテゴリー 一覧"
                                    class="w-80"
                                />
                                <input type="hidden" name="image_file_category_id" :value="category.id" />
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
                                                <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
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
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">画像</span>
                    </div>
                    <div class="border-l border-[#bdbdbd] px-[18px] py-[28px] w-full">
                        <div class="custom-dropzone" @dragover.prevent="onDragOver" @drop.prevent="onFileDrop">
                            <p class="font-semibold font-[16px]">ここにファイルをドロップまたは</p>
                            <input type="file" ref="fileInput" name="file[]" accept="image/*" @change="handleFileChange" multiple hidden />
                        </div>
                        <div>
                            <div class="flex justify-end">
                                <Button size="small" label="画像を選択" rounded class="mt-4" @click="triggerFileInput"/>
                            </div>
                            <p class="mt-4 text-sm text-gray-700 font-semibold">画像は複数枚選択可能です (最大20枚まで)</p>
                            <div v-if="imageUrls.length" class="mt-4">
                                <img v-for="(url, index) in imageUrls" :key="index" :src="url" alt="Selected Image" class="max-h-[150px] w-auto mr-2 mt-4" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">画質</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center space-x-4">
                            <Select
                                v-model="qualityOption"
                                :options="qualityOptions"
                                optionLabel="label"
                                class="w-full"
                            />
                            <input type="hidden" name="quality" :value="qualityOption.id" />
                        </div>
                    </div>
                </div>

                <StickRegistButton :back-path="backPath" text-back-btn="一覧に戻る"/>
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
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps(['categories', 'options', 'path', 'csrfToken', 'errormessage', 'oldInput', 'selectedCategory', 'selectedOption', 'backPath'])


const categories = ref([...props.categories])
const selectedCategory = ref(categories.value.find((value) => {
    return value.id === props.selectedCategory
}))
const category = ref(selectedCategory.value ? selectedCategory.value : '')

const qualityOptions = ref([...props.options])
const selectedOption = ref(qualityOptions.value.find((value) => {
    return value.id === props.selectedOption
}))
const qualityOption = ref(selectedOption.value ? selectedOption.value : '')

const imageUrls = ref([])
const imageFiles = ref([])
const fileInput = ref(null)
const visible = ref(false)
const categoryName = ref('')

function triggerFileInput() {
    fileInput.value.click()
}

function handleFileChange(event) {
    const files = event.target.files
    processFiles(files)
}

function onDragOver(event) {
    event.preventDefault()
}

function onFileDrop(event) {
    event.preventDefault()
    const files = event.dataTransfer.files
    processFiles(files)
    setFilesToInput(files)
}

function setFilesToInput(files) {
    fileInput.value.files = files
}

function processFiles(files) {
    imageFiles.value = Array.from(files)
    imageUrls.value = [];
    imageFiles.value.forEach(file => {
        const reader = new FileReader()
        reader.onload = (e) => imageUrls.value.push(e.target.result)
        reader.readAsDataURL(file)
    });
}

function handleSubmit() {
    const formData = new FormData();
    formData.append('name', categoryName.value)
    const route = getBaseUrl(props.path) + 'image_categories/add'

    fetch(route, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': props.csrfToken
        }
    }).then(response => {
        if (response.ok) {
            alert('画像カテゴリを追加しました')
            window.location.reload()
        } else {
            alert('画像カテゴリを追加できません')
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

<style scoped>
.custom-dropzone {
    width: 100%;
    height: 200px;
    border: 2px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
</style>
