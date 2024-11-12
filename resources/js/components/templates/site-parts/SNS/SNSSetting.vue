<template>
  <template v-if="tab === ''">
    <h1 class="pl-4 font-bold text-xl">テキストデザイン</h1>

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
            <Text :attributes="t" />
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
      <h1 class="font-bold pb-2">見出し設定</h1>

      <div class="p-8 flex gap-4">
        <div class="flex items-center">
          <RadioButton
            v-model="placementHeadingParts"
            inputId="placementHeadingPartsNone"
            name="placementHeadingPartsNone"
            value=""
            @change="changeTitleParts"
          />
          <label for="placementHeadingPartsNone" class="ml-2 cursor-pointer">
            表示しない
          </label>
        </div>
        <div class="flex items-center">
          <RadioButton
            v-model="placementHeadingParts"
            inputId="placementHeadingPartsBoth"
            name="placementHeadingPartsBoth"
            value="both"
            @change="changeTitleParts"
          />
          <label for="placementHeadingPartsBoth" class="ml-2 cursor-pointer">
            タイトル・サブタイトルを表示
          </label>
        </div>
        <div class="flex items-center">
          <RadioButton
            v-model="placementHeadingParts"
            inputId="placementHeadingPartsTitle"
            name="placementHeadingPartsTitle"
            value="title"
            @change="changeTitleParts"
          />
          <label for="placementHeadingPartsTitle" class="ml-2 cursor-pointer">
            タイトルのみを表示
          </label>
        </div>
      </div>
    </div>

    <div class="p-4 border-b">
      <div class="">
        <h1 class="font-bold pb-2">SNSの種類</h1>

        <div class="p-8 flex gap-4 flex-col">
          <div class="flex items-center">
            <Select
              v-model="sns1"
              :options="sns1Options"
              optionLabel="label"
              optionValue="value"
              placeholder="選択"
              class="w-full md:w-56"
              @change="changeSns1"
            />
          </div>
        </div>
      </div>

      <div class="">
        <h1 class="font-bold pb-2">URL</h1>

        <div class="p-8 flex gap-4 flex-col">
          <div class="flex items-center">
            <InputText v-model="sns1Url" class="w-full" @change="changeSns1" />
          </div>
        </div>
      </div>

      <div v-if="sns1 === 'facebook'" class="">
        <h1 class="font-bold pb-2">App ID</h1>

        <div class="p-8 flex gap-4 flex-col">
          <div class="flex items-center">
            <InputText
              v-model="sns1AppId"
              class="w-full"
              @change="changeSns1"
            />
          </div>
        </div>
      </div>
    </div>

    <div v-if="visibleSns1" class="p-4 border-b">
      <div class="">
        <h1 class="font-bold pb-2">SNSの種類</h1>

        <div class="p-8 flex gap-4 flex-col">
          <div class="flex items-center">
            <Select
              v-model="sns2"
              :options="sns2Options"
              optionLabel="label"
              optionValue="value"
              placeholder="選択"
              class="w-full md:w-56"
              @change="changeSns2"
            />
          </div>
        </div>
      </div>

      <div class="">
        <h1 class="font-bold pb-2">URL</h1>

        <div class="p-8 flex gap-4 flex-col">
          <div class="flex items-center">
            <InputText v-model="sns2Url" class="w-full" @change="changeSns2" />
          </div>
        </div>
      </div>

      <div v-if="sns2 === 'facebook'" class="">
        <h1 class="font-bold pb-2">App ID</h1>

        <div class="p-8 flex gap-4 flex-col">
          <div class="flex items-center">
            <InputText
              v-model="sns2AppId"
              class="w-full"
              @change="changeSns2"
            />
          </div>
        </div>
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
import RadioButton from 'primevue/radiobutton'
import Select from 'primevue/select'

import { computed, onMounted, ref } from 'vue'
import { usePartsSettingStore } from '../../../../store/parts-setting'
import { storeToRefs } from 'pinia'
import Checkbox from 'primevue/checkbox'
import Text from '../Text/Text.vue'
import { usePartsAttributes } from '../../../../composables/parts-setting/common-attributes'

const { designTypes } = usePartsAttributes(5, {
  sns1: '',
  sns1Url: '',
  sns1AppId: '',
  sns2: '',
  sns2Url: '',
  sns2AppId: ''
})

const store = usePartsSettingStore()
const { partsType, attributes, tab, editingParts } = storeToRefs(store)

const placementHeadingParts = ref('')
const sns1 = ref('')
const sns2 = ref('')
const sns1Url = ref('')
const sns1AppId = ref('')
const sns2Url = ref('')
const sns2AppId = ref('')
const snsOptions = ref([
  { label: '', value: '' },
  { label: 'X', value: 'x' },
  { label: 'Facebook', value: 'facebook' }
])
const sns1Options = computed(() => [
  ...snsOptions.value,
  { label: 'Instagram', value: 'instagram' },
  { label: 'Tiktok', value: 'tiktok' }
])
const sns2Options = computed(() =>
  snsOptions.value.filter(v => v.value != sns1.value)
)
const visibleSns1 = computed(() => {
  return sns1.value && sns2Options.value
})

const changeSns1 = e => {
  if (editingParts.value) {
    editingParts.value.attributes.sns1 = sns1.value ? sns1.value : ''
    editingParts.value.attributes.sns1Url = sns1.value ? sns1Url.value : ''
    editingParts.value.attributes.sns1AppId = sns1.value ? sns1AppId.value : ''
  } else {
    attributes.value.sns1 = sns1.value ? sns1.value : ''
    attributes.value.sns1Url = sns1.value ? sns1Url.value : ''
    attributes.value.sns1AppId = sns1.value ? sns1AppId.value : ''
  }
}
const changeSns2 = e => {
  if (editingParts.value) {
    editingParts.value.attributes.sns2 = sns2.value ? sns2.value : ''
    editingParts.value.attributes.sns2Url = sns2.value ? sns2Url.value : ''
    editingParts.value.attributes.sns2AppId = sns2.value ? sns2AppId.value : ''
  } else {
    attributes.value.sns2 = sns2.value ? sns2.value : ''
    attributes.value.sns2Url = sns2.value ? sns2Url.value : ''
    attributes.value.sns2AppId = sns2.value ? sns2AppId.value : ''
  }
}

const changeTitleParts = e => {
  if (placementHeadingParts.value !== '') {
    attributes.value.parts.heading = {
      partsType: 'Heading',
      attributes: {
        designType: 1,
        title: 'タイトルテキスト',
        titleStyle: '',
        subtitle:
          placementHeadingParts.value === 'both' ? 'サブタイトルテキスト' : '',
        subtitleStyle: '',
        id: '',
        className: '',
        style: '',
        showPCView: false,
        showSPView: false,
        position: 'center',
        containerWidth: '1200px',
        containerFullSize: true,
        paddingTop: '30px',
        paddingBottom: '30px',
        textColor: '',
        backgroundColor: '',
        backGroundImage: '',
        fadein: '',
        anchor: ''
      }
    }
  } else {
    delete attributes.value.parts.heading
  }
}

onMounted(() => {
  tab.value = 'setting'
  partsType.value = 'SNS'
  console.log('SNS', attributes.value)

  if (editingParts.value) {
    designTypes.value.map(v => {
      v.sns1 = editingParts.value.attributes.sns1
      v.sns1Url = editingParts.value.attributes.sns1Url
      v.sns1AppId = editingParts.value.attributes.sns1AppId
      v.sns2 = editingParts.value.attributes.sns2
      v.sns2Url = editingParts.value.attributes.sns2Url
      v.sns2AppId = editingParts.value.attributes.sns2AppId
    })
    sns1.value = editingParts.value.attributes.sns1
    sns1Url.value = editingParts.value.attributes.sns1Url
    sns1AppId.value = editingParts.value.attributes.sns1AppId
    sns2.value = editingParts.value.attributes.sns2
    sns2Url.value = editingParts.value.attributes.sns2Url
    sns2AppId.value = editingParts.value.attributes.sns2AppId
  }

  attributes.value = { ...designTypes.value[0] }
})
</script>
