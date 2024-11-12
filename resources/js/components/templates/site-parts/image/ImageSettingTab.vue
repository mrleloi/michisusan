<template>
    <div class="pt-8">
        <ShowOnDevice v-model:attributes="attributes"/>

        <div class="liner"></div>

        <ShowHeading
            v-model="attributes.showHeadingType"
            v-model:attributes="attributes.headingAttributes" />

        <div class="liner"></div>

        <NumberOfImages v-model="attributes.numberOfImages" />

        <div class="liner"></div>

        <div>
            <p class="font-bold flex justify-between items-center px-4">
                <span>その他設定</span>
                <i class="pi pi-angle-down"></i>
            </p>

            <div class="px-8">
                <div class="mt-8">
                    <p class="font-bold mb-8">大枠装飾</p>

                    <div class="w-1/2">
                        <ShowBackgroundColor
                            class="mb-3"
                            v-model="attributes.styles.frame.backgroundColor"
                            v-model:styleSettings="attributes.styleSettings.frame"/>
                        <ShowRoundedCorners
                            class="mb-3"
                            v-model="attributes.styles.frame.borderRadius"
                            v-model:styleSettings="attributes.styleSettings.frame"/>
                        <ShowBorder
                            class="mb-3"
                            v-model="attributes.styles.frame.border"
                            v-model:styleSettings="attributes.styleSettings.frame"/>
                        <ShowBoxShadow
                            v-model="attributes.styles.frame.boxShadow"
                            v-model:styleSettings="attributes.styleSettings.frame"/>
                    </div>
                    <p class="mt-6">デザインによっては装飾が反映されない場合がございます。</p>
                </div>

                <div class="liner"></div>

                <div>
                    <p class="font-bold mb-8">アイテム装飾</p>

                    <div class="w-1/2">
                        <ShowBackgroundColor
                            class="mb-3"
                            v-model="attributes.styles.item.backgroundColor"
                            v-model:styleSettings="attributes.styleSettings.item"/>
                        <ShowRoundedCorners
                            class="mb-3"
                            v-model="attributes.styles.item.borderRadius"
                            v-model:styleSettings="attributes.styleSettings.item"/>
                        <ShowBorder
                            class="mb-3"
                            v-model="attributes.styles.item.border"
                            v-model:styleSettings="attributes.styleSettings.item"/>
                        <ShowBoxShadow
                            v-model="attributes.styles.item.boxShadow"
                            v-model:styleSettings="attributes.styleSettings.item"/>
                    </div>
                    <p class="mt-6">デザインによっては装飾が反映されない場合がございます。</p>
                </div>

                <div class="liner"></div>

                <div>
                    <p class="font-bold mb-8">画像装飾</p>

                    <div class="w-1/2">
                        <ShowBoxShadow
                            class="mb-3"
                            v-model="attributes.styles.image.boxShadow"
                            v-model:styleSettings="attributes.styleSettings.image"/>
                        <div class="mb-3">
                            <Checkbox binary input-id="frame-check" class="mr-2"></Checkbox>
                            <label for="frame-check">枠</label>
                        </div>
                        <div class="mb-3">
                            <Checkbox binary input-id="shifting-bg-check" class="mr-2"></Checkbox>
                            <label for="shifting-bg-check">ずらし背景</label>
                        </div>
                        <div class="mb-3">
                            <Checkbox binary input-id="corner-check" class="mr-2"></Checkbox>
                            <label for="corner-check">角装飾</label>
                        </div>
                        <div class="mb-3">
                            <Checkbox binary input-id="filter-check" class="mr-2"></Checkbox>
                            <label for="filter-check">フィルター</label>
                        </div>
                    </div>
                    <p class="mt-6">
                        全て色選択可<br>
                        デザインによっては装飾が反映されない場合がございます。
                    </p>
                </div>

                <div class="liner"></div>

                <ImageClip v-model="attributes.styles.image.clipPath" v-model:styles="attributes.styles.image"/>

                <div class="liner"></div>

                <SizeWidth class="mb-3" v-model="attributes.styles.image.width">
                    <template v-slot:title>
                        画像サイズ幅<span class="text-red-500">※</span>
                    </template>
                </SizeWidth>
                <SizeWidthSP v-model:styles="attributes.styles.image">
                    <template v-slot:title>
                        sp時画像サイズ幅<span class="text-red-500">※</span>
                    </template>
                </SizeWidthSP>
            </div>
        </div>

        <div class="liner"></div>

        <div>
            <p class="font-bold mb-8 px-4">class、id設定</p>
            <div class="px-8">
                <IncludeClass class="mb-3" v-model="attributes.classes" />
                <IncludeId v-model="attributes.id" />
            </div>
        </div>

        <div class="liner"></div>

        <IncludeCss v-model="attributes.css" />
    </div>
</template>

<script setup>
import ShowOnDevice from '../_other_settings/ShowOnDevice.vue'
import ShowHeading from '../_other_settings/ShowHeading.vue'
import NumberOfImages from '../_other_settings/NumberOfImages.vue'
import ShowBackgroundColor from '../_other_settings/ShowBackgroundColor.vue'
import ShowRoundedCorners from '../_other_settings/ShowRoundedCorners.vue'
import ShowBorder from '../_other_settings/ShowBorder.vue'
import ShowBoxShadow from '../_other_settings/ShowBoxShadow.vue'
import Checkbox from 'primevue/checkbox'
import ImageClip from '../_other_settings/ImageClip.vue'
import SizeWidth from '../_other_settings/SizeWidth.vue'
import SizeWidthSP from '../_other_settings/SizeWidthSP.vue'
import IncludeClass from '../_other_settings/IncludeClass.vue'
import IncludeId from '../_other_settings/IncludeId.vue'
import IncludeCss from '../_other_settings/IncludeCss.vue'

const attributes = defineModel('attributes')
</script>

<style scoped>
</style>
