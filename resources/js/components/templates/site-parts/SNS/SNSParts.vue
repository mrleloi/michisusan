<template>
  <div
    class="w-full flex flex-col justify-center items-center"
    :style="[background]"
  >
    <div
      v-if="attributes.designType === 1"
      class="w-full flex flex-col justify-center"
      :class="[position]"
      :style="[containerWidth, paddingY, textColor, fadein]"
    >
      <a v-if="attributes.anchor" :id="attributes.anchor" />
      <div class="pattern1">
        <div class="flex flex-wrap">
          <div class="flex-1">
            <SnsWidgetFaceBook
              v-if="attributes.sns1 === 'facebook'"
              :url="attributes.sns1Url"
              :appId="attributes.sns1AppId"
            />
            <SnsWidgetX
              v-if="attributes.sns1 === 'x'"
              :url="attributes.sns1Url"
            />
            <SnsWidgetInstagram
              v-if="attributes.sns1 === 'instagram'"
              :url="attributes.sns1Url"
            />
            <SnsWidgetTikTok
              v-if="attributes.sns1 === 'tiktok'"
              :url="attributes.sns1Url"
            />
          </div>

          <template v-if="attributes.sns2">
            <div class="flex-1">
              <SnsWidgetFaceBook
                v-if="attributes.sns2 === 'facebook'"
                :url="attributes.sns2Url"
                :appId="attributes.sns2AppId"
              />
              <SnsWidgetX
                v-if="attributes.sns2 === 'x'"
                :url="attributes.sns2Url"
              />
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import SnsWidgetX from '@/components/parts/common/sns_widgets/SnsWidgetX.vue'
import SnsWidgetFaceBook from '@/components/parts/common/sns_widgets/SnsWidgetFaceBook.vue'
import SnsWidgetInstagram from '@/components/parts/common/sns_widgets/SnsWidgetInstagram.vue'
import SnsWidgetTikTok from '@/components/parts/common/sns_widgets/SnsWidgetTikTok.vue'

defineProps({
  editable: { type: Boolean, default: false }
})

const attributes = defineModel('attributes')

const position = computed(() => {
  if (attributes.value.position === 'right') {
    return 'items-end'
  }
  if (attributes.value.position === 'center') {
    return 'items-center'
  }
  return 'items-start'
})

const containerWidth = computed(() => {
  if (attributes.value.containerFullSize) {
    return `width: 90%`
  }

  return `max-width: ${attributes.value.containerWidth}`
})

const paddingY = computed(() => {
  return `padding-top: ${attributes.value.paddingTop}; padding-bottom: ${attributes.value.paddingBottom};`
})

const textColor = computed(() => {
  return `color: ${attributes.value.textColor}`
})
const background = computed(() => {
  if (attributes.value?.backgroundImage) {
    return `background-image: url(${attributes.value.backgroundImage});`
  }
  return `background: ${attributes.value.backgroundColor}`
})
const fadein = computed(() => {
  return ``
})
</script>
