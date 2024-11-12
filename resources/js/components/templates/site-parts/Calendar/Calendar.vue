<template>
  <div
    class="w-full flex flex-col justify-center items-center"
    :style="[background]"
  >
    <div
      class="w-full flex flex-col justify-center"
      :class="[position]"
      :style="[containerWidth, paddingY, textColor]"
    >
      <a v-if="attributes.anchor" :id="attributes.anchor" />

      <div class="">
        {{ attributes }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Ckeditor } from '@ckeditor/ckeditor5-vue'
import { InlineEditor } from 'ckeditor5'
import { useEditorConf } from '../../../../composables/editor-conf'
import SiteParts from '../SiteParts.vue'

const { editorConfig } = useEditorConf()

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

const heading = computed(() => {
  return attributes.value.parts?.heading
})

const button = computed(() => {
  return attributes.value.parts?.button
})
</script>

<style scoped>
div >>> h2 {
  @apply text-4xl;
}
div >>> h3 {
  @apply text-2xl;
}
div >>> h4 {
  @apply text-xl;
}
</style>
