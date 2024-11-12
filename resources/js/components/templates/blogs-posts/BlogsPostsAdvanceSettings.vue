<template>
    <h1 class="font-bold px-5 mb-3">上級者設定</h1>
    <div class="w-full px-10">
        <h1 class="font-bold">独自CSS</h1>
        <p class="my-2.5 text-[#ff0000]">※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。</p>
        <div class="border-[#bdbdbd]">
            <Ckeditor
                v-model="advanceForm.custom_css"
                :config="editorConfig"
                :editor="editor"
                name="custom_css"
                tag-name="textarea"
            />
            <input type="hidden" name="custom_css" :value="advanceForm.custom_css">
        </div>
    </div>
    <div class="border-t w-full mt-10 mb-6"></div>
    <div class="w-full px-10">
        <h1 class="font-bold mb-3">独自JS</h1>
        <p class="my-2.5 text-[#ff0000]">※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。</p>
        <div class="border-[#bdbdbd]">
            <Ckeditor
                v-model="advanceForm.custom_js"
                :config="editorConfig"
                :editor="editor"
                name="custom_js"
                tag-name="textarea"
            />
            <input type="hidden" name="custom_js" :value="advanceForm.custom_js">
        </div>
    </div>
    <div class="border-t w-full mt-10 mb-6"></div>
    <div class="w-full px-10">
        <h1 class="font-bold mb-3">独自＜head＞タグ内容</h1>
        <p class="my-2.5 text-[#ff0000]">※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。</p>
        <div class="border-[#bdbdbd]">
            <Ckeditor
                v-model="advanceForm.custom_head_tag"
                :config="editorConfig"
                :editor="editor"
                name="custom_head_tag"
                tag-name="textarea"
            />
            <input type="hidden" name="custom_head_tag" :value="advanceForm.custom_head_tag">
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive } from 'vue'
import { Autoformat, ClassicEditor, CodeBlock, Essentials, Heading, Undo } from 'ckeditor5'
import { Ckeditor } from '@ckeditor/ckeditor5-vue'

import 'ckeditor5/ckeditor5.css'

const props = defineProps({
    custom_css: {
        type: String
    },
    custom_js: {
        type: String
    },
    custom_head_tag: {
        type: String
    },
    dataUpdate: {
        type: Object
    }
})

const dataUpdate = reactive(props.dataUpdate)
const emit = defineEmits(['submit'])
const advanceForm = reactive({
    custom_css: dataUpdate?.custom_css || '<pre><code class="language-css"></code></pre>',
    custom_js: dataUpdate?.custom_js || '<pre><code class="language-javascript"></code></pre>',
    custom_head_tag: dataUpdate?.custom_head_tag || '<pre><code class="language-html"></code></pre>'
})

const editor = ClassicEditor
const editorConfig = {
    plugins: [Autoformat, Essentials, Undo, CodeBlock, Heading]
}
</script>

<style scoped>
:deep(.ck.ck-editor__top.ck-reset_all) {
    display: none;
}

:deep(.ck.ck-editor__main pre) {
    min-height: 504px;
}
</style>
