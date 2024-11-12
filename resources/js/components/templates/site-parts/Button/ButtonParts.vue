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
      <div class="relative">
        <Button
          class="btn"
          :class="[buttonCoverAnimation]"
          :style="[buttonShadow]"
          :label="attributes.label"
          :contenteditable="editable"
          @input="syncLabel"
          rounded
          @click="onClick"
        />
        <i
          v-if="editable"
          @click="modalOpened = !modalOpened"
          class="pi pi-link text-white bg-slate-700 p-1 border border-1 border-white absolute left-[95%] bottom-0 cursor-pointer z-10"
        />
        <ButtonPartsLinkSettingDialog
          v-model:visible="modalOpened"
          v-model:url="linkPath"
          v-model:openWindow="openWindow"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import Button from 'primevue/button'
import ButtonPartsLinkSettingDialog from './ButtonPartsLinkSettingDialog.vue'

const props = defineProps({
  editable: { type: Boolean, default: false }
})

const attributes = defineModel('attributes')
const modalOpened = ref(false)
const linkPath = ref('')
const openWindow = ref(false)

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
const syncLabel = e => {
  attributes.value.label = e.target.innerText
}
const onClick = e => {
  if (!props.editable) {
    if (openWindow.value) {
      open(linkPath.value)
    } else {
      location.href = linkPath.value
    }
  }
}

const buttonCoverAnimation = computed(() => {
  return attributes.value.buttonHover ?? ''
})

const buttonBgColor = computed(() => {
  if (attributes.value.buttonBgColor) {
    return `#${attributes.value.buttonBgColor}`
  } else {
    return '#454545'
  }
})

const buttonShadow = computed(() => {
  if (attributes.value.buttonShadow) {
    return `box-shadow: 10px 5px 5px #${attributes.value.buttonShadow}`
  } else {
    return ''
  }
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
.btn {
  @apply py-4 px-6;
  transition: all 0.2s ease;
  background: v-bind(buttonBgColor) !important;
  border: 1px solid v-bind(buttonBgColor) !important;
}

.reverse:hover {
  background: white !important;
  color: v-bind(buttonBgColor) !important;
}

.stretch:hover {
  letter-spacing: 0.15em;
}

.slide {
  background: #fff !important;
  color: v-bind(buttonBgColor);
  overflow: hidden;
  position: relative;
  z-index: 1;
}
.slide::after {
  background: v-bind(buttonBgColor) !important;
  position: absolute;
  top: 0;
  left: 0;
  content: '';
  width: 100%;
  height: 100%;
  transform: scale(0, 1);
  transform-origin: left top;
  transition: 0.2s cubic-bezier(0.45, 0, 0.55, 1);
  z-index: -1;
}
.slide:hover {
  color: #fff;
}
.slide:hover::after {
  transform: scale(1, 1);
}

.zoom:hover {
  transform: scale(1.1);
}

.fade:hover {
  opacity: 0.5;
}
</style>
