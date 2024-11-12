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
                            <Button label="キャンセル" @click="visible = false; setHiddenDialog()" class="btn-posts btn-posts-cancel flex items-center justify-center text-center" />
                            <Button label="決定" type="submit" class="btn-posts btn-posts-submit flex items-center justify-center text-center" @click="onSubmit"/>
                        </div>
                    </div>
                    <div class="w-full h-[60vh] flex flex-col bg-white overflow-y-auto py-6">
                        <div v-show="activeTab === 'basic' && !isPublicSetting">
                            <BlogsPostsSettingBasic :tags="tags" :errorMessage="errormessage" :old-input="oldInput"
                                                    :data-update="blogsPostData?.is_submit ? blogsPostData : dataUpdate"/>
                        </div>
                        <div v-show="activeTab === 'expand' && !isPublicSetting">
                            <BlogsPostsExpandSettings :subNavigationOptions="subnavigations" :errorMessage="errormessage" :old-input="oldInput"
                                                      :data-update="blogsPostData?.is_submit ? blogsPostData : dataUpdate"/>
                        </div>
                        <div v-show="activeTab === 'advanced' && !isPublicSetting">
                            <BlogsPostsAdvanceSettings :data-update="blogsPostData?.is_submit ? blogsPostData :dataUpdate"/>
                        </div>
                        <div v-show="isPublicSetting">
                            <BlogsPostsPublicSettings :snses="snses" :categories="categories"
                                                      :data-update="blogsPostData?.is_submit ? blogsPostData : dataUpdate" :old-input="oldInput"/>
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
import BlogsPostsSettingBasic from "./BlogsPostsSettingBasic.vue";
import BlogsPostsExpandSettings from "@/components/templates/blogs-posts/BlogsPostsExpandSettings.vue";
import BlogsPostsAdvanceSettings from "@/components/templates/blogs-posts/BlogsPostsAdvanceSettings.vue";
import BlogsPostsPublicSettings from "@/components/templates/blogs-posts/BlogsPostsPublicSettings.vue";
import {useBlogsPostsStore} from "@/store/blogs-posts.js";
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

const storeBlogsPost = useBlogsPostsStore()
const {getBlogsPostData, setHiddenDialog} = storeBlogsPost
const {isPublicSetting, blogsPostData} = storeToRefs(storeBlogsPost)
const visible = ref(true)

const title = ref('')
const description = ref('')
const keywords = ref('')

const activeTab = ref('basic')
const onTab = (type) => {
    activeTab.value = type
}

const onSubmit = ($event) => {
    let formData = new FormData($event.target);
    formData.append('is_submit', 1);
    let formProps = Object.fromEntries(formData);
    getBlogsPostData(formProps, props.dataUpdate?.category_id, props.dataUpdate?.sns_id)
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
    height: 33px;
    padding: 7px 9px;
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
