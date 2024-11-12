<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">独自JS</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[28px] text-[14px] text-sm flex items-center">
      <span class="text-[#FF0000] text-[14px]">
        ※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。
      </span>
        </div>

        <form :action="props.path" @submit.prevent="onSubmit" method="post">
            <input type="hidden" name="_token" :value="props.csrfToken" />

            <div class="px-8 py-[28px] w-full border border-[#DFE7EF] mb-8">
                <h1 class="font-semibold font-hiragino text-[22px]">過去のJS</h1>
                <Select
                    v-model="selectedItem"
                    :options="items"
                    optionLabel="name"
                    placeholder="選択してください"
                    class="mt-2 mr-6 h-[38px] flex items-center justify-center md:min-w-[400px]"
                />
                <Button
                    class="px-6 py-4 h-[38px]"
                    label="読み込み"
                    rounded
                    @click="fillEditor"
                />

                <input type="hidden" name="css_item" :value="selectedItem.id" />

                <h1 class="font-semibold font-hiragino text-[22px] mt-8">独自JS</h1>
                <div class="border-[#bdbdbd] mt-2">
                    <Ckeditor
                        v-model="dataForm.content"
                        :config="editorConfig"
                        :editor="editor"
                        name="content"
                        tag-name="textarea"
                    />
                    <input type="hidden" name="content" :value="dataForm.content" />
                </div>

                <StickRegistButton :back-path="backPath" text-back-btn="ダッシュボードに戻る"/>
            </div>
        </form>
    </div>
</template>

<script setup>
import Button from 'primevue/button'
import Select from 'primevue/select'
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
            { language: 'css', label: 'CSS' },
            { language: 'javascript', label: 'JavaScript' }
        ]
    }
}

const props = defineProps(['items', 'path', 'csrfToken', 'errormessage', 'lastItem', 'oldInput', 'backPath'])
const lastItem = reactive(props.lastItem)

let dataForm = reactive({
    content: `<pre><code class="language-javascript">${ props.oldInput?.content ?? lastItem?.content ?? '' }</code></pre>`,
})

const items = reactive(props.items.data)
const selectedItem = ref('')

const goBackDashBoard = () => {
    window.location.href = '/admin'
}

const fillEditor = () => {
    if (selectedItem.value && selectedItem.value.content) {
        dataForm.content = `<pre><code class="language-javascript">${selectedItem.value.content}</code></pre>`
    }
}

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
