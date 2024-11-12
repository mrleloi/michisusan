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

      <ul v-if="placementHeadingParts" class="flex flex-wrap">
        <template v-for="t in headingDesignTypes">
          <li
            :id="`design-type-${t.designType}`"
            class="p-4 w-1/2 cursor-pointer flex items-center justify-center"
            @click="attributes.parts.heading = t"
          >
            <div
              class="w-3/4 bg-[#f1eeeb] relative border-blue-400"
              :class="{
                'border-4': attributes.parts.heading?.designType == t.designType
              }"
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
    </div>

    <div class="p-4 border-b">
      <h1 class="font-bold pb-2">ボタン設定</h1>

      <div class="p-8 flex gap-4 flex-col">
        <div class="flex items-center">
          <Checkbox
            v-model="placementButtonParts"
            inputId="placementButtonParts"
            :binary="true"
            @change="changePlacementButtonParts"
          />
          <label for="placementButtonParts" class="ml-2 cursor-pointer">
            ボタンを配置する
          </label>
        </div>

        <div class="flex flex-col gap-4 pt-4">
          <div class="flex items-center pl-8 gap-4">
            <Checkbox
              v-model="ButtonHover"
              inputId="ButtonHover"
              :binary="true"
              @change="changeButtonHover"
              :disabled="!placementButtonParts"
            />
            <label for="ButtonHover" class="cursor-pointer">
              ホバーアクション
            </label>
            <Select
              v-model="ButtonHoverAnimation"
              :options="ButtonHoverOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="選択"
              class="w-full md:w-56"
              :disabled="!ButtonHover"
              @change="changeButtonHover"
            />
          </div>
          <div class="flex items-center pl-8 gap-4">
            <Checkbox
              v-model="ButtonShadow"
              inputId="ButtonShadow"
              :binary="true"
              @change="changeButtonShadow"
              :disabled="!placementButtonParts"
            />
            <label for="ButtonShadow" class="cursor-pointer">シャドウ</label>
            <ColorPicker
              v-model="ButtonShadowColor"
              :disabled="!placementButtonParts"
              @change="changeButtonShadow"
            />
            <InputText
              v-model="ButtonShadowColor"
              :disabled="!placementButtonParts"
              @change="changeButtonShadow"
            />
          </div>
          <div class="flex items-center pl-8 gap-4">
            <Checkbox
              v-model="ButtonBackground"
              inputId="ButtonBackground"
              :binary="true"
              @change="changeButtonBgColor"
              :disabled="!placementButtonParts"
            />
            <label for="ButtonBackground" class="cursor-pointer">背景色</label>
            <ColorPicker
              v-model="ButtonBackgroundColor"
              :disabled="!placementButtonParts"
              @change="changeButtonBgColor"
            />
            <InputText
              v-model="ButtonBackgroundColor"
              :disabled="!placementButtonParts"
              @change="changeButtonBgColor"
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
import ColorPicker from 'primevue/colorpicker'

import { onMounted, ref } from 'vue'
import { usePartsSettingStore } from '../../../../store/parts-setting'
import { storeToRefs } from 'pinia'
import Checkbox from 'primevue/checkbox'
import Text from './Text.vue'
import Heading from '../Heading/Heading.vue'
import { useHeadingParts } from '../../../../composables/parts-setting/heading'
import { usePartsAttributes } from '../../../../composables/parts-setting/common-attributes'

const { designTypes: headingDesignTypes } = useHeadingParts()

const { designTypes } = usePartsAttributes(18, {
  title: '<h2>テキストテキストテキストテキスト</h2>',
  subtitle: '<h2>テキストテキストテキストテキスト</h2>',
  text: '<h2>テキストテキストテキストテキスト</h2>'
})

const store = usePartsSettingStore()
const { partsType, attributes, tab, editingParts } = storeToRefs(store)
const placementHeadingParts = ref('')
const placementButtonParts = ref(false)
const ButtonHover = ref(false)
const ButtonHoverOptions = ref([
  { label: '色が反転する', value: 'reverse' },
  { label: '字間が広がる', value: 'stretch' },
  { label: 'スライドする', value: 'slide' },
  { label: '迫る', value: 'zoom' },
  { label: '薄くなる', value: 'fade' }
])
const ButtonHoverAnimation = ref('')
const ButtonShadow = ref(false)
const ButtonShadowColor = ref('000000')
const ButtonBackground = ref(false)
const ButtonBackgroundColor = ref('000000')

const changeTitleParts = e => {
  if (placementHeadingParts.value == '') {
    delete attributes.value.parts.heading
  }
}

const changePlacementButtonParts = e => {
  if (placementButtonParts.value) {
    attributes.value.parts.button = {
      designType: 1,
      label: 'テキストテキストテキストテキスト',
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
  } else {
    delete attributes.value.parts.button
  }
}

const changeButtonHover = e => {
  if (ButtonHover.value) {
    attributes.value.parts.button.attributes.buttonHover =
      ButtonHoverAnimation.value
  } else {
    delete attributes.value.parts.button.attributes.buttonHover
  }
}

const changeButtonShadow = e => {
  if (ButtonHover.value) {
    attributes.value.parts.button.attributes.buttonShadow =
      ButtonShadowColor.value
  } else {
    delete attributes.value.parts.button.attributes.buttonShadow
  }
}

const changeButtonBgColor = e => {
  if (ButtonHover.value) {
    attributes.value.parts.button.attributes.buttonBgColor =
      ButtonBackgroundColor.value
  } else {
    delete attributes.value.parts.button.attributes.buttonBgColor
  }
}

onMounted(() => {
  tab.value = ''
  partsType.value = 'Text'
  if (editingParts.value) {
    designTypes.value = designTypes.value.map(v => ({
      ...editingParts.value.attributes,
      designType: v.designType
    }))
  }
  attributes.value = { ...designTypes.value[0] }
})
</script>
