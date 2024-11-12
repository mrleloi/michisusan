<template>
  ああああああ
  <div
    class="w-full flex flex-col justify-center items-center shop-parts"
    :class="attributes.class ?? null"
    :id="attributes.id ?? null"
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

      <article class="pop">
        <div>
          <p class="name">{{ item.name }}</p>
          <p class="zip">{{ item.zip1 }} - {{ item.zip2 }}</p>
          <div v-if="item.address_type == 1">
            <p class="address1">{{ item.address1 }}</p>
            <p class="address2">{{ item.address2 }}</p>
          </div>
          <div v-else>
            <p class="prefecture">{{ item.prefecture }}</p>
            <p class="city">{{ item.city }}</p>
            <p class="town">{{ item.town }}</p>
            <p class="building">{{ item.building }}</p>
          </div>
          <p class="tel_no">{{ item.tel_no }}</p>
          <p class="fax_no">{{ item.fax_no }}</p>
          <p class="description">{{ item.description }}</p>
        </div>
        <div class="inner_item">
          <div class="image" v-if="item.image?.filename">
            <a href=""
              ><img :src="`/storage/${item.image?.filename}`" alt="画像" />
            </a>
          </div>
          <div class="inner_item_txt" v-if="attributes.showContent">
            <p class="title">{{ item.title }}</p>
            <template v-if="attributes.showContent == 'af'">
              <a
                v-if="contentVisible[item.id] !== 1"
                @click="contentVisible[item.id] = 1"
                >表示</a
              >
              <transition name="slide">
                <div class="" v-if="contentVisible[item.id] == 1">
                  <p>
                    {{ item.content }}
                  </p>
                  <a class="mt-3 text-sm" @click="contentVisible[item.id] = 0"
                    >閉じる</a
                  >
                </div>
              </transition>
            </template>
            <template v-else>
              <p class="">
                {{ item.content }}
              </p>
            </template>
          </div>
        </div>
      </article>

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

const item = ref({})
const contentVisible = ref({})

onMounted(() => {
  api.shopParts.getItem(attributes.value.shopItemId).then(res => {
    item.value = res.data
  })
})
</script>

<style scoped></style>
