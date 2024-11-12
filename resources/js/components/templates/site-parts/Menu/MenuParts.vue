<template>
  <div
    class="w-full flex flex-col justify-center items-center menu-parts"
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

      <template v-for="category in itemsByCategory" v-bind:key="category.id">
        <div
          class="heading block_header_2"
          v-if="attributes.showCategoryName && attributes.showType !== 'ncd'"
        >
          <h3 class="h">
            {{ category.name }}
          </h3>
          <p class="">{{ category.alias }}</p>
        </div>
        <div class="wrapper_item">
          <article
            class="pop"
            v-for="item in category.menu_item"
            v-bind:key="item.id"
          >
            <div>
              <p class="name">{{ item.name }}</p>
              <p class="price">
                {{ item.price }}
                <span v-if="item.append_wave_dash">〜</span>
                <span v-if="item.tax_type == 1">税込み</span
                ><span v-else>税抜き</span>
              </p>
              <p class="description">{{ item.description }}</p>
            </div>
            <div class="inner_item">
              <div class="image1" v-if="item.image1?.filename">
                <a href=""
                  ><img
                    :src="`/storage/${item.image1?.filename}`"
                    alt="画像1"
                  />
                </a>
              </div>
              <div class="image2" v-if="item.image2?.filename">
                <a href=""
                  ><img
                    :src="`/storage/${item.image2?.filename}`"
                    alt="画像2"
                  />
                </a>
              </div>
              <div class="image3" v-if="item.image3?.filename">
                <a href=""
                  ><img
                    :src="`/storage/${item.image3?.filename}`"
                    alt="画像3"
                  />
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
                      <a
                        class="mt-3 text-sm"
                        @click="contentVisible[item.id] = 0"
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
const contentVisible = ref({})

onMounted(() => {
  //  const categorize = attributes.value.showType == 'ncd' ? false : true;
  const categorized = attributes.value.showType !== 'ncd'
  const itemCount =
    attributes.value.showType == 's' ? 1 : attributes.value.showCount

  api.menuParts
    .getItemsByCategory(
      categorized,
      attributes.value.categoryIds,
      attributes.value.allCategories,
      itemCount
    )
    .then(res => {
      itemsByCategory.value = res.data
    })
})
</script>

<style scoped></style>
