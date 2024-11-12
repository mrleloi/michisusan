<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">埋め込みスクリプト</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[28px] text-[14px] text-sm flex items-center">
            <span class="text-[#FF0000] text-[12px] font-semibold">
                ※
            </span>
            <span>
               は入力必須項目です。
            </span>
        </div>
        <form :action="props.path" @submit.prevent="onSubmit" method="post" class="mb-[33px] mt-[80px]">
            <input type="hidden" name="_token" :value="props.csrfToken" />
            <div class="border border-[#DFE7EF] px-[25px] py-[21px] rounded-b font-[Inter]">
                <div class="border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="flex items-center">
                        <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                            <span class="text-base">タイトル</span>
                        </div>
                        <div class="flex align-middle flex-wrap border-[#bdbdbd] px-[18px] pt-[27px] pb-[27px] w-full border-l">
                            <InputText class="w-[88%]" v-model="siteMapForm.sitemap_title" name="sitemap_title" maxLength="35" />
                            <div class="pl-[32px] flex items-center justify-end">
                                <span class="text-right font-semibold">{{siteMapForm.sitemap_title.length}}文字/35文字</span>
                            </div>
                            <span class="text-red-500 text-[12px]" v-if="props.errormessage?.sitemap_title?.length">{{props.errormessage?.sitemap_title?.[0]}}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">description</span>
                    </div>
                    <div class="flex align-middle flex-wrap border-[#bdbdbd] px-[18px] pt-[27px] pb-[27px] w-full border-l">
                        <InputText class="w-[88%]" v-model="siteMapForm.sitemap_description" name="sitemap_description" maxLength="35" />
                        <div class="pl-[32px] flex items-center justify-end">
                            <span class="text-right font-semibold">{{siteMapForm.sitemap_description.length}}文字/250文字</span>
                        </div>
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.sitemap_description?.length">{{props.errormessage?.sitemap_description?.[0]}}</span>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">h1テキスト</span>
                    </div>
                    <div class="flex align-middle flex-wrap border-[#bdbdbd] px-[18px] pt-[27px] pb-[27px] w-full border-l">
                        <InputText class="w-[88%]" v-model="siteMapForm.sitemap_h1" name="sitemap_h1" maxLength="35" />
                        <div class="pl-[32px] flex items-center justify-end">
                            <span class="text-right font-semibold">{{siteMapForm.sitemap_h1.length}}文字/35文字</span>
                        </div>
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.sitemap_h1?.length">{{props.errormessage?.sitemap_h1?.[0]}}</span>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">keywords</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[27px] pb-[27px] w-full border-l">
                        <InputText v-model="siteMapForm.sitemap_keywords" class="w-full h-[38px] mx-1.25" name="sitemap_keywords" maxLength="35"/>
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.sitemap_keywords?.length">{{props.errormessage?.sitemap_keywords?.[0]}}</span>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">大見出し</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[27px] pb-[27px] w-full border-l">
                        <InputText v-model="siteMapForm.sitemap_subentry" class="w-full h-[38px] mx-1.25" name="sitemap_subentry" maxLength="255"/>
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.sitemap_subentry?.length">{{props.errormessage?.sitemap_subentry?.[0]}}</span>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">小見出し</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[27px] pb-[27px] w-full border-l">
                        <InputText v-model="siteMapForm.sitemap_entry" class="w-full h-[38px] mx-1.25" name="sitemap_entry" maxLength="255"/>
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.sitemap_entry?.length">{{props.errormessage?.sitemap_entry?.[0]}}</span>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] border-[#bdbdbd]">
                        <span class="text-base">サイトマップへのリンク</span>
                    </div>
                    <div class="w-full border-[#bdbdbd] px-[18px] pt-[36px] pb-[36px] pl-[20px]  w-full border-l">
                        <Checkbox v-model="siteMapForm.sitemap_flag" binary class="flex gap-1" inputId="sitemapFlag" name="sitemap_flag" />
                        <label for="sitemapFlag" class="ml-2">フッターにサイトマップページへのリンクを表示</label>
                    </div>
                    <span class="text-red-500 text-[12px]" v-if="props.errormessage?.sitemap_flag?.length">{{props.errormessage?.sitemap_flag?.[0]}}</span>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">リンクテキスト</span>
                    </div>
                    <div class="border-[#bdbdbd] flex flex-col border-l">
                        <div class=" px-[18px] pt-[36px] pb-[12px] w-full">
                            <InputText v-model="siteMapForm.sitemap_link" class="w-full h-[38px] mx-1.25" name="sitemap_link" maxLength="250"/>
                            <span class="text-red-500 text-[12px]" v-if="props.errormessage?.sitemap_link?.length">{{props.errormessage?.sitemap_link?.[0]}}</span>
                        </div>
                        <div class="ml-[20px] text-[14px]">
                            <p>フッターにサイトマップページへのリンクを表示する際のテキストです</p>
                            <p>空欄の場合は『サイトマップ』と表示されます</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">サイトマップの見出し画像</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[20px] pt-[44px] w-full border-l">
                        <div class="flex items-center mb-[22px]">
                            <ImageSelector name="sitemap_image" :value="siteMapForm.sitemap_image"/>
                        </div>
                        <p class="mb-[25px]">推奨サイズは横1920px以上、縦360px以上です</p>
                    </div>
                </div>

                <StickRegistButton :back-path="backPath" text-back-btn="ダッシュボードに戻る"/>
            </div>
        </form>
    </div>
</template>
<script setup>
import InputText from "primevue/inputtext";
import Checkbox from "primevue/checkbox";
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import {defineProps, reactive, ref } from "vue";
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps(['site', 'path', 'csrfToken', 'oldInput', 'errormessage', 'backPath'])
const site = reactive(props.site)

console.log(site, 'site')

const siteMapForm = reactive({
    sitemap_title: props.oldInput?.sitemap_title ?? site.sitemap_title ?? '',
    sitemap_description: props.oldInput?.sitemap_description ?? site.sitemap_description ?? '',
    sitemap_h1: props.oldInput?.sitemap_h1 ?? site.sitemap_h1 ?? '',
    sitemap_keywords: props.oldInput?.sitemap_keywords ?? site.sitemap_keywords ?? '',
    sitemap_subentry: props.oldInput?.sitemap_subentry ?? site.sitemap_subentry ?? '',
    sitemap_entry: props.oldInput?.sitemap_entry ?? site.sitemap_entry ?? '',
    sitemap_flag: props.oldInput?.sitemap_flag ?? site.sitemap_flag ? true : false,
    sitemap_link: props.oldInput?.sitemap_link ?? site.sitemap_link ?? '',
    sitemap_image: props.oldInput?.sitemap_image ?? site.sitemap_image ?? ''
})

const goBackDashBoard = () => {
    window.location.href = '/admin'
}

const onSubmit = async (e) => {
    e.target.submit()
}
</script>
