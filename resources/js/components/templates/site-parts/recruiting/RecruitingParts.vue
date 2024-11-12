<template>
  <div
    class="w-full flex flex-col justify-center items-center recruiting"
    :style="[background]"
  >
    <div
      class="w-full flex flex-col justify-center"
      :class="[position]"
      :style="[containerWidth, paddingY, textColor]"
    >
      <template v-if="heading">
        <SiteParts
          :name="heading.partsType"
          v-model:attributes="heading.attributes"
          :editable="editable"
        />
      </template>
      <template v-for="category in itemsByCategory" v-bind:key="category.id">
        <div class="heading block_header_2" v-if="attributes.showCategoryName">
          <h3 class="h">
            {{ category.name }}
          </h3>
          <p class="">{{ category.alias }}</p>
        </div>
        <div class="wrapper_item">
          <article
            class="pop"
            v-for="item in category.recruitings"
            v-bind:key="item.id"
          >
            <div class="inner_item">
              <p class="title">{{ item.title }}</p>
              <p class="">
                {{ item.job_detail }}
              </p>
            </div>
          </article>
        </div>
      </template>

      <template v-if="button">
        <SiteParts
          :name="button.partsType"
          v-model:attributes="button.attributes"
          :editable="editable"
        />
      </template>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import SiteParts from '../SiteParts.vue'
import { useAPI } from '@/composables/api'

const api = useAPI()

defineProps({
  editable: { type: Boolean, default: false }
})

const attributes = defineModel('attributes')

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

const itemsByCategory = ref({})

onMounted(async () => {
  api.recruitingParts.getItemsByCategory().then(res => {
    itemsByCategory.value = res.data
  })
})
</script>

<style scoped></style>
