<template>
    <template v-if="tab === ''">
        <h1 class="pl-4 font-bold text-xl">見出しデザイン</h1>

        <ul class="flex flex-wrap">
            <template v-for="t in designTypes">
                <li
                    :id="`design-type-${t.designType}`"
                    class="p-4 w-1/2 cursor-pointer flex items-center justify-center"
                    @click="attributes = t">
                    <div
                        class="w-3/4 bg-[#f1eeeb] relative border-blue-400"
                        :class="{ 'border-4': attributes.designType === t.designType }">
                        <div class="absolute top-2 left-2 bg-[#2d3a4c] text-white p-3 rounded-full">
                            <p class="absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%]">
                                {{ t.designType }}
                            </p>
                        </div>
                        <Image :attributes="t" />
                    </div>
                </li>
            </template>
        </ul>
    </template>

    <template v-else>
        <ImageSettingTab v-model:attributes="attributes"/>
    </template>
</template>

<script setup>
import { storeToRefs } from 'pinia'
import { usePartsSettingStore } from '@/store/parts-setting.js'
import { onMounted, ref } from 'vue'
import Image from './Image.vue'
import { LINK_SETTING_TYPE } from '@/composables/site-part.js'
import ImageSettingTab from './ImageSettingTab.vue'
import { SHOW_HEADING_TYPE } from '@/composables/site-part.js'

const designTypes = ref(
    [3, 4].map(v => ({
        designType: v,
        classes: '',
        id: '',
        css: '',
        image: null,
        previewImagePath: null,
        anchor: '',
        linkSettingType: LINK_SETTING_TYPE.NONE,
        linkSettingUrl: '',
        openLinkOnNewTab: 0,
        showPCView: true,
        showSPView: true,
        showHeadingType: SHOW_HEADING_TYPE.NONE,
        headingAttributes: {},
        numberOfImages: 2,
        styleSettings: {
            frame: {},
            item: {},
            image: {
                width: 20,
            },
        },
        styles: {
            frame: {},
            item: {},
            image: {
                width: '20%',
            },
        },
    }))
)

const store = usePartsSettingStore()
const { partsType, attributes, tab } = storeToRefs(store)

onMounted(() => {
    tab.value = ''
    partsType.value = 'Image'
    attributes.value = designTypes.value[0]
})
</script>

<style scoped>

</style>
