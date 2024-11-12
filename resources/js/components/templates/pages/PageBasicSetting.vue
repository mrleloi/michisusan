<template>
  <div class="w-full px-8">
    <h1 class="pb-4">タイトル・ディスクリプション・h1テキスト</h1>

    <table class="table-auto w-full border-collapse">
      <tbody>
        <tr class="bg-[#EFF3F8]">
          <td
            class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
          >
            タイトル
          </td>
          <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
            <div class="pt-4 pb-2 px-4">
              <div class="flex flex-col gap-4">
                <InputText v-model="title" class="w-full" />
                <CheckBox
                  v-model="withSeoTitle"
                  class="flex gap-1"
                  inputId="with_seo_title"
                  binary
                >
                  SEO付与タイトルを使用する
                </CheckBox>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td
            class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
          >
            ディスクリプション
          </td>
          <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
            <div class="pt-4 pb-2 px-4">
              <InputText v-model="description" class="w-full" />
            </div>
          </td>
        </tr>
        <tr class="bg-[#EFF3F8]">
          <td
            class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
          >
            h1テキスト
          </td>
          <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
            <div class="pt-4 pb-2 px-4">
              <InputText v-model="h1Text" class="w-full" />
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="w-full px-8">
    <h1 class="py-4">基本設定</h1>
    <table class="table-auto w-full border-collapse">
      <tbody>
        <tr class="bg-[#EFF3F8]">
          <td
            class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
          >
            キーワード（タグ）
          </td>
          <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
            <div class="pt-4 pb-2 px-4">
              <InputText v-model="tags" class="w-full" />
            </div>
          </td>
        </tr>
        <tr>
          <td
            class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
          >
            ナビ表示名
          </td>
          <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
            <div class="pt-4 pb-2 px-4">
              <InputText v-model="navigationName" class="w-full" />
            </div>
          </td>
        </tr>
        <tr class="bg-[#EFF3F8]">
          <td
            class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
          >
            ディレクトリ名<span class="text-red-500">※</span>
          </td>
          <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
            <div class="pt-4 pb-2 px-4">
              <InputText v-model="directory" class="w-full" />
              <div class="flex-1 flex items-center gap-4 pt-4">
                簡易翻訳：
                <InputText v-model="translateWord" rounded />
                <Button
                  label="翻訳"
                  @click="translate(translateWord)"
                  class="w-[90px]"
                  size="small"
                  rounded
                />
                <Button
                  label="ディレクトリ名に反映"
                  @click="directory = translateWord"
                  class="w-[173px]"
                  size="small"
                  rounded
                />
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td
            class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
          >
            keywords
          </td>
          <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
            <div class="pt-4 pb-2 px-4">
              <InputText v-model="keywords" class="w-full" />
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import CheckBox from '@/components/parts/common/Checkbox.vue'
import { usePageSettingStore } from '@/store/page-setting'
import { storeToRefs } from 'pinia'
import { useAPI } from '@/composables/api'
import { ref } from 'vue'

const translateWord = ref('')
const store = usePageSettingStore()
const {
  title,
  withSeoTitle,
  description,
  h1Text,
  tags,
  navigationName,
  directory,
  keywords
} = storeToRefs(store)

const api = useAPI()

const translate = async word => {
  //   const {} = await api.translate.translate(word)
  translateWord.value = 'hoge'
}
</script>
