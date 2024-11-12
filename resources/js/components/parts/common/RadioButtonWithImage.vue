<template>
  <div v-for="option in options" :key="option.key" class="w-72 image-wrapper">
    <div v-if="option.filename">
      <Image
        :src="imagePath(option.filename)"
        class="block py-2 radio-button-image"
        @load="onImageLoaded"
      >
        <template #image>
          <img
            :src="imagePath(option.filename)"
            alt="image"
            @error="onImageLoaded($event, true)"
          />
        </template>
      </Image>
    </div>
    <div v-else>
      <Image src="/img/img_not_found.png" class="radio-button-image"></Image>
    </div>
    <div class="mt-1 mb-5">
      <RadioButton
        v-model="selectedItem"
        :name="name"
        :value="option.key"
        :inputId="option.inputId"
        v-bind="$attrs"
      />
      <label class="ml-1" :for="option.key">{{ option.label }}</label>
    </div>
  </div>
</template>

<script setup>
import RadioButton from 'primevue/radiobutton'
import Image from 'primevue/image'
import { onMounted, ref, unref } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  options: {
    type: Array,
    required: true,
    default: []
  },
  value: {
    type: [String, Number]
  }
})

const onImageLoaded = (e, isError = false) => {
  if (isError) {
    // TODO: エラー時表示どうするか
  }
}

const selectedItem = ref(props.value)
const imagePath = filename => {
  return '/storage/' + filename
}
</script>

<style scoped>
.image-wrapper :deep(.radio-button-image img) {
  width: 330px;
  height: 180px;
}
</style>
