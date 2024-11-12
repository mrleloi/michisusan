<template>
    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
        <div class="flex-1">
            <div class="flex justify-left">
                <div class="w-1/4 p-1">
                    <RadioButton inputId="select" :name="`link_type_${inputId}`" :value="1" v-model="formMenu.link_type" />
                    <label class="ml-2" for="select">リストから選ぶ</label>
                </div>
                <div class="w-1/4 p-1">
                    <RadioButton inputId="input" :name="`link_type_${inputId}`" :value="2" v-model="formMenu.link_type" />
                    <label class="ml-2" for="input">直接入力する</label>
                </div>
            </div>
        </div>
        <div v-if="formMenu.link_type == typeSelect">
            <Select
                v-model="pageType"
                :options="listPages"
                :optionLabel="formatOptionLabel"
                placeholder="選択してください"
                class="w-full"
            />
            <input type="hidden" :name="`link01_${inputId}`" :value="pageType.key" />
            <input type="hidden" :name="`link02_${inputId}`" :value="null" />
        </div>
        <div v-if="formMenu.link_type == typeInput">
            <InputText class="w-full" v-model.trim="formMenu.link02" :name="`link02_${inputId}`" maxLength="255" placeholder="入力してください"/>
            <input type="hidden" :name="`link01_${inputId}`" :value="null" />
        </div>
        <div>
            <p class="text-[14px]">URL</p>
            <InputText class="w-full" v-model.trim="formMenu.url" :name="`url_${inputId}`" maxLength="255" placeholder="入力してください"/>
        </div>
        <div class="mt-2">
            <ImageSelector :name="`media_${inputId}`" :value="formMenu.media"/>
        </div>
        <div class="mt-2">
            <p class="text-[14px]">ボタンに表示する文言</p>
            <InputText class="w-full mt-2" v-model.trim="formMenu.text" :name="`text_${inputId}`" maxLength="255"/>
        </div>
    </div>
</template>

<script setup>
import {defineProps, reactive, ref} from 'vue'
import InputText from 'primevue/inputtext'
import RadioButton from 'primevue/radiobutton'
import Select from 'primevue/select'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'

const props = defineProps(['pages', 'oldInput', 'formData', 'inputId'])
const typeSelect = 1
const typeInput = 2

const inputId = props.inputId

const formMenu = reactive({
    input_id: props.inputId,
    link_type: props.oldInput?.link_type ?? typeSelect,
    link01: props.oldInput?.link01 ?? '',
    link02: props.oldInput?.link02 ?? '',
    url: props.oldInput?.url ?? '',
    media: props.oldInput?.media ?? '',
    text: props.oldInput?.text ?? '',
})

const listPages = ref([...props.pages])

const selectedPageType = ref(listPages.value.find((value) => {
    return value.key === (props.oldInput?.link01 || props.selectedPageType)
}))
const pageType = ref(selectedPageType.value ? selectedPageType.value : '')

const formatOptionLabel = (page) => `${page.label}: ${page.uri}`
</script>
