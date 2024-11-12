<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">編集</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[30px] text-[14px] text-sm flex items-center mb-6">
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
                <p class="text-[#FF0000] text-[14px] mt-4 mb-6">『ページA→ページB→ページC』の様な2段階以上のリダイレクト設定は行えません<br>
                    上記の様な設定の場合、TOPページに強制リダイレクトされます</p>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">リダイレクト元</span><span class="text-[#FF0000]">※</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center">
                            <span class="flex-2 border border-[#D1D5DB] rounded bg-[#F3F4F6] px-4 py-3">{{ fullURL }}</span>
                            <InputText class="flex-1" v-model.trim="formData.slug_source" name="slug_source" maxLength="100" placeholder="半角英数字で入力してください"/>
                            <span class="flex-none border rounded border-[#D1D5DB] bg-[#F3F4F6] px-6 py-3">/</span>
                        </div>
                        <p class="text-red-500 text-[12px] mt-2" v-if="props.errormessage?.slug_source?.length">{{props.errormessage?.slug_source?.[0]}}</p>
                        <p class="text-[14px] text-black-500 mt-4">TOPページはリダイレクト元には出来ません</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">リダイレクト先</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <div class="flex items-center">
                            <span class="flex-2 border border-[#D1D5DB] rounded bg-[#F3F4F6] px-4 py-3">{{ fullURL }}</span>
                            <InputText class="flex-1" v-model.trim="formData.slug_target" name="slug_target" maxLength="100" placeholder="半角英数字で入力してください"/>
                            <span class="flex-none border rounded border-[#D1D5DB] bg-[#F3F4F6] px-6 py-3">/</span>
                        </div>
                        <p class="text-red-500 text-[12px] mt-2" v-if="props.errormessage?.slug_target?.length">{{props.errormessage?.slug_target?.[0]}}</p>
                        <p class="text-[14px] text-black-500 mt-4">TOPページはリダイレクト元には出来ません</p>
                    </div>
                </div>
                <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8]">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">ステータスコード</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <Select
                            v-model="statusOption"
                            :options="status"
                            optionLabel="label"
                            label="選択してください"
                            class="w-full"
                        />
                        <input type="hidden" name="status_code" :value="statusOption.key" />
                        <p class="text-red-500 text-[12px] mt-2" v-if="props.errormessage?.status_code?.length">{{props.errormessage?.status_code?.[0]}}</p>
                    </div>
                </div>
                <div v-if="statusOption.key == status302" class="flex items-center border border-[#bdbdbd] border-b-0">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">開始日時</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <DatePicker name="redirect_start" id="datepicker-24h" v-model="formData.redirect_start" dateFormat="yy-mm-dd" hourFormat="24"
                                    showTime class="w-[30%]" />
                    </div>
                </div>
                <div v-if="statusOption.key == status302" class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b">
                    <div class="font-semibold font-hiragino flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                        <span class="text-base">終了日時</span>
                    </div>
                    <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                        <DatePicker name="redirect_end" id="datepicker-24h" v-model="formData.redirect_end" dateFormat="yy-mm-dd" hourFormat="24"
                                    showTime class="w-[30%]" />
                    </div>
                </div>
                <div class="flex items-center justify-center gap-[32px] mt-24 mb-6">
                    <Button v-slot="slotProps" asChild>
                        <button
                            v-bind="slotProps.a11yAttrs"
                            class="text-white bg-[#FF3D32] w-[174px] h-[40px] text-sm font-bold rounded-full"
                            type="button"
                            @click="goBackToList"
                        >
                            一覧に戻る
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
import InputText from 'primevue/inputtext'
import DatePicker from 'primevue/datepicker'
import Button from 'primevue/button'
import Select from 'primevue/select'
import {reactive, defineProps, ref} from 'vue'

const status301 = 1
const status302 = 2

const props = defineProps(['redirect', 'status', 'csrfToken', 'errormessage', 'oldInput', 'selectedStatus'])

const redirect = reactive(props.redirect)

const status = ref([...props.status])
const selectedStatus = ref(status.value.find((value) => {
    return value.key == redirect?.status_code
}))
const statusOption = ref(selectedStatus.value ? selectedStatus.value : '')

const fullURL = `${window.location.protocol}//${window.location.hostname}/`

const formData = reactive({
    ...props.redirect,
    status_code: statusOption,
})

const goBackToList = () => {
    window.location.href = '/admin/redirects'
}

const onSubmit = async e => {
    e.target.submit()
}
</script>
