<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">対応決済の表示関連</h1>

        <form :action="props.path" @submit.prevent="onSubmit" method="post">
            <input type="hidden" name="_token" :value="props.csrfToken" />

            <div class="px-8 py-[28px] w-full border border-[#DFE7EF] mb-8">
                <div class="mt-1">
                    <table class="table-auto w-full border-collapse">
                        <tbody>
                        <tr class="bg-[#EFF3F8]">
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold font-hiragino text-center">
                                表示設定
                            </td>
                            <td class="w-9/12 px-4 pt-9 pb-6 border border-solid border-[#c4cbef]">
                                <RadioButton
                                    v-model="form.show_payment_button"
                                    inputId="show_payment_button"
                                    name="show_payment_button"
                                    :value="1"/>
                                <label class="ml-2 mr-8" for="show_payment_button">表示する</label>
                                <RadioButton
                                    v-model="form.show_payment_button"
                                    inputId="hide_payment_button"
                                    name="show_payment_button"
                                    :value="0"/>
                                <label class="ml-2" for="hide_payment_button">表示しない</label>
                                <p class="text-sm mt-4">ページ上部にボタンが表示されます</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold font-hiragino text-center">
                                表示アイコン
                            </td>
                            <td class="w-9/12 p-[22px] border border-solid border-[#c4cbef]">
                                <div class="flex mb-5">
                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_paypal"
                                            binary
                                            input-id="show_paypay" />
                                        <label for="show_paypay" class="ml-2">PayPay</label>
                                        <input type="hidden" name="show_paypal" :value="form.show_paypal ? 1 : 0">
                                    </div>

                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_aupay"
                                            binary
                                            input-id="show_aupay" />
                                        <label for="show_aupay" class="ml-2">auPAY</label>
                                        <input type="hidden" name="show_aupay" :value="form.show_aupay ? 1 : 0">
                                    </div>

                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_dpay"
                                            binary
                                            input-id="show_dpay" />
                                        <label for="show_dpay" class="ml-2">d払い</label>
                                        <input type="hidden" name="show_dpay" :value="form.show_dpay ? 1 : 0">
                                    </div>

                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_merpay"
                                            binary
                                            input-id="show_merpay" />
                                        <label for="show_merpay" class="ml-2">メルペイ</label>
                                        <input type="hidden" name="show_merpay" :value="form.show_merpay ? 1 : 0">
                                    </div>

                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_rakutenpay"
                                            binary
                                            input-id="show_rakutenpay" />
                                        <label for="show_rakutenpay" class="ml-2">楽天Pay</label>
                                        <input type="hidden" name="show_rakutenpay" :value="form.show_rakutenpay ? 1 : 0">
                                    </div>
                                </div>

                                <div class="flex mb-5">
                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_visa"
                                            binary
                                            input-id="show_visa" />
                                        <label for="show_paypay" class="ml-2">Visa</label>
                                        <input type="hidden" name="show_visa" :value="form.show_visa ? 1 : 0">
                                    </div>

                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_master"
                                            binary
                                            input-id="show_master" />
                                        <label for="show_master" class="ml-2">マスター</label>
                                        <input type="hidden" name="show_master" :value="form.show_master ? 1 : 0">
                                    </div>

                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_jcb"
                                            binary
                                            input-id="show_jcb" />
                                        <label for="show_jcb" class="ml-2">JCB</label>
                                        <input type="hidden" name="show_jcb" :value="form.show_jcb ? 1 : 0">
                                    </div>

                                    <div class="w-2/5">
                                        <Checkbox
                                            v-model="form.show_amex"
                                            binary
                                            input-id="show_amex" />
                                        <label for="show_amex" class="ml-2">アメリカンエキスプレス</label>
                                        <input type="hidden" name="show_amex" :value="form.show_amex ? 1 : 0">
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_diners"
                                            binary
                                            input-id="show_diners" />
                                        <label for="show_diners" class="ml-2">ダイナーズ</label>
                                        <input type="hidden" name="show_diners" :value="form.show_diners ? 1 : 0">
                                    </div>

                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_discover"
                                            binary
                                            input-id="show_discover" />
                                        <label for="show_discover" class="ml-2">ディスカバー</label>
                                        <input type="hidden" name="show_discover" :value="form.show_discover ? 1 : 0">
                                    </div>

                                    <div class="w-1/5">
                                        <Checkbox
                                            v-model="form.show_unionpay"
                                            binary
                                            input-id="show_unionpay" />
                                        <label for="show_unionpay" class="ml-2">銀聯</label>
                                        <input type="hidden" name="show_unionpay" :value="form.show_unionpay ? 1 : 0">
                                    </div>

                                    <div class="w-2/5">
                                        <Checkbox
                                            v-model="form.show_electronicmoney"
                                            binary
                                            input-id="show_electronicmoney" />
                                        <label for="show_electronicmoney" class="ml-2">交通系電子マネー</label>
                                        <input type="hidden" name="show_electronicmoney" :value="form.show_electronicmoney ? 1 : 0">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold font-hiragino text-center">
                                説明文
                            </td>
                            <td class="w-9/12 p-[22px] border border-solid border-[#c4cbef]">
                                <Textarea class="w-full h-[108px]" name="description" :model-value="form.description"/>
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
import Textarea from 'primevue/textarea'
import Checkbox from 'primevue/checkbox'
import RadioButton from 'primevue/radiobutton'
import { defineProps, onMounted, reactive, ref } from 'vue'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps(['item', 'path', 'csrfToken', 'errormessage', 'backPath'])

const form = ref({
    show_payment_button: 1,
    show_paypal: true,
    show_aupay: true,
    show_dpay: true,
    show_merpay: true,
    show_rakutenpay: true,
    show_visa: true,
    show_master: true,
    show_jcb: true,
    show_amex: true,
    show_diners: true,
    show_discover: true,
    show_unionpay: true,
    show_electronicmoney: true,
    description: '',
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
:deep(.ck.ck-editor__top.ck-reset_all) {
    display: none;
}

:deep(.ck.ck-editor__main pre) {
    min-height: 504px;
}
</style>
