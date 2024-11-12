<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">高度な設定</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[28px] text-[14px] text-sm flex items-center">
            <span class="text-[#FF0000] text-[14px]">※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。</span>
        </div>
        <form :action="props.path" @submit.prevent="onSubmit" method="post">
            <input type="hidden" name="_token" :value="props.csrfToken" />
            <div class="px-8 py-[28px] w-full border border-[#DFE7EF] mb-8">
                <h1 class="font-semibold font-hiragino text-[22px]">＜header＞～＜/header＞</h1>
                <div class="border-[#bdbdbd] mt-2">
                    <Ckeditor
                        v-model="dataForm.header_content"
                        :config="editorConfig"
                        :editor="editor"
                        name="header_content"
                        tag-name="textarea"
                    />
                    <input type="hidden" name="header_content" :value="dataForm.header_content" />
                </div>
                <h1 class="font-semibold font-hiragino text-[22px] mt-8">＜div id="sidebar"＞～＜/div＞</h1>
                <div class="border-[#bdbdbd] mt-2">
                    <Ckeditor
                        v-model="dataForm.sidebar_content"
                        :config="editorConfig"
                        :editor="editor"
                        name="sidebar_content"
                        tag-name="textarea"
                    />
                    <input type="hidden" name="sidebar_content" :value="dataForm.sidebar_content" />
                </div>
                <h1 class="font-semibold font-hiragino text-[22px] mt-8">＜footer＞～＜/footer＞</h1>
                <div class="border-[#bdbdbd] mt-2">
                    <Ckeditor
                        v-model="dataForm.footer_content"
                        :config="editorConfig"
                        :editor="editor"
                        name="footer_content"
                        tag-name="textarea"
                    />
                    <input type="hidden" name="footer_content" :value="dataForm.footer_content" />
                </div>
                <h1 class="font-semibold font-hiragino text-[22px] mt-8">＜div id="sidebar"＞～＜/div＞ (ブログ・新着情報)</h1>
                <div class="border-[#bdbdbd] mt-2">
                    <Ckeditor
                        v-model="dataForm.sidebar_content2"
                        :config="editorConfig"
                        :editor="editor"
                        name="sidebar_content2"
                        tag-name="textarea"
                    />
                    <input type="hidden" name="sidebar_content2" :value="dataForm.sidebar_content2" />
                </div>

                <StickRegistButton :back-path="backPath" text-back-btn="ダッシュボードに戻る"/>
            </div>
        </form>
    </div>
</template>
<script setup>
import { reactive, defineProps, ref } from 'vue'
import { Autoformat, ClassicEditor, CodeBlock, Essentials, Heading, Undo } from 'ckeditor5'
import { Ckeditor } from '@ckeditor/ckeditor5-vue'
import 'ckeditor5/ckeditor5.css'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const editor = ClassicEditor
const editorConfig = {
    plugins: [Autoformat, Essentials, Undo, CodeBlock, Heading],
    codeBlock: {
        languages: [
            { language: 'html', label: 'HTML' },
        ]
    }
}

const props = defineProps(['site', 'path', 'csrfToken', 'errormessage', 'oldInput', 'backPath'])
const site = reactive(props.site)

let dataForm = reactive({
    header_content: props.oldInput.header_content ?? (site?.header_content || '<pre><code class="language-html"></code></pre>'),
    sidebar_content: props.oldInput.sidebar_content ?? (site?.sidebar_content || '<pre><code class="language-html"></code></pre>'),
    footer_content: props.oldInput.footer_content ?? (site?.footer_content || '<pre><code class="language-html"></code></pre>'),
    sidebar_content2: props.oldInput.sidebar_content2 ?? (site?.sidebar_content2 || '<pre><code class="language-html"></code></pre>'),
})

const onSubmit = async (e) => {
    e.target.submit()
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
