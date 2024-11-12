<template>
  <div>
    <div class="flex gap-2 flex-row">
      <template v-for="{ key, label, value } in linkSelectOptions" :key="key">
        <RadioButton
          class="flex gap-2"
          :inputId="`${inputId}_${key}`"
          v-model="linkSelect"
          :value="value"
        >
          {{ label }}
        </RadioButton>
      </template>
    </div>

    <Dropdown
      v-if="linkSelect === 'list'"
      v-model="linkURL"
      class="w-full"
      :options="pages"
      :name="`${inputId}_link_url`"
      :value="`${setting?.[inputId + '_link_url']}`"
      optionValue="value"
    />
    <InputText
      v-if="linkSelect === 'enter'"
      v-model="linkURL"
      class="w-full"
      :name="`${inputId}_link_url`"
    />

    <p class="">ボタンに表示する文言</p>

    <div class="flex gap-2 flex-row">
      <InputText
        class="w-full px-4"
        :name="`${inputId}_alt`"
        :value="setting?.[`${inputId}_alt`]"
      />
    </div>

    <div v-if="'openLinkType' in $attrs" class="flex gap-2 flex-row">
      <template v-for="{ key, label, value } in linkOpenTypeOptions" :key="key">
        <RadioButton
          class="flex gap-2"
          :inputId="`${inputId}_${key}`"
          :name="`${inputId}_link_open_type`"
          v-model="linkOpenType"
          :value="value"
        >
          {{ label }}
        </RadioButton>
      </template>
    </div>

    <p>『ボタンに表示する文言』が空欄の場合は表示されません</p>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import InputText from 'primevue/inputtext'
import RadioButton from '@/components/parts/common/RadioButton.vue'
import Dropdown from '@/components/parts/common/Dropdown.vue'

const props = defineProps({
  linkURLOptions: {
    type: Array,
    default: () => []
  },
  inputId: {
    type: String
  },
  setting: {
    type: Object
  },
  pages: {
    type: Array,
    default: () => []
  }
})

const linkURL = ref(props.setting?.[`${props.inputId}_link_url`])

const hasLinkUrl = computed(() => {
  const url = props.setting?.[`${props.inputId}_link_url`]
  const page = props.pages.find(v => v.value === url)
  return page ? 'list' : 'enter'
})

const linkSelect = ref(hasLinkUrl.value)
const linkOpenType = ref(props.setting?.[`${props.inputId}_link_open_type`])

const linkSelectOptions = ref([
  {
    key: 'list-type-button-0',
    label: 'リストから選ぶ',
    value: 'list'
  },
  {
    key: 'list-type-button-1',
    label: '直接入力する',
    value: 'enter'
  }
])

const linkOpenTypeOptions = ref([
  {
    key: 'link-open-type-button-0',
    label: '同一ウインドウで開く',
    value: 1
  },
  {
    key: 'link-open-type-button-1',
    label: '別ウインドウで開く',
    value: 2
  }
])
</script>
