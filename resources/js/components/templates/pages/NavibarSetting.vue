<template>
  <div class="pt-4 pb-2 px-4" v-bind="$attrs">
    <template v-for="{ key, label, value } in buttons" :key="key">
      <RadioButton
        class="flex gap-2"
        :inputId="key"
        v-model="checked"
        :value="value"
      >
        {{ label }}
      </RadioButton>
    </template>
  </div>

  <div class="flex">
    <Dropdown
      v-if="checked === 'internal'"
      class="flex-1 text-left"
      v-model="linkURL"
      :options="pages"
      :name="attrs['input-id'] + '_link_url'"
    />
    <InputText
      v-else-if="checked === 'external'"
      class="flex-1"
      v-model="linkURL"
      :name="attrs['input-id'] + '_link_url'"
    />
  </div>

  <div v-bind="$attrs" class="pt-2 px-4 items-center gap-8">
    <MediaSelector v-model="isDelete" :inputId="attrs['input-id']" />
  </div>

  <div v-bind="$attrs" class="pt-2 px-4 items-center gap-8">
    <div class="py-4 flex flex-col gap-2 flex-1">
      <p class="text-left">画像代替テキスト</p>
      <InputText :name="attrs['input-id'] + '_alt'" v-model="altText" />
    </div>
  </div>
</template>

<script setup>
import { computed, ref, useAttrs } from 'vue'
import RadioButton from '@/components/parts/common/RadioButton.vue'
import InputText from 'primevue/inputtext'
import Dropdown from '@/components/parts/common/Dropdown.vue'
import MediaSelector from '@/components/parts/common/MediaSelector.vue'

const props = defineProps({
  banner: Object,
  pages: Array
})

const attrs = useAttrs()

const hasLinkUrl = computed(() => {
  const linkURL = props.banner?.[`${attrs['input-id']}_link_url`]
  if (!!linkURL) {
    const page = props.pages.find(v => v.value === linkURL)
    return page ? 'internal' : 'external'
  }
  return ''
})

const checked = ref(hasLinkUrl.value)
const isDelete = ref(false)
const altText = ref(props.banner?.[`${attrs['input-id']}_alt`])
const linkURL = ref(props.banner?.[`${attrs['input-id']}_link_url`])

const buttons = [
  {
    key: attrs['input-id'] + '-0',
    label: '内部リンク',
    value: 'internal'
  },
  {
    key: attrs['input-id'] + '-1',
    label: '外部リンク',
    value: 'external'
  },
  {
    key: attrs['input-id'] + '-2',
    label: 'リンクなし',
    value: ''
  }
]
</script>
