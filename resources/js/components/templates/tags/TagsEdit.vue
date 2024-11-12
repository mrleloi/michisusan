<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold leading-[33px] mb-3">編集画面</h1>
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
            <div class="border border-[#DFE7EF] px-[25px] py-[21px] rounded-b font-[Inter]">
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">タグ名</span><span class="text-[#FF0000]">※</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] pt-[24px] pb-[16px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model.trim="formData.name" name="name" maxLength="255"/>
                        <p class="text-red-500 text-[12px]" v-if="props.errormessage?.name?.length">{{props.errormessage?.name?.[0]}}</p>
                        <p class="pt-4">※文章ではなく単語でご入力ください</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px]">
                        <span class="text-base">説明文</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="mb-[26px]">
                            <label class="text-sm font-medium">上部詳細</label>
                            <Textarea class="w-full h-[108px] mt-4" v-model.trim="formData.description_top" name="description_top"/>
                            <span class="text-red-500 text-[12px]" v-if="props.errormessage?.description_top?.length">{{props.errormessage?.description_top?.[0]}}</span>
                        </div>
                        <div>
                            <label class="text-sm font-medium">下部詳細</label>
                            <Textarea class="w-full h-[108px] mt-4" v-model.trim="formData.description_bottom" name="description_bottom"/>
                            <span class="text-red-500 text-[12px]" v-if="props.errormessage?.description_bottom?.length">{{props.errormessage?.description_bottom?.[0]}}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">説明文の表示</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <RadioButton inputId="show_description_public" name="show_description" :value="1" v-model="formData.show_description"/>
                        <label class="ml-2" for="show_description_public">表示する</label>
                        <RadioButton inputId="show_description_private" name="show_description" :value="0" class="ms-[37px]" v-model="formData.show_description"/>
                        <label class="ml-2" for="show_description_private">表示しない</label>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">h1テキスト</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <InputText class="w-full h-[38px]" v-model.trim="formData.h1_text" name="h1_text" maxLength="80"/>
                        <span class="text-red-500 text-[12px]" v-if="props.errormessage?.h1_text?.length">{{props.errormessage?.h1_text?.[0]}}</span>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b">
                    <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">公開設定</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[36px] w-full border-l">
                        <RadioButton inputId="publish_status_public" name="publish_status" :value="1" v-model.trim="formData.publish_status"/>
                        <label class="ml-2" for="publish_status_public">公開</label>
                        <RadioButton inputId="publish_status_private" name="publish_status" :value="0" class="ms-[79px]" v-model.trim="formData.publish_status"/>
                        <label class="ml-2" for="publish_status_private">非公開</label>
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
import { reactive, defineProps } from 'vue'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps(['tags' , 'path', 'csrfToken', 'errormessage', 'dataUpdate', 'oldInput', 'backPath'])

const formData = reactive({
    name: props.oldInput.name === null ? '' : props.dataUpdate?.name,
    description_top: props.oldInput.description_top ?? props.dataUpdate?.description_top ?? '',
    description_bottom: props.oldInput.description_bottom ?? props.dataUpdate?.description_bottom ?? '',
    show_description: props.dataUpdate.show_description,
    h1_text: props.oldInput.h1_text ?? props.dataUpdate?.h1_text ?? '',
    publish_status: props.dataUpdate.publish_status,
})

const onSubmit = async e => {
    e.target.submit()
}
</script>
