<template>
  <template v-if="tab === ''">
    <h1 class="pl-4 font-bold text-xl">よくある質問</h1>
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
      <div class="p-8 pt-4 border-b">
        <h1 class="font-bold pb-4">カテゴリー</h1>
        <div class="">
          <div class="flex flex-col gap-2">
            <div class="flex flex-row flex-no-wrap items-center">
              <Checkbox
                v-model="attributes.allCategories"
                inputId="cat_all"
                :binary="true"
                @change="toggleAllCategory"
              />
              <label :for="0" class="ml-2">
                全てのカテゴリー<br />※今後追加するカテゴリーも含まれます(未選択の場合、管理画面上ではダミーデーターが反映されます)
              </label>
            </div>
            <div v-for="category in categories" v-bind:key="category.id">
              <Checkbox
                v-model="attributes.categoryIds"
                :inputId="`cat_${category.id}`"
                name="category"
                :value="category.id"
              />
              <label :for="`cat_${category.id}`" class="ml-2">{{
                category.name
              }}</label>
            </div>
          </div>
          <div class="flex flex-wrap gap-x-2 pt-4">
            <Button
              label="全てのカテゴリを解除する"
              @click="attributes.categoryIds = []"
            ></Button>
            <Button label="情報の追加・編集"></Button>
          </div>
        </div>
      </div>

      <div class="p-8 pt-4 border-b">
        <h1 class="font-bold pb-4">カテゴリ名の表示</h1>
        <div class="flex gap-4">
          <div class="flex items-center">
            <RadioButton
              v-model="attributes.showCategoryName"
              inputId="not_show_category_name"
              name="showCategoryName"
              :value="false"
            />
            <label for="not_show_category_name" class="ml-2 cursor-pointer">
              表示しない
            </label>
          </div>
          <div class="flex items-center">
            <RadioButton
              v-model="attributes.showCategoryName"
              inputId="show_category_name"
              name="showCategoryName"
              :value="true"
            />
            <label for="show_category_name" class="ml-2 cursor-pointer">
              表示する
            </label>
          </div>
        </div>
      </div>

      <div class="p-8 pt-4 border-b">
        <h1 class="font-bold pb-4">表示件数</h1>
        <div class="flex flex-col gap-y-2">
          <Select
            v-model="attributes.showCount"
            :options="showCountOptions"
            optionLabel="label"
            optionValue="value"
            placeholder="選択"
            class="w-full md:w-56"
          />
        </div>
      </div>

      <div class="p-8 pt-4 border-b">
        <h1 class="font-bold pb-4">アコーディオン</h1>
        <div class="flex gap-4">
          <div class="flex items-center">
            <RadioButton
              v-model="attributes.accordionState"
              inputId="fold_accordion_state"
              :value="true"
            />
            <label for="fold_accordion_state" class="ml-2 cursor-pointer">
              折りたたむ
            </label>
          </div>
          <div class="flex items-center">
            <RadioButton
              v-model="attributes.accordionState"
              inputId="not_fold_accordion_state"
              :value="false"
            />
            <label for="show_category_name" class="ml-2 cursor-pointer">
              折りたたまない
            </label>
          </div>
        </div>
      </div>


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
          <div class="flex items-center pl-8 gap-4 flex-wrap">
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
          <div class="flex items-center pl-8 gap-4 flex-wrap">
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
          <div class="flex items-center pl-8 gap-4 flex-wrap">
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

    <div class="px-4 pt-4 pb-4 border-b">
      <h1 class="font-bold pb-4">見出し設定</h1>
      <div class="py-4">
        <Button label="ブログ投稿を選択する"></Button>
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
import Select from 'primevue/select'
import ColorPicker from 'primevue/colorpicker'
import Button from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import RadioButton from 'primevue/radiobutton'

const api = useAPI()
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

const columnOptions = ref([
  { label: '1カラム', value: 1 },
  { label: '2カラム', value: 2 }
])

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

const changePlacementButtonParts = e => {
  if (placementButtonParts.value) {
    attributes.value.parts.button = {
      partsType: 'Button',
      attributes: {
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
    }
  } else {
    delete attributes.value.parts.button
  }
}

const showCountOptions = ref([
  { label: '3件', value: 3 },
  { label: '6件', value: 6 },
  { label: '8件', value: 8 },
  { label: '10件', value: 10 },
  { label: '16件', value: 16 },
  { label: '20件', value: 20 },
  { label: '25件', value: 25 }
])

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
    categoryIds: [],
    showCategoryName: false,
    accordionState: true,
    showCount: 3,
    allCategories: true
  }))
)

const categories = ref([])

const changeButtonHover = e => {
  if (ButtonHover.value) {
    attributes.value.parts.button.attributes.buttonHover =
      ButtonHoverAnimation.value
  } else {
    delete attributes.value.parts.button.attributes.buttonHover
  }
}

const changeButtonShadow = e => {
  if (ButtonShadow.value) {
    attributes.value.parts.button.attributes.buttonShadow =
      ButtonShadowColor.value
  } else {
    delete attributes.value.parts.button.attributes.buttonShadow
  }
}

const changeButtonBgColor = e => {
  if (ButtonBgColor.value) {
    attributes.value.parts.button.attributes.buttonBgColor =
      ButtonBackgroundColor.value
  } else {
    delete attributes.value.parts.button.attributes.buttonBgColor
  }
}

const toggleAllCategory = e => {
  if (attributes.value.allCategories) {
    attributes.value.categoryIds = categories.value.map(i => i.id)
  } else {
    attributes.value.categoryIds = []
  }
}

onMounted(() => {
  tab.value = ''
  partsType.value = 'Faq'
  if (editingParts.value) {
    designTypes.value = designTypes.value.map(v => ({
      ...editingParts.value.attributes,
      designType: v.designType
    }))
  }
  attributes.value = { ...designTypes.value[0] }
  api.faqParts.getCategories().then(res => {
    categories.value = res.data
    if (attributes.value.allCategories) {
      toggleAllCategory()
    }
  })
})
</script>
