<template>
  <div class="ck-editor-wrapper">
    <Ckeditor
      v-bind="$attrs"
      v-model="contents"
      :config="editorConfig"
      :editor="editor"
      tag-name="textarea"
      lang="ja"
    ></Ckeditor>
  </div>
</template>

<script setup>
import {
  ClassicEditor,
  AccessibilityHelp,
  Alignment,
  Autoformat,
  AutoImage,
  Autosave,
  Bold,
  CloudServices,
  Essentials,
  FontBackgroundColor,
  FontColor,
  FontFamily,
  FontSize,
  Heading,
  ImageBlock,
  ImageInline,
  ImageInsertViaUrl,
  ImageResize,
  ImageStyle,
  ImageTextAlternative,
  ImageToolbar,
  ImageUpload,
  Italic,
  Link,
  LinkImage,
  List,
  Paragraph,
  SelectAll,
  SourceEditing,
  Table,
  TableCaption,
  TableCellProperties,
  TableColumnResize,
  TableProperties,
  TableToolbar,
  TextTransformation,
  Underline,
  Undo
} from 'ckeditor5'

import { Ckeditor } from '@ckeditor/ckeditor5-vue'
import translations from '../../../lang/ja.js'
import 'ckeditor5/ckeditor5.css'
import { ref } from 'vue'

const props = defineProps({
  value: String
})

const editor = ClassicEditor
const editorConfig = {
  language: 'ja',
  translations: [translations],
  plugins: [
    AccessibilityHelp,
    Alignment,
    Autoformat,
    AutoImage,
    Autosave,
    Bold,
    CloudServices,
    Essentials,
    FontBackgroundColor,
    FontColor,
    FontFamily,
    FontSize,
    Heading,
    ImageBlock,
    ImageInline,
    ImageInsertViaUrl,
    ImageResize,
    ImageStyle,
    ImageTextAlternative,
    ImageToolbar,
    ImageUpload,
    Italic,
    Link,
    LinkImage,
    List,
    Paragraph,
    SelectAll,
    SourceEditing,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextTransformation,
    Underline,
    Undo
  ],
  toolbar: {
    items: [
      'sourceEditing',
      '|',
      'undo',
      'redo',
      '|',
      'bold',
      'italic',
      'underline',
      '|',
      'alignment:left',
      'alignment:center',
      'alignment:right',
      '|',
      'link',
      '|',
      'insertImage',
      'insertTable',
      '|',
      'heading',
      'fontFamily',
      'fontSize',
      'fontColor',
      'fontBackgroundColor'
    ],
    shouldNotGroupWhenFull: true
  }
}

const contents = ref(props.value)
</script>

<style scoped>
.ck-editor-wrapper :deep(.ck-editor__editable) {
  min-height: 200px;
}
</style>
