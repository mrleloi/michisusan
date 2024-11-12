<template>
  <div class="w-full">
    <div class="px-8">
      <h1>上級設定</h1>
    </div>

    <div class="px-12 py-4">
      <h1>独自CSS</h1>
      <p class="text-red-500 pt-1 pb-4">
        ※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。
      </p>
      <Textarea v-model="customCss" rows="15" class="w-full" />
    </div>

    <div class="px-12 py-4">
      <h1>独自JS</h1>
      <p class="text-red-500 pt-1 pb-4">
        ※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。
      </p>
      <Textarea v-model="customJavascript" rows="15" class="w-full" />
    </div>

    <div class="px-12 py-4">
      <h1>独自＜head＞タグ内容</h1>
      <p class="text-red-500 pt-1 pb-4">
        ※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。
      </p>
      <Textarea v-model="customHeadTag" rows="15" class="w-full" />
    </div>
  </div>
</template>

<script setup>
import Textarea from 'primevue/textarea'
import { usePageSettingStore } from '@/store/page-setting'
import { storeToRefs } from 'pinia'

const store = usePageSettingStore()
const { customCss, customJavascript, customHeadTag } = storeToRefs(store)
</script>
