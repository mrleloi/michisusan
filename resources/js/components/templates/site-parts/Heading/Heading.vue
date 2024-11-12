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

      <div :class="`pattern${attributes.designType}`" class="w-full">
        <div v-if="includeImg" class="img_circle">
          <img src="/img/sample.jpg" />
        </div>

        <template v-if="isTitleFirst">
          <div class="titletxt text-left">
            <Ckeditor
              v-if="editable"
              v-model="attributes.title"
              :editor="InlineEditor"
              :config="editorConfig"
              lang="ja"
              class="w-full title"
            />
            <div
              v-else
              class="w-full title text-left"
              :contenteditable="editable"
              @input="syncTitle"
              v-html="attributes.title"
            />

            <template v-if="!titleOnly">
              <Ckeditor
                v-if="editable"
                v-model="attributes.subtitle"
                :editor="InlineEditor"
                :config="editorConfig"
                lang="ja"
                class="w-full subtitle"
              />
              <div
                v-else
                class="w-full subtitle"
                :contenteditable="editable"
                @input="syncSubtitle"
                v-html="attributes.subtitle"
              />
            </template>
          </div>
        </template>
        <template v-else>
          <div class="titletxt text-left">
            <template v-if="!titleOnly">
              <Ckeditor
                v-if="editable"
                v-model="attributes.subtitle"
                :editor="InlineEditor"
                :config="editorConfig"
                lang="ja"
                class="w-full subtitle"
              />
              <div
                v-else
                class="w-full subtitle"
                :contenteditable="editable"
                @input="syncSubtitle"
                v-html="attributes.subtitle"
              />
            </template>

            <Ckeditor
              v-if="editable"
              v-model="attributes.title"
              :editor="InlineEditor"
              :config="editorConfig"
              lang="ja"
              class="w-full title"
            />
            <div
              v-else
              class="w-full title"
              :contenteditable="editable"
              @input="syncTitle"
              v-html="attributes.title"
            />
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

import { Ckeditor } from '@ckeditor/ckeditor5-vue'
import { InlineEditor } from 'ckeditor5'
import { useEditorConf } from '../../../../composables/editor-conf'

const { editorConfig } = useEditorConf()

const props = defineProps({
  editable: { type: Boolean, default: false },
  titleOnly: { type: Boolean, default: false }
})

const attributes = defineModel('attributes')

const isTitleFirst = computed(() => {
  return [
    1, 3, 5, 6, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 20, 21, 22, 23, 26
  ].includes(attributes.value.designType)
})

const titleOnly = computed(() => {
  return props.titleOnly || [7].includes(attributes.value.designType)
})

const includeImg = computed(() => {
  return [7, 22, 26].includes(attributes.value.designType)
})

const syncTitle = e => {
  attributes.value.title = e.target.innerText
}

const syncSubtitle = e => {
  attributes.value.subtitle = e.target.innerText
}

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

<style scoped>
body {
  font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN',
    'Hiragino Sans', Meiryo, sans-serif;
}
/*common--------*/
.title {
  font-size: 170%;
  width: 100%;
}
.subtitle {
  font-weight: 400;
  padding-top: 0.8em;
}

.title >>> p,
.subtitle >>> p {
  width: 100%;
}

/*1--------*/
.pattern1 {
  margin: 0px auto;
  text-align: center;
  position: relative;
  width: 100%;
}
.pattern1 .title {
  display: flex;
  align-items: center;
  justify-content: center;
}
.pattern1 .title:after {
  margin-left: 1em;
}

/*2--------*/
.pattern2 {
  margin: 0px auto;
  text-align: center;
  width: 100%;
}
.pattern2 .title {
  padding-top: 0.8em;
  font-size: 100%;
}
.pattern2 .subtitle {
  font-size: 170%;
}

/*3--------*/
.pattern3 .titletxt {
  padding: 20px;
  background: #d7d7d7;
  width: 50%;
  margin: 0px auto;
  text-align: center;
  @media screen and (max-width: 768px) {
    width: 90%;
  }
}
.pattern3 .subtitle {
  padding-top: 2em;
}

/*4--------*/
.pattern4 .titletxt {
  padding: 20px;
  background: #d7d7d7;
  width: 50%;
  margin: 0px auto;
  text-align: center;
  @media screen and (max-width: 768px) {
    width: 90%;
  }
}
.pattern4 .title {
  padding-top: 0.8em;
}

/*5--------*/
.pattern5 {
  margin: 0px auto;
  text-align: center;
  width: 100%;
}
.pattern5 .title {
  color: #f00;
}

/*6--------*/
.pattern6 {
  margin: 0px auto;
  text-align: left;
  width: 100%;
}
.pattern6 .titletxt {
  display: flex;
  justify-content: center;
}
.pattern6 .subtitle:before {
  color: #3c3c3c;
  content: '/';
  padding: 0px 20px;
}

/*7--------*/
.pattern7 {
  display: flex;
  justify-content: center;
  align-items: center;
}
.pattern7 .img_circle {
  margin-right: 10px;
}
.pattern7 .img_circle img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
}

/*8--------*/
.pattern8 {
  margin: 0px auto;
  text-align: center;
  position: relative;
  width: 100%;
}
.pattern8 .title {
  display: flex;
  align-items: center;
  justify-content: center;
}
.pattern8 .title:before,
.pattern8 .title:after {
  border-top: 1px solid;
  content: '';
  width: 3em;
}
.pattern8 .title:before {
  margin-right: 1em;
}
.pattern8 .title:after {
  margin-left: 1em;
}

/*9--------*/
.pattern9 {
  margin: 0px auto;
  text-align: center;
  width: 100%;
}
.pattern9 .title {
  position: relative;
}
.pattern9 .title:before {
  background-color: #3c3c3c;
  bottom: -15px;
  content: '';
  height: 3px;
  left: 50%;
  position: absolute;
  transform: translateX(-50%);
  width: 30px;
}
.pattern9 .subtitle {
  padding-top: 2em;
}

/*10_pattern9左寄せ--------*/
.pattern10 {
  margin: 0px auto;
  text-align: left;
  width: 100%;
}
.pattern10 .title {
  position: relative;
}
.pattern10 .title:before {
  background-color: #3c3c3c;
  bottom: -15px;
  content: '';
  height: 3px;
  left: 0%;
  position: absolute;
  width: 30px;
}
.pattern10 .subtitle {
  padding-top: 2em;
}

/*11_pattern9右寄せ--------*/
.pattern11 {
  margin: 0px auto;
  text-align: right;
  width: 100%;
}
.pattern11 .title {
  position: relative;
}
.pattern11 .title:before {
  background-color: #3c3c3c;
  bottom: -15px;
  content: '';
  height: 3px;
  right: 0%;
  position: absolute;
  width: 30px;
}
.pattern11 .subtitle {
  padding-top: 2em;
}

/*12--------*/
.pattern12 {
  margin: 0px auto;
  text-align: center;
  width: 100%;
}
.pattern12 .subtitle {
  position: relative;
}
.pattern12 .subtitle:before {
  background-color: #3c3c3c;
  bottom: -15px;
  content: '';
  height: 3px;
  left: 50%;
  position: absolute;
  transform: translateX(-50%);
  width: 30px;
}

/*13_pattern12左寄せ--------*/
.pattern13 {
  margin: 0px auto;
  text-align: left;
  width: 100%;
}
.pattern13 .subtitle {
  position: relative;
}
.pattern13 .subtitle:before {
  background-color: #3c3c3c;
  bottom: -15px;
  content: '';
  height: 3px;
  left: 0%;
  position: absolute;
  width: 30px;
}

/*14_pattern12右寄せ--------*/
.pattern14 {
  margin: 0px auto;
  text-align: right;
  width: 100%;
}
.pattern14 .subtitle {
  position: relative;
}
.pattern14 .subtitle:before {
  background-color: #3c3c3c;
  bottom: -15px;
  content: '';
  height: 3px;
  right: 0%;
  position: absolute;
  width: 30px;
}

/*15--------*/
.pattern15 {
  margin: 0px auto;
  text-align: center;
  position: relative;
  width: 100%;
}
.pattern15 .title {
  display: flex;
  align-items: center;
  justify-content: center;
}
.pattern15::after {
  position: absolute;
  bottom: -70%;
  left: 50%;
  content: '';
  width: 2px;
  height: 30px;
  background-color: #3c3c3c;
}

/*16--------*/
.pattern16 {
  margin: 0px auto;
  text-align: left;
  position: relative;
  width: 100%;
}
.pattern16 .title {
  padding-top: 0.8em;
}
.pattern16 .subtitle::before {
  content: 'ーーー';
  letter-spacing: -0.2em;
  padding-right: 1em;
}

/*17--------*/
.pattern17 {
  margin: 0px auto;
  text-align: center;
  position: relative;
  display: flex;
  justify-content: center;
}
.pattern17 .titletxt {
  background-color: #d7d7d7;
  box-shadow: 10px 10px 0px 3px #c4c4c4;
  border-radius: 0px;
  padding: 2em;
}

/*18--------*/
.pattern18 {
  margin: 0px auto;
  text-align: center;
  position: relative;
  display: flex;
  justify-content: center;
}
.pattern18 .titletxt {
  display: inline-block;
  position: relative;
  padding: 2em;
  border: solid 1px #3c3c3c;
}

.pattern18 .titletxt::before {
  content: '';
  position: absolute;
  top: 10px;
  bottom: -14px;
  right: -14px;
  left: 10px;
  background: #d7d7d7;
  z-index: -1;
}

/*19--------*/
.pattern19 {
  margin: 0px auto;
  text-align: center;
  position: relative;
}
.pattern19 .titletxt {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.pattern19 .title {
  padding-top: 0.8em;
}
.pattern19 .subtitle {
  padding: 0.5em 1em;
  background: #3c3c3c;
  color: #fff;
}

/*20--------*/
.pattern20 {
  margin: 0px auto;
  text-align: center;
  position: relative;
}
.pattern20 .titletxt {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.pattern20 .title:after {
  background: radial-gradient(
    circle farthest-side,
    #000,
    #000 60%,
    transparent 60%,
    transparent
  );
  background-size: 9px;
  content: '';
  display: inline-block;
  height: 9px;
  width: 100%;
}

/*21--------*/
.pattern21 {
  margin: 0px auto;
  text-align: center;
  position: relative;
}
.pattern21 .titletxt {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.pattern21 .title {
  position: relative;
  margin-bottom: 0.5rem;
  padding-bottom: 1rem;
  background-image: repeating-linear-gradient(
    -45deg,
    transparent 0 3px,
    #d7d7d7 3px 6px
  );
  background-repeat: no-repeat;
  background-size: 100% 0.5rem;
  background-position: bottom;
}

/*22--------*/
.pattern22 {
  margin: 0px auto;
  text-align: left;
  position: relative;
  display: flex;
  justify-content: left;
  align-items: center;
}
.pattern22 .img_circle {
  margin-right: 10px;
}
.pattern22 .img_circle img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
}

/*23--------*/
.pattern23 {
  margin: 0px auto;
  text-align: center;
  position: relative;
}
.pattern23 .titletxt {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.pattern23 .subtitle {
  padding: 0.5em 1em;
  background: #3c3c3c;
  color: #fff;
  margin-top: 1em;
}

/*24--------*/
.pattern24 {
  margin: 0px auto;
  text-align: center;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.pattern24 .titletxt {
  justify-content: center;
  position: relative;
  padding-left: 5em;
  color: #333333;
}
.pattern24 .titletxt::before {
  font-family: 'Oswald', sans-serif;
  font-optical-sizing: auto;
  font-weight: 700;
  font-style: normal;
  position: absolute;
  bottom: 0;
  left: 0;
  z-index: -1;
  color: #d7d7d7;
  font-size: 4em;
  line-height: 1;
  content: attr(data-number);
  pointer-events: none;
  border-bottom: 2px solid #d7d7d7;
}

/*25--------*/
.pattern25 {
  margin: 0px auto;
  text-align: center;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 20px;
}
.pattern25 .titletxt {
  justify-content: center;
  position: relative;
  padding-left: 5em;
  color: #333333;
}
.pattern25 .titletxt::before {
  font-family: 'Oswald', sans-serif;
  font-optical-sizing: auto;
  font-weight: 700;
  font-style: italic;
  position: absolute;
  top: -30px;
  left: 1em;
  z-index: -1;
  color: #d7d7d7;
  font-size: 4em;
  line-height: 1;
  content: attr(data-number);
  pointer-events: none;
}

/*26--------*/
.pattern26 {
  margin: 0px auto;
  text-align: center;
  position: relative;
  width: 100%;
}
.pattern26 .img_circle {
  display: flex;
  justify-content: center;
}
.pattern26 .img_circle img {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
}
.pattern26 .titletxt {
  position: absolute;
  width: 100%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

/*27--------*/
.pattern27 {
  margin: 0px auto;
  text-align: left;
  position: relative;
}
.pattern27 .title {
  background: linear-gradient(
    to right,
    rgba(158, 158, 158, 1) 0%,
    rgba(158, 158, 158, 1) 68%,
    rgba(158, 158, 158, 0) 90%,
    rgba(158, 158, 158, 0) 99%
  );
  padding: 0.5em;
}
.pattern27 .subtitle {
  margin-top: 0.5em;
}
</style>
