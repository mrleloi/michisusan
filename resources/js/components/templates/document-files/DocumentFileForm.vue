<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold leading-[33px] mb-3">新規追加</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[30px] text-[14px] text-sm flex items-center">
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
                                <span>ファイル名<span class="text-[#FF0000]">※</span></span>
                            </td>
                            <td class="w-9/12 px-4 pt-9 pb-6 border border-solid border-[#c4cbef]">
                                <InputText
                                    class="w-full"
                                    name="filename"
                                    :model-value="form.filename"/>
                                <p class="mt-4">一覧表示時に判別しやすい名前を付けてください </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center">
                                文書ファイル
                            </td>
                            <td class="w-9/12 p-[22px] border border-solid border-[#c4cbef]">
                                <div>
                                    <FileSelector name="file" accept=".pdf, .doc, .docx, .xls, .xlsx"/>
                                    <p class="mt-[30px] font-medium">
                                        対応ファイル形式はPDF・Word・Excelです<br>
                                        ファイルの容量は10MBまでです
                                    </p>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <StickRegistButton :back-path="backPath"/>
            </div>
        </form>
    </div>
</template>

<script setup>
import InputText from 'primevue/inputtext'
import FileSelector from '@/components/parts/common/FileSelector.vue'
import { defineProps, reactive } from 'vue'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps(['item', 'path', 'csrfToken', 'errorMessages', 'backPath', 'oldInput'])

const form = reactive({
    filename: props.oldInput?.filename || props.item?.filename || '',
})

const onSubmit = async (e) => {
    e.target.submit()
}
</script>

<style scoped>
</style>
