<template>
  <div class="h-full" :class="previewSize">
    <div class="site-content py-4">
      <template v-if="content.length">
        <template v-for="element in content">
          <div class="flex flex-col items-center relative box-border">
            <SiteParts
              :name="element.partsType"
              v-model:attributes="element.attributes"
              :editable="false"
            />
          </div>
        </template>
      </template>
    </div>

    <div class="site-footer">
    </div>
  </div>
</template>

<script setup>
import { usePageSettingStore } from '@/store/page-setting'
import { storeToRefs } from 'pinia'
import SiteParts from '@/components/templates/site-parts/SiteParts.vue'
import { computed } from 'vue'
import { useWindowSizeStore } from '../../../store/window-size'

const props = defineProps({
  page: { type: Object, default: null }
})

const store = usePageSettingStore()
const { content } = storeToRefs(store)
const windowSize = useWindowSizeStore()
const { inPreview, previewMode } = storeToRefs(windowSize)

const previewSize = computed(() => {
  if (!windowSize.isDesktop) {
    return 'w-full'
  }
  if (previewMode.value === 'desktop') {
    return 'w-full'
  } else if (previewMode.value === 'tablet') {
    return 'w-[768px]'
  } else {
    return 'w-[363px]'
  }
})

const init = () => {
  if (props.page) {
    content.value = JSON.parse(props.page.content)
  }

  inPreview.value = true
  previewMode.value = 'desktop'
}

init()
</script>
