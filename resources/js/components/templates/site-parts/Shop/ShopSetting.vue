<template>
  <template v-if="tab === ''">
    <h1 class="pl-4 font-bold text-xl">企業・店舗</h1>
    <ul class="flex flex-wrap">
      <template v-for="t in designTypes" v-bind:key="t.id">
        <li
          :id="`design-type-${t.designType}`"
          class="p-4 w-1/2 cursor-pointer flex items-center justify-center"
          @click="attributes = t"
        >
          <div
            class="w-3/4 bg-[#f1eeeb] relative border-blue-400 h-40"
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
          </div>
        </li>
      </template>
    </ul>
  </template>

  <template v-if="tab === 'setting'">
    <div class="px-4 pt-0 pb-4 border-b">
      <h1 class="font-bold pb-2">表示するデバイス</h1>

      <div class="p-4 flex gap-4">
        <label for="show_pc_view">
          <Checkbox
            inputId="show_pc_view"
            v-model="attributes.showPCView"
            value=""
            :binary="true"
          />
          PC・タブレット
        </label>

        <label for="show_sp_view">
          <Checkbox
            inputId="show_sp_view"
            v-model="attributes.showSPView"
            value=""
            :binary="true"
          />
          スマートフォン
        </label>
      </div>
    </div>

    <div class="px-4 pt-4 pb-4 border-b">
      <h1 class="font-bold pb-4">見出し設定</h1>
      <div class="px-8">
        <h1 class="font-bold pb-4">見出しの有無</h1>

        <div class="flex gap-4 flex-wrap">
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
    </div>

    <div class="px-4 pt-4 pb-4 border-b">
      <h1 class="font-bold pb-4">その他設定</h1>
      <div class="p-8 pt-4">
        <h1 class="font-bold pb-4">店舗名</h1>
        <div class="flex flex-col gap-2">
          <div v-for="item in items" v-bind:key="item.id">
            <RadioButton
              v-model="attributes.shopItemId"
              :inputId="`item_${item.id}`"
              name="item"
              :value="item.id"
            />
            <label :for="`cat_${item.id}`" class="ml-2">{{ item.name }}</label>
          </div>
        </div>
        <div class="flex flex-wrap gap-x-2 pt-4">
          <Button label="情報の追加・編集"></Button>
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
import { onMounted, ref } from 'vue'
import { useAPI } from '@/composables/api'
import { usePartsSettingStore } from '../../../../store/parts-setting'
import { storeToRefs } from 'pinia'
import Textarea from 'primevue/textarea'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import RadioButton from 'primevue/radiobutton'

const api = useAPI()
const store = usePartsSettingStore()
const { partsType, attributes, tab, editingParts } = storeToRefs(store)

const placementHeadingParts = ref('')
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

const designTypes = ref(
  [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].map(v => ({
    designType: v,
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
    fadein: '',
    anchor: '',
    parts: {},
    shopItemId: null,
  }))
)

const items = ref([])

onMounted(() => {
  tab.value = ''
  partsType.value = 'Shop'
  if (editingParts.value) {
    designTypes.value = designTypes.value.map(v => ({
      ...editingParts.value.attributes,
      designType: v.designType
    }))
  }
  attributes.value = { ...designTypes.value[0] }
  api.shopParts.getItems().then((res => {
    items.value = res.data
    attributes.value.shopItemId = res.data.length > 0 ? res.data[0].id : null
  }))
})
</script>
