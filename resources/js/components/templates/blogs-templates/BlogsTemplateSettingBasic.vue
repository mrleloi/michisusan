<template>
    <div class="w-full py-[24px] px-[18px] border-b-2">
        <div class="box-setting-basic">
            <span class="title">タイトル・ディスクリプション・h1テキスト</span>
            <div class="px-[37px]">
                <table class="posts-table">
                    <tbody>
                    <tr>
                        <td class="title">タイトル</td>
                        <td>
                            <div class="flex items-center justify-end">
                                <InputText v-model.trim="dataForm.title" class="w-full posts-input" maxLength="35" name="title"/>
                                <span class="w-[107px] min-w-[107px] ms-[17px] text-count-char">
                                      {{dataForm.title.length}}文字 / 35文字
                                  </span>
                            </div>
                            <span class="text-red-500 text-[12px]" v-if="errorMessage?.title?.length">{{errorMessage?.title?.[0]}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">ディスクリプション</td>
                        <td>
                            <div class="flex items-center justify-end">
                                <InputText v-model.trim="dataForm.description" class="w-full posts-input" maxLength="250" name="description"/>
                                <span class="w-[107px] min-w-[107px] ms-[17px] text-count-char">
                                      {{dataForm.description.length}}文字 / 250文字
                                  </span>
                            </div>
                            <span class="text-red-500 text-[12px]" v-if="errorMessage?.description?.length">{{errorMessage?.description?.[0]}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">h1テキスト</td>
                        <td>
                            <div class="flex items-center justify-end">
                                <InputText v-model.trim="dataForm.h1_text" class="w-full posts-input" maxLength="35" name="h1_text"/>
                                <span class="w-[107px] min-w-[107px] ms-[17px] text-count-char">
                                      {{dataForm.h1_text.length}}文字 / 35文字
                                  </span>
                            </div>
                            <span class="text-red-500 text-[12px]" v-if="errorMessage?.h1_text?.length">{{errorMessage?.h1_text?.[0]}}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="w-full py-[24px] px-[18px] border-b-2">
        <div class="box-setting-basic">
            <span class="title">基本設定</span>
            <div class="px-[37px]">
                <table class="posts-table">
                    <tbody>
                    <tr>
                        <td class="title">キーワード（タグ）</td>
                        <td>
                            <div class="flex items-center">
                                <div class="flex w-full max-w-[543px] border rounded-lg border-[#D1D5DB]">
                                    <InputText v-model="tag"
                                               class="w-full posts-input max-w-[494px] input-search-keyword"
                                               @keyup.enter="addTag"
                                               maxLength="80"/>
                                    <InputText hidden name="tags" v-model="tagsHidden" />
                                    <div
                                        class="bg-[#F3F4F6] w-[49px] h-[38px] flex items-center justify-center rounded-r-lg cursor-pointer"
                                        @click="addTag">
                                        <span class="text-sm text-[#6B7280]">追加</span>
                                    </div>
                                </div>
                                <span class="text-red-500 text-[12px]" v-if="errorMessage?.tags?.length">{{errorMessage?.tags?.[0]}}</span>
                            </div>
                            <div class="text-sm mt-[15px]">
                                他のページと関連付けに使用されます
                            </div>
                            <div class="text-sm mb-[15px]">
                                ※文章ではなく単語でご入力ください
                            </div>
                            <div class="flex flex-wrap gap-[10px] max-w-[543px]">
                                <template v-if="tagsSelected.length">
                                    <div class="tag-keyword tag-keyword-select" v-for="(tagSelected, keyTagSelected) in tagsSelected"
                                         :key="keyTagSelected">
                                        <span class="cursor-pointer pe-1" @click="removeTag(keyTagSelected)">x</span>
                                        <span>{{ tagSelected }}</span></div>
                                </template>
                            </div>
                            <div class="flex flex-wrap gap-[4px] mt-[10px] bg-white p-3" v-if="tagsFromApi.length">
                                <span class="tag-keyword" v-for="(tagApi, keyTagApi) in tagsFromApi" :key="keyTagApi" @click="selectTag(tagApi)">{{ tagApi }}</span>
                            </div>
                            <div class="max-w-[543px] bg-white mt-[23px] px-[13px] py-[11px] min-h-[119px]">
                                <span class="text-sm text-[#4B5563]">最近登録されたキーワード（タグ）</span>
                                <div class="flex flex-wrap gap-[4px] mt-[15px]" v-if="tags.length">
                                    <span class="tag-keyword" @click="selectTag(tag.name)" v-for="(tag, keyTag) in tags" :key="keyTag">{{tag.name}}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">ナビ表示名</td>
                        <td>
                            <div class="flex items-center justify-end">
                                <InputText v-model.trim="dataForm.navigation_name" class="w-full posts-input" maxLength="35" name="navigation_name" placeholder="コンセプト"/>
                                <span class="w-[107px] min-w-[107px] ms-[17px] text-count-char">
                                  {{dataForm.navigation_name.length}}文字 / 35文字
                              </span>
                            </div>
                            <span class="text-red-500 text-[12px]" v-if="errorMessage?.navigation_name?.length">{{errorMessage?.navigation_name?.[0]}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">ディレクトリ名※</td>
                        <td>
                            <div class="flex items-center">
                                <InputText v-model.trim="dataForm.directory" name="directory" class="w-full posts-input max-w-[505px]"/>
                            </div>
                            <div class="flex gap-2 items-center mt-[15px]">
                                <label>簡易翻訳 : </label>
                                <InputText v-model.trim="text_translate" class="w-[117px] posts-input"/>
                                <Button label="翻訳" @click="translate" class="btn-translate"/>
                                <Button label="ディレクトリ名に反映" @click="reflectTranslate" class="btn-translate"/>
                            </div>
                            <span class="text-red-500 text-[12px]" v-if="errorMessage?.directory?.length">{{errorMessage?.directory?.[0]}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">keywords</td>
                        <td>
                            <div class="flex items-center justify-end">
                                <InputText v-model.trim="dataForm.keywords" name="keywords" class="w-full posts-input max-w-[543px]"/>
                            </div>
                            <span class="text-red-500 text-[12px]" v-if="errorMessage?.keywords?.length">{{errorMessage?.keywords?.[0]}}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script setup>
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import {useAPI} from '@/composables/api'
import {reactive, ref, defineProps} from "vue";
const props = defineProps(['tags', 'errorMessage', 'dataUpdate', 'oldInput'])
const api = useAPI()
const errorMessage = ref(props.errorMessage)
const dataUpdate = reactive(props.dataUpdate)

const tagsSelected = ref(dataUpdate?.tags ? dataUpdate?.tags.split(":::") : []);
const tagsFromApi = ref([]);
const tag = ref('')
const tagsHidden = ref(dataUpdate?.tags ?? '')
const text_translate = ref('')
const tags = ref(props.tags)
const erorMessage = ref(props.errorMessage)

const dataForm = reactive({
    directory: props.oldInput?.directory ?? dataUpdate?.directory ?? '',
    keywords: props.oldInput?.keywords ?? dataUpdate?.keywords ?? '',
    navigation_name: props.oldInput?.navigation_name ?? dataUpdate?.navigation_name ?? '',
    title: props.oldInput?.title ?? dataUpdate?.title ?? '',
    description: props.oldInput?.description ?? dataUpdate?.description ?? '',
    h1_text: props.oldInput?.h1_text ?? dataUpdate?.h1_text ?? '',
    tags: tagsSelected.value.join(':::')
})

const fetchApiGetTags = async () => {
    tagsHidden.value = tagsSelected.value.join(':::')
    const res = await api.blogsPosts.getTags(tagsSelected.value.join(' '))
    tagsFromApi.value = res.length ? res : []
}
const addTag = async () => {
    if (tag.value.length) {
        tagsSelected.value = [...tagsSelected.value, ...[tag.value]]
        tag.value = ''
        await fetchApiGetTags()
    }
}

const removeTag = async (keyTag) => {
    tagsSelected.value.splice(keyTag, 1);
    await fetchApiGetTags()
}

const selectTag = async (tag) => {
    if(!tagsSelected.value.includes(tag)) {
        tagsSelected.value = [...tagsSelected.value, ...[tag]]
        await fetchApiGetTags()
    }
}

const reflectTranslate = async () => {
    dataForm.directory = text_translate.value
}

const translate = async () => {
    const res = await api.blogsPosts.translate({translate_word: text_translate.value})
    text_translate.value = res?.data?.result
}
</script>
<style scoped>
.box-setting-basic {
    font-family: inter;
}

.box-setting-basic .title {
    font-size: 14px;
    line-height: 16.94px;
    font-weight: 700;

}

.posts-input {
    height: 38px;
    padding: 10.5px;
    color: #6B7280;
}

.posts-input::placeholder {
    color: #6B7280;
}

.posts-table {
    border-collapse: collapse;
    width: 100%;
    margin: 23px 0 48px 0;
}

.posts-table td {
    border: 1px solid #BDBDBD;
    padding: 22px 10px 22px 20px;
}

.posts-table tr {
    background-color: #EFF3F8;
}

.posts-table tr:nth-child(even) {
    background-color: #fff;
}

.posts-table th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
}

.posts-table .title {
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    font-family: "Hiragino Kaku Gothic Pro";
    width: 260px;
    text-align: center;
}

.text-count-char {
    color: #4B5563;
    font-size: 14px;
    line-height: 21px;
}

.btn-translate {
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    line-height: 16.94px;
    border-radius: 9999px;
}

.tag-keyword {
    border: 1px solid #DFE7EF;
    background-color: #EFF3F8;
    color: #000;
    padding: 5.5px 14px;
    font-size: 10px;
    line-height: 15px;
    cursor: pointer;
}

.tag-keyword-select {
    background-color: #DADAFC;
    color: #5457CD;
    border: 1px solid #8183F4;
    cursor: unset;
}

.input-search-keyword {
    border: none;
    border-bottom-right-radius: unset;
    border-top-right-radius: unset;
    border-right: 1px solid #D1D5DB;
}
</style>
