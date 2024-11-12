<template>
  <div
    class="w-full flex flex-col justify-center items-center beforeafter"
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
            v-for="item in category.before_after_items"
            v-bind:key="item.id"
          >
            <div class="inner_item">
              <div class="before">
                <a href=""
                  ><img
                    :src="`/storage/${item.before_image?.filename}`"
                    alt="Before"
                  />
                </a>
              </div>
              <div class="after">
                <a href=""
                  ><img
                    :src="`/storage/${item.after_image?.filename}`"
                    alt="After"
                  />
                </a>
              </div>
              <div class="inner_item_txt" v-if="attributes.showContent">
                <p class="title">{{ item.title }}</p>
                <p class="">
                  {{ item.content }}
                </p>
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

onMounted(async () => {
  api.beforeAfter.getItemsByCategory().then(res => {
    itemsByCategory.value = res.data
  })
})
</script>

<style scoped>
.heading.block_header_2 {
  margin-bottom: 30px;
  padding-bottom: 10px;
  border-bottom: 1px solid #000;
}

.beforeafter .content_wrapper {
  overflow: hidden;
  max-width: calc(1600px + 4vw);
}
.beforeafter .content_wrapper .contents_btn01 {
  margin-bottom: 30px;
}
.beforeafter .wrapper_item {
  position: relative;
  overflow: hidden;
  margin-bottom: 30px;
}
.beforeafter .wrapper_item:after {
  content: '';
  display: block;
  position: absolute;
  z-index: -1;
  width: 1px;
  height: 100%;
  left: calc(50% - 0.5px);
  top: 0;
  background: #ccc;
}
.beforeafter article {
  float: left;
  width: 50%;
  max-width: 800px;
  box-sizing: border-box;
  padding: 0 0 30px 0;
  position: relative;
}
.beforeafter article:nth-of-type(2n) {
  float: right;
}
.beforeafter article:nth-of-type(2n + 1) {
  clear: both;
}
.beforeafter article:nth-of-type(n + 3) {
  padding-top: 30px;
  border-top: 1px solid var(--i_border_color);
}
.beforeafter .inner_item {
  position: relative;
  margin: 0 30px 0 0;
}
.beforeafter article:nth-of-type(2n) .inner_item {
  margin: 0 0 0 30px;
}
.beforeafter .after {
  width: 70%;
  text-align: center;
  position: relative;
}
.beforeafter .after:before {
  content: '';
  display: block;
  position: absolute;
  height: 10px;
  width: 10px;
  transform: rotate(-45deg);
  border-top: 2px solid #000;
  border-left: 2px solid #000;
  top: calc(50% - 5px);
  left: calc(103.5% - 2px);
}
.beforeafter .before {
  width: 25%;
  text-align: center;
  position: absolute;
  top: 0;
  right: 0;
  height: 100%;
}
.beforeafter .before p,
.beforeafter .after p {
  font-size: 1.3rem;
  display: none;
}
.beforeafter .before a {
  height: 100%;
  background: var(--i_bg_color);
}
.beforeafter img {
  display: block;
  margin: 0 auto 0 !important;
}
.beforeafter .inner_item_txt {
  padding-top: 5px;
}
.beforeafter .title {
  font-size: 1.7rem;
  margin-bottom: 5px;
}
.beforeafter .inner_item_txt p:not(.title) {
  font-size: 1.3rem;
}

@media screen and (min-width: 701px) {
  .news_archive .beforeafter:not(.add_design2):not(.add_design4) article {
    border-bottom: none;
  }
}
@media screen and (max-width: 700px) {
  .beforeafter .wrapper_item:after {
    display: none;
  }
  .beforeafter article {
    float: none !important;
    width: auto;
  }
  .beforeafter .inner_item {
    margin: 0 !important;
  }
  .beforeafter article:nth-of-type(n + 3) {
    border-top: none;
  }
  .beforeafter article:nth-of-type(n + 2) {
    padding-top: 30px;
  }
}

.beforeafter.cotents_hide .inner_item_txt > p:not(.title) {
  display: flex;
  align-items: flex-start;
  justify-content: flex-start;
  width: 100%;
  height: 2.34rem;
  overflow: hidden;
}
.beforeafter.cotents_hide .inner_item_txt > p:not(.title).c_show {
  display: block;
  height: auto;
}
.beforeafter.cotents_hide .inner_item_txt > p:not(.title) br {
  display: none;
}
.beforeafter.cotents_hide .inner_item_txt > p:not(.title).c_show br {
  display: inline;
}
.beforeafter.cotents_hide .inner_item_txt > p:not(.title) > span {
  display: block;
  overflow: hidden;
  max-width: calc(100% - 74px);
}
.beforeafter.cotents_hide .inner_item_txt > p:not(.title).c_show > span {
  display: inline !important;
  width: auto;
  padding-right: 5px;
}
.beforeafter .hidetgl {
  display: none;
}
.beforeafter.cotents_hide .hidetgl {
  display: block;
  width: 74px;
}
.beforeafter.cotents_hide .c_show .hidetgl {
  display: inline-block !important;
  width: auto;
}
.beforeafter.cotents_hide .hidetgl span {
  cursor: pointer;
  opacity: 0.7;
  text-decoration: underline;
  word-break: keep-all;
  white-space: nowrap;
}
.beforeafter.cotents_hide .hidetgl span:before {
  content: '...';
}
.beforeafter.cotents_hide .c_show .hidetgl span:before {
  content: '';
}
@media screen and (min-width: 769px) {
  .beforeafter.cotents_hide_sp .hidetgl {
    display: none !important;
  }
}
@media screen and (max-width: 768px) {
  .beforeafter.cotents_hide_sp .inner_item_txt > p:not(.title) {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    width: 100%;
    height: 2.34rem;
    overflow: hidden;
  }
  .beforeafter.cotents_hide_sp .inner_item_txt > p:not(.title).c_show {
    display: block;
    height: auto;
  }
  .beforeafter.cotents_hide_sp .inner_item_txt > p:not(.title) br {
    display: none;
  }
  .beforeafter.cotents_hide_sp .inner_item_txt > p:not(.title).c_show br {
    display: inline;
  }
  .beforeafter.cotents_hide_sp .inner_item_txt > p:not(.title) > span {
    display: block;
    overflow: hidden;
    max-width: calc(100% - 74px);
  }
  .beforeafter.cotents_hide_sp .inner_item_txt > p:not(.title).c_show > span {
    display: inline !important;
    width: auto;
    padding-right: 5px;
  }
  .beforeafter.cotents_hide_sp .hidetgl {
    display: block;
    width: 74px;
  }
  .beforeafter.cotents_hide_sp .c_show .hidetgl {
    display: inline-block !important;
    width: auto;
  }
  .beforeafter.cotents_hide_sp .hidetgl span {
    cursor: pointer;
    opacity: 0.7;
    text-decoration: underline;
    word-break: keep-all;
    white-space: nowrap;
  }
  .beforeafter.cotents_hide_sp .hidetgl span:before {
    content: '...';
  }
  .beforeafter.cotents_hide_sp .c_show .hidetgl span:before {
    content: '';
  }
}

/*----add_design2 add_design4-----*/

.beforeafter.add_design2 article,
.beforeafter.add_design4 article {
  width: 100%;
  float: none !important;
  max-width: none;
}
.beforeafter.add_design2 article:nth-of-type(n + 3),
.beforeafter.add_design4 article:nth-of-type(n + 3) {
  border-top: none;
}
.beforeafter.add_design2 .wrapper_item:after,
.beforeafter.add_design4 .wrapper_item:after {
  display: none;
}
.beforeafter.add_design2 article:nth-of-type(n + 2),
.beforeafter.add_design4 article:nth-of-type(n + 2) {
  padding-top: 30px;
}
.beforeafter.add_design2 article:nth-of-type(2n) .inner_item,
.beforeafter.add_design4 article:nth-of-type(2n) .inner_item {
  margin: 0;
}

/*----add_design3 add_design4-----*/

.beforeafter.add_design3 .after,
.beforeafter.add_design4 .after {
  margin-left: 30%;
}
.beforeafter.add_design3 .before,
.beforeafter.add_design4 .before {
  right: auto;
  left: 0;
}
.beforeafter.add_design3 .before:before,
.beforeafter.add_design4 .before:before,
.beforeafter.add_design3 .after:before,
.beforeafter.add_design4 .after:before {
  transform: rotate(135deg);
  left: auto;
  right: calc(103.5% - 4px);
}

/*----add_design5-----*/

.beforeafter.add_design6 article {
  width: 100%;
  float: none !important;
  max-width: none;
}
.beforeafter.add_design6 article:nth-of-type(n + 3) {
  border-top: none;
}
.beforeafter.add_design6 .wrapper_item:after {
  display: none;
}
.beforeafter.add_design6 article:nth-of-type(n + 2) {
  padding-top: 30px;
}
.beforeafter.add_design6 article:nth-of-type(2n) .inner_item {
  margin: 0;
}
.beforeafter.add_design6 article .inner_item {
  margin-left: 0;
  margin-right: 0;
}
.beforeafter.add_design5 .before,
.beforeafter.add_design5 .after,
.beforeafter.add_design6 .before,
.beforeafter.add_design6 .after {
  width: 100%;
  position: relative;
  cursor: ew-resize;
}
.beforeafter.add_design5 .before,
.beforeafter.add_design6 .before {
  position: absolute;
  overflow: hidden;
  z-index: 2;
  height: 100%;
}
.beforeafter.add_design5 .before a,
.beforeafter.add_design5 .after a,
.beforeafter.add_design6 .before a,
.beforeafter.add_design6 .after a {
  display: block;
  width: 100%;
  overflow: hidden;
  cursor: ew-resize;
  pointer-events: none;
  max-width: 100%;
}
.edit_view .beforeafter.add_design5 .before a,
.edit_view .beforeafter.add_design6 .before a {
  display: none;
}
.beforeafter.add_design5 .before a,
.beforeafter.add_design6 .before a {
  position: relative;
  width: 50%;
}
.beforeafter.add_design5 .before a:before,
.beforeafter.add_design6 .before a:before {
  content: '';
  display: block;
  width: 2px;
  height: 100%;
  position: absolute;
  top: 0;
  right: 0;
  background: var(--i_txt_color);
  z-index: 3;
}
.beforeafter.add_design5 .before img,
.beforeafter.add_design5 .after img,
.beforeafter.add_design6 .before img,
.beforeafter.add_design6 .after img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: contain;
  object-position: 50% 50%;
  font-family: 'object-fit: contain; object-position: 50% 50%;';
  max-width: none;
  cursor: ew-resize;
}
.beforeafter.add_design5 .before:before,
.beforeafter.add_design6 .before:before,
.beforeafter.add_design5 .after:before,
.beforeafter.add_design6 .after:before {
  display: none;
  cursor: ew-resize;
}
.beforeafter.add_design5 .inner_item + .inner_item_txt {
  margin: 0 30px 0 0;
}
.beforeafter.add_design5 article:nth-of-type(2n) .inner_item + .inner_item_txt {
  margin: 0 0 0 30px;
}
@media screen and (max-width: 700px) {
  .beforeafter.add_design5 .inner_item + .inner_item_txt {
    margin: 0 !important;
  }
}
</style>
