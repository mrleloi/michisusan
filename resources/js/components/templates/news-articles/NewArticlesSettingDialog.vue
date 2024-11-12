<template>
    <Dialog
        v-model:visible="visible"
        pt:root:class="!border-0 !bg-transparent"
        pt:mask:class="backdrop-blur-sm"
        class="w-[961px]">
        <template #container="{ closeCallback }" class="articles">
            <form :action="path" @submit.prevent="onSubmit" @keydown.enter.prevent method="post">
                <input type="hidden" name="_token" :value="csrfToken">
                <input
                    v-if="content"
                    type="hidden"
                    name="content"
                    :value="JSON.stringify(content)"
                />
                <div class="flex flex-col rounded-md">
                    <div class="bg-[#5457CD] flex justify-between items-center rounded-t-md px-4 py-2">
                        <span class="text-white font-bold">{{ isPublicSetting ? '公開設定' : 'ページ設定' }}</span>

                        <div class="flex items-center gap-4">
                            <Button label="キャンセル" @click="visible = false; setHiddenDialog()" class="btn-articles btn-articles-cancel flex items-center justify-center text-center" />
                            <Button label="決定" type="submit" class="btn-articles btn-articles-submit flex items-center justify-center text-center" @click="onSubmit"/>
                        </div>
                    </div>
                    <div class="w-full h-[60vh] flex flex-col bg-white overflow-y-auto py-6">
                        <div v-show="activeTab === 'basic' && !isPublicSetting">
                            <ArticlesSettingBasic :tags="tags" :errorMessage="errormessage" :old-input="oldInput"
                                                  :data-update="newsArticleData?.is_submit ? newsArticleData : dataUpdate"/>
                        </div>
                        <div v-show="activeTab === 'expand' && !isPublicSetting">
                            <ExpandSettings :subNavigationOptions="subnavigations" :errorMessage="errormessage" :old-input="oldInput"
                                            :data-update="newsArticleData?.is_submit ? newsArticleData : dataUpdate"/>
                        </div>
                        <div v-show="activeTab === 'advanced' && !isPublicSetting">
                            <AdvanceSettings :data-update="newsArticleData?.is_submit ? newsArticleData :dataUpdate"/>
                        </div>
                        <div v-show="isPublicSetting">
                            <PublicSettings :snses="snses" :categories="categories"
                                            :data-update="newsArticleData?.is_submit ? newsArticleData : dataUpdate"/>
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
import ArticlesSettingBasic from "./ArticlesSettingBasic.vue";
import ExpandSettings from "@/components/templates/news-articles/ExpandSettings.vue";
import AdvanceSettings from "@/components/templates/news-articles/AdvanceSettings.vue";
import PublicSettings from "@/components/templates/news-articles/PublicSettings.vue";
import {useNewsArticlesStore} from "@/store/news-articles.js";
import {storeToRefs} from "pinia";
import {usePageSettingStore} from "../../../store/page-setting.js";

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

const store = usePageSettingStore()
const {content} = storeToRefs(store)

const storeNewsArticle = useNewsArticlesStore()
const {getNewsArticleData, setHiddenDialog} = storeNewsArticle
const {isPublicSetting, newsArticleData} = storeToRefs(storeNewsArticle)
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
    formData.append('is_submit', 1);
    const formProps = Object.fromEntries(formData);
    getNewsArticleData(formProps, props.dataUpdate?.category_id, props.dataUpdate?.sns_id)
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
.btn-articles {    color: #fff;
    font-size: 14px;
    font-weight: 700;
    height: 33px;
    padding: 7px 9px;
    min-width: 85px;
}

.btn-articles-cancel {
    background-color: #FF3D32;
    border: 1px solid #3B82F6;
}

.btn-articles-submit {
    background-color: #4CD07D;
    border: 1px solid #4CD07D;
}
</style>
