<template>
  <div class="w-full">
    <h1 class="font-bold px-5 mb-6">公開設定</h1>
    <div class="w-full px-14 flex gap-x-14">
      <div class="flex items-center">
        <RadioButton
          class="flex gap-2"
          inputId="publish_status_public"
          v-model="publishStatus"
          name="publish_status"
          :value="true"
        >
          公開
        </RadioButton>
      </div>
      <div class="flex items-center">
        <RadioButton
          class="flex gap-2"
          inputId="publish_status_private"
          v-model="publishStatus"
          name="publish_status"
          :value="false"
        >
          非公開
        </RadioButton>
      </div>
    </div>
    <div class="border-t w-full my-6"></div>
    <h1 class="font-bold px-5 mb-6">テンプレート</h1>
    <div class="w-full px-14">
      <CheckBox
        v-model="isTemplate"
        binary
        class="flex gap-1"
        inputId="is_template"
        name="is_template"
        >新規テンプレートとして登録</CheckBox
      >
    </div>
  </div>
</template>

<script setup>
import CheckBox from '@/components/parts/common/Checkbox.vue'
import RadioButton from '@/components/parts/common/RadioButton.vue'
import { usePageSettingStore } from '../../../store/page-setting'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'

const store = usePageSettingStore()
const { publishStatus } = storeToRefs(store)
const isTemplate = ref(false)
</script>
