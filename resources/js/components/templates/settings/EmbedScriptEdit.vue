<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold font-hiragino leading-[33px] mb-3">埋め込みスクリプト</h1>
        <div class="bg-[#DFE7EF] rounded-t px-[38px] py-[28px] text-[14px] text-sm flex items-center">
          <span class="text-[#FF0000] text-[14px]">
            ※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。
          </span>
        </div>
        <form :action="props.path" @submit.prevent="onSubmit" method="post">
            <input type="hidden" name="_token" :value="props.csrfToken" />
            <div class="px-8 py-[28px] w-full border border-[#DFE7EF] mb-8">
                <h1 class="font-semibold font-hiragino text-[22px] mt-6 m-3 ml-0">＜head＞直下埋め込み</h1>
                <Textarea v-model="embeddedScriptForm.head_embedded_script" class="w-full h-[108px]" name="head_embedded_script"/>
                <h1 class="font-semibold font-hiragino text-[22px] mt-6 m-3 ml-0">＜head＞直下埋め込み (サンクスページ以外)</h1>
                <Textarea v-model="embeddedScriptForm.head_embedded_script2" class="w-full h-[108px]" name="head_embedded_script2"/>
                <h1 class="font-semibold font-hiragino text-[22px] mt-6 m-3 ml-0">＜/head＞直前埋め込み</h1>
                <Textarea v-model="embeddedScriptForm.head_embedded_script3" class="w-full h-[108px]" name="head_embedded_script3"/>
                <h1 class="font-semibold font-hiragino text-[22px] mt-6 m-3 ml-0">＜body＞直下埋め込み</h1>
                <Textarea v-model="embeddedScriptForm.body_embedded_script" class="w-full h-[108px]" name="body_embedded_script"/>
                <h1 class="font-semibold font-hiragino text-[22px] mt-6 m-3 ml-0">＜/body＞直前埋め込み</h1>
                <Textarea v-model="embeddedScriptForm.body_embedded_script2" class="w-full h-[108px]" name="body_embedded_script2"/>
                <h1 class="font-semibold font-hiragino text-[22px] mt-6 m-3 ml-0">＜/body＞直前埋め込み (サンクスページ以外)</h1>
                <Textarea v-model="embeddedScriptForm.body_embedded_script3" class="w-full h-[108px]" name="body_embedded_script3"/>
                <h1 class="font-semibold font-hiragino text-[22px] mt-6 m-3 ml-0">TELタップ測定JS内</h1>
                <Textarea v-model="embeddedScriptForm.body_tel_script" class="w-full h-[108px]" name="body_tel_script"/>
                <p class="text-[#FF0000]">JS内への追記となる為、構文ミスが存在するとサイト自体の表示が行えなくなります。</p>
                <p class="text-[#FF0000]">記述する内容に関しましては、十分にご注意ください。</p>

                <StickRegistButton :back-path="backPath" text-back-btn="ダッシュボードに戻る"/>
            </div>
        </form>
    </div>
</template>
<script setup>
import Textarea from "primevue/textarea";
import {defineProps, reactive, ref} from "vue";
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const props = defineProps(['site', 'path', 'csrfToken', 'oldInput', 'backPath'])
const site = reactive(props.site)

const embeddedScriptForm = reactive({
    head_embedded_script: props.oldInput?.name ?? site.head_embedded_script ?? '',
    head_embedded_script2: props.oldInput?.head_embedded_script2 ?? site.head_embedded_script2 ?? '',
    head_embedded_script3: props.oldInput?.head_embedded_script3 ?? site.head_embedded_script3 ?? '',
    body_embedded_script: props.oldInput?.body_embedded_script ?? site.body_embedded_script ?? '',
    body_embedded_script2: props.oldInput?.body_embedded_script2 ?? site.body_embedded_script2 ?? '',
    body_embedded_script3: props.oldInput?.body_embedded_script3 ?? site.head_embedded_script3 ?? '',
    body_tel_script: props.oldInput?.body_tel_script ?? site.body_tel_script ?? ''
})

const onSubmit = async (e) => {
    e.target.submit()
}
</script>
