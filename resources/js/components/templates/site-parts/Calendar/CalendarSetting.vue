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
      <h1 class="font-bold pb-2">定休日</h1>

      <div class="p-8 flex gap-8 flex-row">
        <div v-for="w in WeeksOptions">
          <div class="flex items-center">
            <Checkbox
              v-model="attributes.holiday"
              :inputId="`holiday-${w.value}`"
              :value="w.value"
            />
            <label :for="`holiday-${w.value}`" class="ml-2 cursor-pointer">
              {{ w.label }}
            </label>
          </div>
        </div>
      </div>

      <h1 class="font-bold pb-2">臨時休業日</h1>

      <div class="p-8 flex gap-4 flex-col">
        <template v-for="(_, i) in attributes.temporaryHolidays">
          <div class="flex items-center gap-4">
            <InputText v-model="attributes.temporaryHolidays[i]" />
            <i
              v-if="i >= attributes.temporaryHolidays.length - 1"
              class="pi pi-plus"
              @click="addTemporaryHoliday"
            />
            <i v-else class="pi pi-minus" @click="removeTemporaryHoliday(i)" />
          </div>
        </template>
      </div>
    </div>

    <div class="p-4 border-b">
      <h1 class="font-bold pb-2">表示期間</h1>

      <div class="p-8 flex gap-4 flex-col">
        <div class="flex items-center">
          <Select
            v-model="attributes.displayMonths"
            :options="monthsOptions"
            optionLabel="label"
            optionValue="value"
          />
        </div>
      </div>
    </div>

    <div class="p-4 border-b">
      <h1 class="font-bold pb-2">休業日の名称</h1>

      <div class="p-8 flex gap-4 flex-col">
        <div class="flex items-center flex-col gap-4">
          <div class="w-full">
            <InputText v-model="attributes.holidayName" class="w-1/2" />
          </div>
          <div class="w-full flex gap-8 items-center">
            <div class="">
              <label for="show_sp_view">
                <Checkbox
                  v-model="enabledHolidayColor"
                  inputId="color"
                  @change="changeBusinessHoliday"
                  value="w.value"
                />
                <label for="color" class="ml-2 cursor-pointer">
                  カラー選択
                </label>
              </label>
            </div>
            <div class="">
              <ColorPicker v-model="holidayColor" />
            </div>
            <div class="">
              <InputText v-model="holidayColor" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="p-4 border-b">
      <h1 class="font-bold pb-2">週の表示</h1>

      <div class="p-8 flex gap-4 flex-row">
        <div class="flex items-center">
          <RadioButton
            v-model="attributes.startWeek"
            inputId="startWeekSun"
            name="startWeekSun"
            value="sun"
          />
          <label for="startWeekSun" class="ml-2 cursor-pointer">
            日曜から
          </label>
        </div>
        <div class="flex items-center">
          <RadioButton
            v-model="attributes.startWeek"
            inputId="startWeekMon"
            name="startWeekMon"
            value="mon"
          />
          <label for="startWeekMon" class="ml-2 cursor-pointer">
            月曜から
          </label>
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
import Text from '../Text/Text.vue'
import { usePartsAttributes } from '../../../../composables/parts-setting/common-attributes'

const store = usePartsSettingStore()
const { partsType, attributes, tab, editingParts } = storeToRefs(store)
const placementHeadingParts = ref()

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

const WeeksOptions = ref([
  { label: '日', value: 'sun' },
  { label: '月', value: 'mon' },
  { label: '火', value: 'tue' },
  { label: '水', value: 'wed' },
  { label: '木', value: 'thu' },
  { label: '金', value: 'fri' },
  { label: '土', value: 'sat' }
])

const temporaryHolidays = ref([''])
const addTemporaryHoliday = () => {
  attributes.value.temporaryHolidays.push('')
}
const removeTemporaryHoliday = index => {
  attributes.value.temporaryHolidays = temporaryHolidays.value.filter(
    (_, i) => i !== index
  )
}

const monthsOptions = ref([
  { label: '1ヶ月', value: '1mo' },
  { label: '2ヶ月', value: '2mo' }
])

const enabledHolidayColor = ref(false)
const holidayColor = ref('ff0000')

const changeBusinessHoliday = () => {
  if (enabledHolidayColor.value) {
    attributes.value.holidayColor = holidayColor.value
  } else {
    delete attributes.value.holidayColor
  }
}

const { designTypes } = usePartsAttributes(5, {
  holiday: [],
  displayMonths: monthsOptions.value[0].value,
  holidayName: '休業日',
  startWeek: 'sun',
  temporaryHolidays: ['']
})

onMounted(() => {
  tab.value = ''
  partsType.value = 'Calendar'
  if (editingParts.value) {
    designTypes.value = designTypes.value.map(v => ({
      ...editingParts.value.attributes,
      designType: v.designType
    }))
  }
  attributes.value = { ...designTypes.value[0] }
})
</script>
