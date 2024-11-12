<template>
  <template v-if="tab === ''">
    <h1 class="pl-4 font-bold text-xl">見出しデザイン</h1>

    <ul class="flex flex-wrap">
      <template v-for="t in designTypes">
        <li
          :id="`design-type-${t.designType}`"
          class="p-4 w-1/2 cursor-pointer flex items-center justify-center"
          @click="attributes = t"
        >
          <div
            class="w-3/4 bg-[#f1eeeb] relative border-blue-400"
            :class="{ 'border-4': attributes.designType === t.designType }"
          >
            <div
              class="absolute top-2 left-2 bg-[#2d3a4c] text-white p-3 rounded-full"
            >
              <p
                class="absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%]"
              >
                {{ t.designType }}
              </p>
            </div>
            <Heading :attributes="t" />
          </div>
        </li>
      </template>
    </ul>
  </template>

  <template v-if="tab === 'setting'">
    <div class="px-4 pt-0 pb-4 border-b">
      <h1 class="font-bold pb-2">表示するデバイス</h1>

      <div class="p-8 flex gap-4">
        <label for="show_pc_view">
          <Checkbox
            inputId="show_pc_view"
            v-model="attributes.showPCView"
            value=""
          />
          PC・タブレット
        </label>

        <label for="show_sp_view">
          <Checkbox
            inputId="show_sp_view"
            v-model="attributes.showSPView"
            value=""
          />
          スマートフォン
        </label>
      </div>
    </div>

    <div class="p-4 border-b">
      <h1 class="font-bold pb-2">class、id設定</h1>

      <div class="px-8 pb-4">
        <div class="py-4">
          <h1 class="font-bold pb-2">class</h1>
          <InputText v-model="attributes.className" class="w-full" />
        </div>
        <div class="py-4">
          <h1 class="font-bold pb-2">id</h1>
          <InputText v-model="attributes.id" class="w-full" />
        </div>
      </div>
    </div>

    <div class="px-4 pt-4">
      <h1 class="font-bold">css</h1>
      <div class="p-8">
        <Textarea v-model="attributes.style" rows="15" class="w-full" />
      </div>
    </div>
  </template>
</template>

<script setup>
import Textarea from 'primevue/textarea'
import InputText from 'primevue/inputtext'
import { onMounted } from 'vue'
import { usePartsSettingStore } from '@/store/parts-setting'
import { storeToRefs } from 'pinia'
import Checkbox from 'primevue/checkbox'
import Heading from './Heading.vue'
import { usePartsAttributes } from '../../../../composables/parts-setting/common-attributes'

const { designTypes } = usePartsAttributes(27, {
  title: 'タイトルテキスト',
  titleStyle: '',
  subtitle: 'サブタイトルテキスト',
  subtitleStyle: ''
})

const store = usePartsSettingStore()
const { partsType, attributes, tab } = storeToRefs(store)

onMounted(() => {
  tab.value = ''
  partsType.value = 'Heading'
  attributes.value = designTypes.value[0]
})
</script>
