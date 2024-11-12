<template>
  <template v-if="tab === ''">
    <h1 class="pl-4 font-bold text-xl">ビフォーアフターデザイン</h1>

    <ul class="flex flex-wrap">
    </ul>
  </template>

  <template v-if="tab === 'setting'">
    せってぃんぐ
  </template>
</template>

<script setup>
import Textarea from 'primevue/textarea'
import InputText from 'primevue/inputtext'
import RadioButton from 'primevue/radiobutton'
import Select from 'primevue/select'
import ColorPicker from 'primevue/colorpicker'

import { onMounted, ref } from 'vue'
import { usePartsSettingStore } from '../../../store/parts-setting'
import { storeToRefs } from 'pinia'
import Checkbox from 'primevue/checkbox'
import Text from './Text.vue'

const store = usePartsSettingStore()
const { partsType, attributes, tab, editingParts } = storeToRefs(store)

const designTypes = ref(
  [1, 2, 3, 4, 5].map(v => ({
    designType: v,
    text: 'テキストテキストテキストテキスト',
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
    anchor: '',
    parts: {}
  }))
)

onMounted(() => {
  tab.value = ''
  partsType.value = 'BeforeAfter'
  if (editingParts.value) {
    designTypes.value = designTypes.value.map(v => ({
      ...editingParts.value.attributes,
      designType: v.designType
    }))
  }
  attributes.value = { ...designTypes.value[0] }
})
</script>
