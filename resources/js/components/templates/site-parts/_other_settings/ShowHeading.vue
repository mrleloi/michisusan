<template>
    <div class="text-sm">
        <p class="font-bold px-4">見出し設定</p>
        <div class="pl-8">
            <p class="font-bold pt-6">見出しの有無</p>
            <div class="flex pt-4">
                <div>
                    <RadioButton :inputId="`not_show-${randomId}`" :value="SHOW_HEADING_TYPE.NONE" v-model="model"/>
                    <label class="ml-2" :for="`not_show-${randomId}`">表示しない</label>
                </div>
                <div>
                    <RadioButton :inputId="`title_and_subtitle-${randomId}`" :value="SHOW_HEADING_TYPE.SHOW_TITLE_AND_SUBTITLE" class="ms-[37px]" v-model="model"/>
                    <label class="ml-2" :for="`title_and_subtitle-${randomId}`">別ウインドウで開く</label>
                </div>
                <div>
                    <RadioButton :inputId="`only_title-${randomId}`" :value="SHOW_HEADING_TYPE.SHOW_ONLY_TITLE" class="ms-[37px]" v-model="model"/>
                    <label class="ml-2" :for="`only_title-${randomId}`">別ウインドウで開く</label>
                </div>
            </div>
        </div>

        <div v-if="model !== SHOW_HEADING_TYPE.NONE">
            <div class="liner"></div>

            <p class="font-bold px-8">見出しのデザイン</p>
            <ul class="flex flex-wrap">
                <template v-for="t in headingTypes">
                    <li
                        :id="`design-type-${t.designType}`"
                        class="p-4 w-1/2 cursor-pointer flex items-center justify-center"
                        @click="attributes = t"
                    >
                        <div
                            class="w-3/4 bg-[#f1eeeb] relative border-blue-400"
                            :class="{ 'border-4': attributes.designType === t.designType }"
                        >
                            <div
                                class="absolute top-2 left-2 bg-[#2d3a4c] text-white p-3 rounded-full"
                            >
                                <p
                                    class="absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%]"
                                >
                                    {{ t.designType }}
                                </p>
                            </div>
                            <Heading :attributes="t" />
                        </div>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</template>

<script setup>
import RadioButton from 'primevue/radiobutton'
import { SHOW_HEADING_TYPE } from '@/composables/site-part.js'
import Heading from '../Heading/Heading.vue'
import { ref } from 'vue'

const model = defineModel()
const attributes = defineModel('attributes')
const randomId = Math.random().toString(36).slice(6)

const headingTypes = ref(
    [1, 2, 3, 4, 5, 6, 7].map(v => ({
        designType: v,
        title: 'タイトルテキスト',
        titleStyle: '',
        subtitle: 'サブタイトルテキスト',
        subtitleStyle: '',
        id: '',
        className: '',
        style: '',
        showPCView: false,
        showSPView: false,
        position: 'center',
        containerWidth: '1200px',
        containerFullSize: true,
        paddingTop: '30px',
        paddingBottom: '30px',
        textColor: '',
        backgroundColor: '',
        backGroundImage: '',
        fadein: '',
        anchor: ''
    }))
)

</script>

<style scoped>

</style>
