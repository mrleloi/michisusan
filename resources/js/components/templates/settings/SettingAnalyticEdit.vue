<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold leading-[33px] mb-3">アクセス解析認証タグ</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[30px] text-[14px] text-sm flex items-center mb-6">
            <span class="text-[#FF0000] text-[12px] font-semibold">
                ※
            </span>
            <span>
               は入力必須項目です。
            </span>
        </div>
        <form :action="props.path" @submit.prevent="onSubmit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" :value="props.csrfToken" />

            <div class="px-8 py-[28px] w-full border border-[#DFE7EF] mb-8">
                <div class="mt-1">
                    <table class="table-auto w-full border-collapse form-table-custom">
                        <tbody>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                メールアドレス
                            </td>
                            <td class="w-9/12 px-4 pt-9 pb-6 border border-solid border-[#c4cbef]">
                                <InputText v-model.trim="form.email_address" class="w-full" name="email_address"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                プロパティID（GA4版）
                            </td>
                            <td class="w-9/12 p-[22px] border border-solid border-[#c4cbef]">
                                <InputText v-model.trim="form.ga4_property_id" class="w-full" name="ga4_property_id"/>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                JSONファイル
                            </td>
                            <td class="w-9/12 px-4 pt-9 pb-6 border border-solid border-[#c4cbef]">
                                <p class="mb-6">JSONファイルアップロード済み ( asteer10-1f4c0bd4b5df.json )</p>

                                <FileSelector name="ga4_json_file" accept="application/JSON"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                トラッキングコード（GA4版）
                            </td>
                            <td class="w-9/12 p-[22px] border border-solid border-[#c4cbef]">
                                <Textarea class="w-full h-[108px]" v-model.trim="form.ga4_tracking_code" name="ga4_tracking_code"/>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                SearchConsole認証meta
                            </td>
                            <td class="w-9/12 px-4 pt-9 pb-6 border border-solid border-[#c4cbef]">
                                <InputText v-model.trim="form.search_console_meta" class="w-full" name="search_console_meta"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                SearchConsole認証用 JSONファイル (client_secret 含む)
                            </td>
                            <td class="w-9/12 p-[22px] border border-solid border-[#c4cbef]">
                                <p class="mb-6">JSONファイル未アップロード</p>

                                <FileSelector name="search_console_json_file" accept="application/JSON"/>
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                Microsoft Clarity認証タグ
                            </td>
                            <td class="w-9/12 px-4 pt-9 pb-6 border border-solid border-[#c4cbef]">
                                <Textarea class="w-full h-[108px]" v-model.trim="form.microsoft_clarity_tag" name="microsoft_clarity_tag"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                juicerタグ
                            </td>
                            <td class="w-9/12 p-[22px] border border-solid border-[#c4cbef]">
                                <InputText v-model.trim="form.juicer_tag" class="w-full" name="juicer_tag"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-center gap-[32px] mt-8">
                    <Button v-slot="slotProps" asChild>
                        <button
                            v-bind="slotProps.a11yAttrs"
                            class="text-white bg-[#FF3D32] w-[174px] h-[40px] text-sm font-bold rounded-full"
                            type="button"
                            @click="goBackDashBoard"
                        >
                            プレビュー
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
import Textarea from 'primevue/textarea'
import { defineProps, onMounted, reactive, ref } from 'vue'
import InputText from 'primevue/inputtext'
import FileSelector from '@/components/parts/common/FileSelector.vue'

const props = defineProps(['site', 'path', 'csrfToken', 'errormessage', 'oldInput'])

const form = ref({
    email_address: props.oldInput?.email_address || props.site?.email_address || '',
    ga4_property_id: props.oldInput?.ga4_property_id || props.site?.ga4_property_id || '',
    ga4_json_file: props.oldInput?.ga4_json_file || props.site?.ga4_json_file || '',
    ga4_tracking_code: props.oldInput?.ga4_tracking_code || props.site?.ga4_tracking_code || '',
    search_console_meta: props.oldInput?.search_console_meta || props.site?.search_console_meta || '',
    search_console_json_file: props.oldInput?.search_console_json_file || props.site?.search_console_json_file || '',
    microsoft_clarity_tag: props.oldInput?.microsoft_clarity_tag || props.site?.microsoft_clarity_tag || '',
    juicer_tag: props.oldInput?.juicer_tag || props.site?.juicer_tag || '',
})

const goBackDashBoard = () => {
    window.location.href = '/admin'
}

const onSubmit = async (e) => {
    e.target.submit()
}

const convertToBoolean = () => {
    if (props.item?.length === 0) {
        return
    }

    form.value = Object.fromEntries(
        Object.entries(props.item).map(([key, value]) =>
            key === 'description' || key === 'show_payment_button' ? [key, value] : [key, Boolean(value)]
        )
    )
}

onMounted(() => {
    if (props.item) {
        convertToBoolean()
    }
})
</script>

<style scoped>
</style>
