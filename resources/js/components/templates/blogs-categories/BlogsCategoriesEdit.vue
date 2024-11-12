<template>
    <div class="w-full h-full px-3 font-[Inter] mt-6">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">編集画面</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[30px] text-[14px] text-sm flex items-center">
            <span class="text-[#FF0000] text-[12px] font-semibold">
                ※
            </span>
            <span>
               は入力必須項目です。
            </span>
        </div>
        <form :action="props.path" @submit.prevent="onSubmit" method="post">
            <input type="hidden" name="_token" :value="props.csrfToken">
            <div class="border border-[#DFE7EF] px-[25px] py-[21px] rounded-b">
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">カテゴリー名</span><span class="text-[#FF0000]">※</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model.trim="categoryForm.name" name="name" maxLength="30"/>
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.name?.length">{{props.errormessage?.name?.[0]}}</span>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px]">
                        <span class="text-base">説明文</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="mb-[26px]">
                            <label class="text-sm font-medium">見出し</label>
                            <InputText class="w-full h-[38px]" v-model.trim="categoryForm.description_heading" name="description_heading" maxLength="80"/>
                        </div>
                        <div class="mb-[26px]">
                            <label class="text-sm font-medium">上部詳細</label>
                            <Textarea class="w-full h-[108px]" v-model.trim="categoryForm.description_top" name="description_top" maxLength="1000"/>
                        </div>
                        <div>
                            <label class="text-sm font-medium">下部詳細</label>
                            <Textarea class="w-full h-[108px]" v-model.trim="categoryForm.description_bottom" name="description_bottom" maxLength="1000"/>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">説明文の表示</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <RadioButton inputId="show_description_private" name="show_description" :value="0" v-model="categoryForm.show_description"/>
                        <label class="ml-2" for="show_description_private">表示しない</label>
                        <RadioButton inputId="show_description_public" name="show_description" :value="1" class="ms-[37px]" v-model="categoryForm.show_description"/>
                        <label class="ml-2" for="show_description_public">表示する</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">h1テキスト</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model.trim="categoryForm.h1_text" name="h1_text" maxLength="80"/>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">カテゴリ選択時テキスト</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model.trim="categoryForm.seleted_text" name="seleted_text" maxLength="80"/>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">リンク先</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <RadioButton inputId="not_displayed" name="link_type" :value="1" v-model.trim="categoryForm.link_type"/>
                        <label class="ml-2" for="not_displayed">表示しない</label>
                        <RadioButton inputId="in-site_link" name="link_type" :value="2" class="ms-[37px]" v-model.trim="categoryForm.link_type"/>
                        <label class="ml-2" for="in-site_link">サイト内リンク</label>
                        <RadioButton inputId="direct_input" name="link_type" :value="3" class="ms-[37px]" v-model.trim="categoryForm.link_type"/>
                        <label class="ml-2" for="direct_input">直接入力</label>
                        <InputText class="w-full h-[38px] mt-4" v-model.trim="categoryForm.link_url" v-if="categoryForm.link_type == in_site_ink" name="link_url"/>
                        <div class="mt-4" v-if="categoryForm.link_type == link_page">
                            <Select v-model="categoryForm.link_page_id" :options="props.categories" optionLabel="text" placeholder="-- 選択してください --" class="w-full"  />
                            <input type="hidden" name="link_page_id" :value="categoryForm.link_page_id?.id">
                        </div>
                        <div v-if="categoryForm.link_type != not_displayed" class="mt-4">
                            <RadioButton inputId="link_open_type_win" name="link_open_type" :value="1" v-model.trim="categoryForm.link_open_type"/>
                            <label class="ml-2" for="link_open_type_win">同一ウインドウで開く</label>
                            <RadioButton inputId="link_open_type_other" name="link_open_type" :value="2" class="ms-[37px]" v-model.trim="categoryForm.link_open_type"/>
                            <label class="ml-2" for="link_open_type_other">別ウインドウで開く</label>
                        </div>
                    </div>
                </div>

                <StickRegistButton :back-path="backPath" text-back-btn="一覧に戻る"/>
            </div>
        </form>
    </div>
</template>
<script setup>
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import RadioButton from 'primevue/radiobutton'
import Select from 'primevue/select'
import { reactive, defineProps, ref } from 'vue'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps(['categories' , 'path', 'csrfToken', 'errormessage', 'dataUpdate', 'oldInput', 'backPath'])
const not_displayed = 1
const in_site_ink = 3
const link_page = 2
const show_description_private = 0
const publish_status_private = 0
const link_open_type_win = 1

const categoryForm = reactive({
    name: props.oldInput?.name ?? props.dataUpdate?.name ?? '',
    description_heading: props.oldInput?.description_heading ?? props.dataUpdate?.description_heading ?? '',
    description_top: props.oldInput?.description_top ?? props.dataUpdate?.description_top ?? '',
    description_bottom: props.oldInput?.description_bottom ?? props.dataUpdate?.description_bottom ?? '',
    show_description: show_description_private,
    h1_text: props.oldInput?.h1_text ?? props.dataUpdate?.h1_text ?? '',
    seleted_text: props.oldInput?.seleted_text ?? props.dataUpdate?.seleted_text ?? '',
    link_type: props.dataUpdate?.link_type ?? not_displayed,
    link_page_id: props.categories?.find((value) => {
        return value.id === props.dataUpdate?.link_page_id
    }),
    link_url: props.oldInput?.link_url ?? props.dataUpdate?.link_url ?? '',
    link_open_type: props.dataUpdate?.link_open_type ?? link_open_type_win,
    publish_status: props.dataUpdate?.publish_status ?? publish_status_private,
})

const onSubmit = async e => {
    e.target.submit()
}
</script>
