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

      <template v-if="heading">
        <SiteParts
          name="Heading"
          :titleOnly="true"
          v-model:attributes="heading"
          :editable="editable"
        />
      </template>

      <div :class="`pattern${attributes.designType}`" class="w-full">
        <template v-if="[2].includes(attributes.designType)">
          <div class="item">
            <input id="“ac1”" type="checkbox" />
            <label for="“ac1”">
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
              </div>
            </label>
            <Ckeditor
              v-if="editable"
              v-model="attributes.text"
              :editor="InlineEditor"
              :config="editorConfig"
              lang="ja"
              class="txt w-full"
            />
            <div v-else v-html="attributes.text" class="txt w-full text-left" />
          </div>
        </template>

        <template v-else-if="[3].includes(attributes.designType)" class="item">
          <input id="readmore" type="checkbox" />
          <label for="readmore"></label>

          <div class="item">
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
            </div>

            <Ckeditor
              v-if="editable"
              v-model="attributes.text"
              :editor="InlineEditor"
              :config="editorConfig"
              lang="ja"
              class="txt w-full"
            />
            <div v-else v-html="attributes.text" class="txt w-full text-left" />
          </div>
        </template>

        <template
          v-else-if="[7, 8, 9, 10].includes(attributes.designType)"
          class="item"
        >
          <div class="item">
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
            </div>

            <Ckeditor
              v-if="editable"
              v-model="attributes.text"
              :editor="InlineEditor"
              :config="editorConfig"
              lang="ja"
              class="txt w-full"
            />
            <div v-else v-html="attributes.text" class="txt w-full text-left" />
          </div>
        </template>

        <div v-else class="item w-full">
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
          </div>

          <Ckeditor
            v-if="editable"
            v-model="attributes.text"
            :editor="InlineEditor"
            :config="editorConfig"
            lang="ja"
            class="txt w-full"
          />
          <div v-else v-html="attributes.text" class="txt w-full text-left" />
        </div>
      </div>

      <template v-if="button">
        <SiteParts
          name="Button"
          v-model:attributes="button"
          :editable="editable"
        />
      </template>
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
body {
  font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN',
    'Hiragino Sans', Meiryo, sans-serif;
  box-sizing: border-box;
}
p {
  margin: 0px;
}
/*common--------*/
h2,
h3,
h4,
h5,
h6 {
  margin: 0px;
  padding-bottom: 0.4em;
  font-size: 200%;
}
.title {
  font-size: 170%;
}
.subtitle {
  font-weight: 400;
  font-size: 130%;
}
.txt {
  line-height: 1.6em;
}
/*縦書き用縦中横（二桁の数字等）*/
.text-combine {
  -webkit-text-combine: horizontal;
  -ms-text-combine-horizontal: all;
  text-combine-upright: all;
  /*縦中横は該当箇所にのみ適用したい*/
}

/*1--------*/
.pattern1 {
  display: flex;
  justify-content: center;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern1 .item {
  border: 1px solid #3c3c3c;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern1 .titletxt {
  padding: 20px;
  background: #d7d7d7;
  flex-grow: 1;
}
.pattern1 .subtitle {
  padding-top: 0.8em;
}
.pattern1 .txt {
  flex-grow: 1;
  padding: 20px;
  line-height: 1.6em;
}

/*2--------*/
.pattern2 {
  width: 50%;
  margin: 20px auto;
  @media screen and (max-width: 768px) {
    width: 90%;
  }
}

.pattern2 .item {
  position: relative;
  overflow: hidden;
  border: 1px solid #3c3c3c;
}

.pattern2 .item > input {
  display: none;
}

.pattern2 .titletxt {
  position: relative;
  z-index: 1;
  background: #fff;
  padding: 20px;
}

.pattern2 .txt {
  position: absolute;
  visibility: hidden;
  transform: translateY(-100%);
  transition: 0.4s;
  background: #fff;
  padding: 0px 20px 20px 20px;
}

.pattern2 .item > input:checked + label + .txt {
  position: relative;
  visibility: visible;
  transform: translateY(0);
}

.pattern2 .titletxt::before {
  content: '';
  position: absolute;
  width: 20px;
  height: 3px;
  top: 50%;
  right: 10px;
  background: #333;
  transform: translateY(-50%);
}

.pattern2 .titletxt::after {
  content: '';
  position: absolute;
  top: 50%;
  right: 10px;
  width: 20px;
  height: 3px;
  background: #333;
  transition: 0.4s;
  transform: translateY(-50%) rotate(90deg);
}

.pattern2 .item > input:checked + label > .titletxt::after {
  transform: translateY(-50%) rotate(180deg);
}

.pattern2 .subtitle {
  padding-top: 0.8em;
}

/*3--------*/
.pattern3 {
  position: relative;
  margin: 50px auto 0;
  padding: 20px 20px 75px 20px;
  width: 50%;
  border: 1px solid #3c3c3c;
  @media screen and (max-width: 768px) {
    width: 90%;
  }
}

.pattern3 label {
  position: absolute;
  display: table;
  left: 50%;
  bottom: 0;
  margin: 0px auto 20px auto;
  padding: 10px 50px;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  background-color: #333;
  transform: translateX(-50%);
  cursor: pointer;
  z-index: 1;
}

.pattern3 label::before {
  content: '続きを見る';
}

.pattern3 input[type='checkbox']:checked ~ label::before {
  content: '元に戻す';
}

.pattern3 input[type='checkbox'] {
  display: none;
}

.pattern3 .item {
  position: relative;
  height: 100px;
  overflow: hidden;
}
.pattern3 input[type='checkbox']:checked ~ .item {
  height: auto;
}
.pattern3 .txt {
  line-height: 1.6em;
  padding-top: 20px;
}

/*4--------*/
.pattern4 {
  display: flex;
  justify-content: center;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern4 .item {
  padding: 20px;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern4 .titletxt {
  text-align: left;
}
.pattern4 .subtitle {
  padding-top: 0.8em;
}
.pattern4 .txt {
  line-height: 1.6em;
}

/*5--------*/
.pattern5 {
  display: flex;
  justify-content: center;
  height: 300px;
  @media screen and (max-width: 768px) {
    display: none;
  }
}
.pattern5 .item {
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  padding: 20px;
}
.pattern5 .subtitle {
  padding-rigth: 0.8em;
}
.pattern5 .txt {
  line-height: 1.6em;
}

/*6--------*/
.pattern6 {
  display: flex;
  justify-content: center;
  height: 300px;
  @media screen and (max-width: 768px) {
    display: none;
  }
}
.pattern6 .item {
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  width: calc(100% / 4);
  display: flex;
  flex-direction: column-reverse;
}
.pattern6 .subtitle {
  padding-rigth: 0.8em;
}
.pattern6 .txt {
  line-height: 1.6em;
}

/*7--------*/
.pattern7 {
  margin: 0px auto;
  width: 50%;
  padding: 20px;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern7 .item {
  display: flex;
  padding-top: 30px;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern7 .titletxt {
  width: 40%;
  padding-right: 20px;
}
.pattern7 .title {
  position: relative;
}
.pattern7 .title:before {
  background-color: #3c3c3c;
  bottom: -6px;
  content: '';
  height: 3px;
  left: 0%;
  position: absolute;
  width: 30px;
}
.pattern7 .subtitle {
  padding-top: 0.8em;
}
.pattern7 .txt {
  width: 60%;
  line-height: 1.6em;
}

/*8--------*/
.pattern8 {
  margin: 0px auto;
  width: 50%;
  padding: 20px;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern8 .item {
  display: flex;
  padding-top: 30px;
  flex-direction: row-reverse;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern8 .titletxt {
  width: 40%;
  padding-left: 20px;
}
.pattern8 .title {
  position: relative;
}
.pattern8 .title:before {
  background-color: #3c3c3c;
  bottom: -6px;
  content: '';
  height: 3px;
  left: 0%;
  position: absolute;
  width: 30px;
}
.pattern8 .subtitle {
  padding-top: 0.8em;
}
.pattern8 .txt {
  width: 60%;
  line-height: 1.6em;
}

/*9--------*/
.pattern9 {
  margin: 0px auto;
  width: 50%;
  padding: 20px;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern9 .item {
  padding-top: 30px;
  margin-left: auto;
  margin-right: auto;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern9 .titletxt {
  display: block;
  float: right;
  margin-left: 20px;
  width: 30%;
}

.pattern9 .title {
  position: relative;
}
.pattern9 .title:before {
  background-color: #3c3c3c;
  bottom: -6px;
  content: '';
  height: 3px;
  left: 0%;
  position: absolute;
  width: 30px;
}
.pattern9 .subtitle {
  padding-top: 0.8em;
  padding-bottom: 20px;
}
.pattern9 .txt {
  line-height: 1.6em;
  text-align: justify;
  width: 100%;
}

/*10--------*/
.pattern10 {
  margin: 0px auto;
  width: 50%;
  padding: 20px;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern10 .item {
  padding-top: 30px;
  margin-left: auto;
  margin-right: auto;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern10 .titletxt {
  display: block;
  float: left;
  margin-right: 20px;
  width: 30%;
}

.pattern10 .title {
  position: relative;
}
.pattern10 .title:before {
  background-color: #3c3c3c;
  bottom: -6px;
  content: '';
  height: 3px;
  left: 0%;
  position: absolute;
  width: 30px;
}
.pattern10 .subtitle {
  padding-top: 0.8em;
  padding-bottom: 20px;
}
.pattern10 .txt {
  line-height: 1.6em;
  text-align: justify;
  width: 100%;
}
/*11--------*/
.pattern11 {
  display: flex;
  justify-content: center;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern11 .item {
  width: calc(100% / 4);
  display: flex;
  flex-direction: column;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern11 .titletxt {
  padding: 20px;
  text-align: left;
  flex-grow: 1;
}
.pattern11 .subtitle {
  padding-top: 0.8em;
}
.pattern11 .txt {
  flex-grow: 1;
  padding: 0px 20px 20px 20px;
  line-height: 1.6em;
}

/*12--------*/
.pattern12 {
  display: flex;
  flex-direction: row-reverse;
  height: 300px;
  justify-content: center;
  @media screen and (max-width: 768px) {
    display: none;
  }
}
.pattern12 .item {
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  width: calc(100% / 4);
  display: flex;
  flex-direction: column-reverse;
  justify-content: center;
}
.pattern12 .titletxt {
  padding: 20px;
  display: flex;
  flex-direction: column-reverse;
}
.pattern12 .subtitle {
  padding-rigth: 0.8em;
}
.pattern12 .txt {
  padding: 20px;
  line-height: 1.6em;
}

/*13--------*/
.pattern13 {
  display: flex;
  flex-direction: row-reverse;
  height: 300px;
  justify-content: center;
  @media screen and (max-width: 768px) {
    display: none;
  }
}
.pattern13 .item {
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  width: calc(100% / 4);
  display: flex;
  flex-direction: column;
}
.pattern13 .titletxt {
  padding: 20px;
}
.pattern13 .subtitle {
  padding-rigth: 0.8em;
}
.pattern13 .txt {
  padding: 20px;
  line-height: 1.6em;
}

/*14--------*/
.pattern14 {
  display: flex;
  flex-direction: row-reverse;
  height: 300px;
  justify-content: center;
  @media screen and (max-width: 768px) {
    display: none;
  }
}
.pattern14 .item {
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  border: 1px solid #3c3c3c;
  width: calc(100% / 4);
  display: flex;
  flex-direction: column;
}
.pattern14 .titletxt {
  padding: 20px;
  background: #d7d7d7;
}
.pattern14 .subtitle {
  padding-rigth: 0.8em;
}
.pattern14 .txt {
  padding: 20px;
  line-height: 1.6em;
}

/*15--------*/
.pattern15 {
  display: flex;
  flex-direction: row-reverse;
  height: 300px;
  justify-content: center;
  @media screen and (max-width: 768px) {
    display: none;
  }
}
.pattern15 .item {
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
  width: calc(100% / 4);
  display: flex;
  flex-direction: column-reverse;
  justify-content: flex-start;
  border: 1px solid #3c3c3c;
}
.pattern15 .titletxt {
  padding: 20px;
  display: flex;
  flex-direction: column-reverse;
  background: #d7d7d7;
}
.pattern15 .subtitle {
  padding-rigth: 0.8em;
}
.pattern15 .txt {
  padding: 20px;
  line-height: 1.6em;
}

/*16--------*/
.pattern16 {
  display: flex;
  justify-content: center;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern16 .item {
  border: 1px solid #3c3c3c;
  width: calc(100% / 4);
  display: flex;
  flex-direction: column;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern16 .titletxt {
  padding: 20px;
  text-align: center;
  background: #d7d7d7;
  flex-grow: 1;
}
.pattern16 .subtitle {
  padding-top: 0.8em;
}
.pattern16 .txt {
  flex-grow: 1;
  padding: 20px;
  line-height: 1.6em;
}

/*17--------*/
.pattern17 {
  display: flex;
  justify-content: center;
  @media screen and (max-width: 768px) {
    width: 100%;
    display: block;
  }
}
.pattern17 .item {
  border: 1px solid #3c3c3c;
  width: calc(100% / 4);
  display: flex;
  flex-direction: column;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern17 .titletxt {
  text-align: left;
  flex-grow: 1;
  display: flex;
  flex-direction: row-reverse;
}
.pattern17 .title {
  padding: 10px;
  width: 80%;
}
.pattern17 .subtitle {
  background: #d7d7d7;
  padding: 10px;
  display: flex;
  align-items: center;
  width: 20%;
  font-size: 80%;
}
.pattern17 .txt {
  flex-grow: 1;
  padding: 20px;
  line-height: 1.6em;
}

/*18--------*/
.pattern18 {
  margin: 0px auto;
  width: 50%;
  @media screen and (max-width: 768px) {
    width: 90%;
  }
}
.pattern18 .item {
  text-align: left;
  padding-top: 40px;
  @media screen and (max-width: 768px) {
    width: 100%;
  }
}
.pattern18 .item:first-child {
  padding-top: 0px;
}
.pattern18 .subtitle {
  padding-top: 0.8em;
}
</style>
