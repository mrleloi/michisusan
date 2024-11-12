<template>
    <Dialog
        v-model:visible="visible"
        pt:root:class="!border-0 !bg-transparent"
        pt:mask:class="backdrop-blur-sm"
        class="w-[961px]">
        <template #container="{ closeCallback }" class="posts">
            <form :action="path" @submit.prevent="onSubmit" @keydown.enter.prevent method="post">
                <input type="hidden" name="_token" :value="csrfToken">
                <div class="flex flex-col rounded-md">
                    <div class="bg-[#5457CD] flex justify-between items-center rounded-t-md px-4 py-2">
                        <span class="text-white font-bold">ページ設定</span>

                        <div class="flex items-center gap-4">
                            <Button label="キャンセル" @click="visible = false; setHiddenDialog()" class="btn-posts btn-posts-cancel" />
                            <Button label="決定" type="submit" class="btn-posts btn-posts-submit" @click="onSubmit"/>
                        </div>
                    </div>
                    <div class="w-full h-[60vh] flex flex-col bg-white overflow-y-auto py-6">
                        <div v-show="activeTab === 'basic' && !isPublicSetting">
                            <BlogsTemplateSettingBasic :tags="tags" :errorMessage="errormessage" :old-input="oldInput"
                                                       :data-update="blogsPostData?.title ? blogsPostData : dataUpdate"/>
                        </div>
                        <div v-show="activeTab === 'expand' && !isPublicSetting">
                            <BlogsTemplateExpandSettings :subNavigationOptions="subnavigations" :errorMessage="errormessage" :old-input="oldInput"
                                                         :data-update="blogsPostData.title ? blogsPostData : dataUpdate"/>
                        </div>
                        <div v-show="activeTab === 'advanced' && !isPublicSetting">
                            <BlogsTemplatesAdvanceSettings :data-update="blogsPostData.title ? blogsPostData :dataUpdate"/>
                        </div>
                        <div v-show="isPublicSetting">
                            <BlogsTemplatePublicSettings :snses="snses" :categories="categories" :old-input="oldInput"
                                                         :data-update="blogsPostData.title ? blogsPostData : dataUpdate"/>
                        </div>
                    </div>

                    <div v-if="!isPublicSetting" class="flex items-center gap-4 bg-white py-4">
                        <div class="flex-1 flex items-center justify-center gap-4">
                            <Button class="" label="基本設定" @click="onTab('basic')"/>
                            <Button class="" label="拡張設定" @click="onTab('expand')"/>
                            <Button class="" label="上級者設定" @click="onTab('advanced')"/>
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </Dialog>
</template>

<script setup>
import {ref, defineProps, watch, reactive} from 'vue'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import BlogsTemplateSettingBasic from "@/components/templates/blogs-templates/BlogsTemplateSettingBasic.vue";
import BlogsTemplateExpandSettings from "@/components/templates/blogs-templates/BlogsTemplateExpandSettings.vue";
import BlogsTemplatesAdvanceSettings from "@/components/templates/blogs-templates/BlogsTemplatesAdvanceSettings.vue";
import BlogsTemplatePublicSettings from "@/components/templates/blogs-templates/BlogsTemplatePublicSettings.vue";
import {useBlogsTemplatesStore} from "@/store/blogs-templates.js";
import {storeToRefs} from "pinia";

const props = defineProps({
    path: String,
    tags: Array,
    subnavigations: Array,
    snses: Array,
    categories: Array,
    csrfToken: String,
    successmessage: String,
    errormessage: Array,
    oldInput: Object,
    dataUpdate: Object
})

const storeBlogsTemplate = useBlogsTemplatesStore()
const {getBlogsPostData, setHiddenDialog} = storeBlogsTemplate
const {isPublicSetting, blogsPostData} = storeToRefs(storeBlogsTemplate)
const visible = ref(true)

const title = ref('')
const description = ref('')
const keywords = ref('')

const activeTab = ref('basic')
const onTab = (type) => {
    activeTab.value = type
}

const onSubmit = ($event) => {
    const formData = new FormData($event.target);
    const formProps = Object.fromEntries(formData);
    getBlogsPostData(formProps)
    visible.value = false;
    if (isPublicSetting.value) {
        $event.currentTarget.submit()
    }
}

watch(isPublicSetting, () => {
    visible.value = isPublicSetting.value
})
</script>
<style scoped>
.btn-posts {
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 33px;
    min-width: 85px;
    font-family: inter;
}

.btn-posts-cancel {
    background-color: #FF3D32;
    border: 1px solid #3B82F6;
}

.btn-posts-submit {
    background-color: #4CD07D;
    border: 1px solid #4CD07D;
}
</style>
