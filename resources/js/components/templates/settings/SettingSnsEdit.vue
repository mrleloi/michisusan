<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold leading-[33px] mb-3">SNS設定</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[28px] text-[14px] text-sm flex items-center">
          <span class="text-sm">
              <span class="text-[#FF0000]">※</span>は入力必須項目です。
          </span>
        </div>

        <form :action="props.path" @submit.prevent="onSubmit" method="post">
            <input type="hidden" name="_token" :value="props.csrfToken" />

            <div class="px-8 py-[28px] w-full border border-[#DFE7EF] mb-8">
                <h1 class="font-semibold text-[22px]">SNSアカウント</h1>
                <p class="text-sm mt-2">
                    ホームページ上にリンクとして表示されます。<br>
                    SPヘッダー (バーガーメニュー外) は2つまで選択できます。
                </p>

                <div class="mt-4">
                    <table class="table-auto w-full border-collapse form-table-custom">
                        <tbody>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                アイコンデザイン
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <RadioButton
                                    v-model="form.icon_design_type"
                                    inputId="icon_design_type_round"
                                    name="icon_design_type"
                                    :value="SITE_SNS_SETTING.ICON_DESIGN_TYPE_ROUND"/>
                                <label class="ml-2 mr-8" for="icon_design_type_round">丸</label>
                                <RadioButton
                                    v-model="form.icon_design_type"
                                    inputId="icon_design_type_round_corner"
                                    name="icon_design_type"
                                    :value="SITE_SNS_SETTING.ICON_DESIGN_TYPE_ROUND_CORNERS"/>
                                <label class="ml-2" for="icon_design_type_round_corner">角丸</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                LINE URL
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <InputText
                                    name="line_url"
                                    class="w-full"
                                    :model-value="dataItem.line_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.line_url?.length">{{props.errormessage?.line_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="line" :data-item="dataItem" />
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                Instagram URL
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <InputText
                                    name="instagram_url"
                                    class="w-full"
                                    :model-value="dataItem.instagram_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.instagram_url?.length">{{props.errormessage?.instagram_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="instagram" :data-item="dataItem" />
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                TikTok URL
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <InputText
                                    name="tiktok_url"
                                    class="w-full"
                                    :model-value="dataItem.tiktok_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.tiktok_url?.length">{{props.errormessage?.tiktok_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="tiktok" :data-item="dataItem" />
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                Youtube URL
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <InputText
                                    name="youtube_url"
                                    class="w-full"
                                    placeholder="https://youtube.com/@xxxxx/"
                                    :model-value="dataItem.youtube_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.youtube_url?.length">{{props.errormessage?.youtube_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="mt-2.5 mb-7" prefix-name="youtube" :data-item="dataItem" />
                                <p class="mb-3">YouTubeアイコンの使用には利用申請が必要になります</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                Facebook URL
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <InputText
                                    name="facebook_url"
                                    class="w-full"
                                    placeholder="https://facebook.com/xxxxx/"
                                    :model-value="dataItem.facebook_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.facebook_url?.length">{{props.errormessage?.facebook_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="facebook" :data-item="dataItem" />
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                X（Twitter） URL
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <InputText
                                    name="twitter_url"
                                    class="w-full"
                                    placeholder="https://twitter.com/xxxxx/"
                                    :model-value="dataItem.twitter_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.twitter_url?.length">{{props.errormessage?.twitter_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="mt-2.5 mb-7" prefix-name="twitter" :data-item="dataItem" />
                                <p class="mb-3">x.comではXアイコンが、twitter.comでは鳥アイコンが表示されます</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                Threads URL
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <InputText
                                    name="threads_url"
                                    class="w-full"
                                    placeholder="https://threads.net/@xxxxx/"
                                    :model-value="dataItem.threads_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.threads_url?.length">{{props.errormessage?.threads_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="threads" :data-item="dataItem" />
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                ブログ URL
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <InputText
                                    name="ameblo_url"
                                    class="w-full"
                                    placeholder="https://ameblo.jp/xxxxx/"
                                    :model-value="dataItem.ameblo_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.ameblo_url?.length">{{props.errormessage?.ameblo_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="ameblo" :data-item="dataItem" />
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                その他SNS (1)
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="mb-3">
                                    <ImageSelector name="other1_image" :value="dataItem.other1_image" />
                                </div>
                                <InputText
                                    name="other1_url"
                                    class="w-full"
                                    placeholder="URL"
                                    :model-value="dataItem.other1_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.other1_url?.length">{{props.errormessage?.other1_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="other1" :data-item="dataItem" />
                            </td>
                        </tr>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                その他SNS (2)
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="mb-3">
                                    <ImageSelector name="other2_image" :value="dataItem.other2_image" />
                                </div>
                                <InputText
                                    name="other2_url"
                                    class="w-full"
                                    placeholder="URL"
                                    :model-value="dataItem.other2_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.other2_url?.length">{{props.errormessage?.other2_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="other2" :data-item="dataItem" />
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                その他SNS (3)
                            </td>
                            <td class="w-9/12 p-4 border border-solid border-[#c4cbef]">
                                <div class="mb-3">
                                    <ImageSelector name="other3_image" :value="dataItem.other3_image"/>
                                </div>
                                <InputText
                                    name="other3_url"
                                    class="w-full"
                                    placeholder="URL"
                                    :model-value="dataItem.other3_url" />
                                <p class="text-red-500 text-xs mt-1" v-if="props.errormessage?.other3_url?.length">{{props.errormessage?.other3_url?.[0]}}</p>
                                <GroupCheckboxSettingSns class="my-2.5" prefix-name="other3" :data-item="dataItem" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <StickRegistButton :back-path="backPath" text-back-btn="ダッシュボードに戻る"/>
            </div>
        </form>
    </div>
</template>

<script setup>
import InputText from 'primevue/inputtext'
import RadioButton from 'primevue/radiobutton'
import { defineProps, reactive, ref } from 'vue'
import GroupCheckboxSettingSns from '@/components/templates/settings/components/GroupCheckboxSettingSns.vue'
import { SITE_SNS_SETTING } from '@/composables/consts.js'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps(['item', 'path', 'csrfToken', 'errormessage', 'oldInput', 'backPath'])

const dataItem = reactive(props.item)
const form = ref({
    icon_design_type: props.oldInput?.icon_design_type ?? (props.item?.icon_design_type || SITE_SNS_SETTING.ICON_DESIGN_TYPE_ROUND),
})

const onSubmit = async (e) => {
    e.target.submit()
}
</script>

<style scoped>
:deep(.ck.ck-editor__top.ck-reset_all) {
    display: none;
}

:deep(.ck.ck-editor__main pre) {
    min-height: 504px;
}
</style>
