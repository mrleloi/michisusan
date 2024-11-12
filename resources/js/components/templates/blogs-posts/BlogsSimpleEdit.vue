<template>
    <div class="w-full h-full px-3 font-[Inter]">
        <h1 class="text-[22px] font-semibold leading-[33px] mb-3">編集</h1>
        <form :action="props.path" @submit.prevent="onSubmit" @keydown.enter.prevent method="post">
            <input type="hidden" name="_token" :value="props.csrfToken">
            <div class="border border-[#DFE7EF] px-[25px] py-[21px] rounded-b font-[Inter]">
                <div class="border-[#bdbdbd] w-full">
                    <InputText v-model="dataForm.navigation_name" class="w-full" maxLength="35" name="navigation_name" placeholder="ナビ表示名"/>
                    <div class="flex items-center justify-between pt-4 pb-10">
                        <span>ナビメニュー及びパンクズリストに使用されます</span>
                        <span class="text-right">
                            {{dataForm.navigation_name.length}}文字 / 35文字
                        </span>
                    </div>
                </div>

                <div class="w-full h-full font-[Inter]">
                    <div class="bg-[#EFF3F8] rounded-t py-6 px-3 text-[16px] text-sm flex items-center">
                        <h1 class="font-semibold">キーワード（タグ）</h1>
                    </div>
                </div>
                <div class="border border-[#DFE7EF] px-[25px] py-[28px] rounded-b font-[Inter]">
                    <div class="flex items-center">
                        <div class="flex w-full rounded-lg">
                            <InputText v-model="tag" class="w-[70%]" @keyup.enter="addTag" placeholder="タグを入力してください" maxLength="80"/>
                            <InputText hidden name="tags" v-model="tagsHidden" />
                            <div class="bg-[#3B82F6] px-6 flex items-center justify-center rounded-lg cursor-pointer ml-8" @click="addTag">
                                <span class="text-[14px] text-[#FFFFFF]">追加</span>
                            </div>
                        </div>
                        <span class="text-red-500 text-[12px]" v-if="errorMessage?.tags?.length">{{errorMessage?.tags?.[0]}}</span>
                    </div>
                    <div class="text-sm mt-6">
                        他のページと関連付けに使用されます
                    </div>
                    <div class="flex flex-wrap gap-[10px]">
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
                    <div class="bg-white mt-[23px] px-[13px] py-[11px] min-h-[119px] border">
                        <span class="text-sm text-[16px]">最近登録されたキーワード（タグ）</span>
                        <div class="flex flex-wrap gap-[4px] mt-[15px]" v-if="tags.length">
                            <span class="tag-keyword" @click="selectTag(tag.name)" v-for="(tag, keyTag) in tags" :key="keyTag">{{tag.name}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-full h-full font-[Inter] pt-8">
                    <div class="bg-[#EFF3F8] rounded-t py-6 px-3 text-[16px] text-sm flex items-center">
                        <h1 class="font-semibold">上部画像表示</h1>
                    </div>
                </div>
                <div class="flex items-center gap-4 border border-[#DFE7EF] rounded-b font-[Inter]">
                    <div class="flex-1 flex items-center justify-center gap-3 border-r border-gray-300 pr-4 py-4">
                        <ImageSelector name="simple_top_image_01" :value="dataForm.simple_top_image_01"/>
                    </div>
                    <div class="flex-1 flex items-center justify-center gap-3 border-r border-gray-300 pr-4 py-4">
                        <ImageSelector name="simple_top_image_02" :value="dataForm.simple_top_image_02"/>
                    </div>
                    <div class="flex-1 flex items-center justify-center gap-3 py-4">
                        <ImageSelector name="simple_top_image_03" :value="dataForm.simple_top_image_03"/>
                    </div>
                </div>

                <div class="py-6">
                    <CkEditorCommon
                        v-model="dataForm.content"
                        name="content"
                        tag-name="textarea"
                        class="h-180 border border-gray-300 rounded-lg p-4 shadow-lg"
                    />
                </div>

                <div class="border border-[#DFE7EF] rounded-b font-[Inter]">
                    <div class="flex items-center justify-between cursor-pointer bg-[#EFF3F8] py-4 border border-[#DFE7EF] rounded-b" @click="toggleDropdown('basic')">
                        <span class="text-lg font-semibold pl-4">ページ設定</span>
                        <span class="text-gray-500 pr-8">{{ dropdownStates.basic ? '▲' : '▼' }}</span>
                    </div>
                    <div v-show="dropdownStates.basic" class="mt-4 px-[25px] pb-6">
                        <p class="font-semibold text-[22px] pb-2">基本設定</p>
                        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                            <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                                <span class="text-base">ディレクトリ名</span><span class="text-[#FF0000]">※</span>
                            </div>
                            <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                                <div class="flex items-center items-center justify-center">
                                    <InputText v-model.trim="dataForm.directory" name="directory" class="w-full" maxLength="80"/>
                                </div>
                                <span class="text-red-500 text-[12px]" v-if="errorMessage?.directory?.length">{{errorMessage?.directory?.[0]}}</span>
                                <div class="flex gap-2 items-center mt-[15px]">
                                    <div class="flex-1 flex items-center justify-left gap-3">
                                        <label class="text-[16px]">簡易翻訳 : </label>
                                        <InputText v-model.trim="text_translate" class="w-[70%]"/>
                                    </div>
                                    <div class="flex-1 flex items-center justify-left gap-3">
                                        <Button label="翻訳" @click="translate" class="w-[30%]" />
                                        <Button label="ディレクトリ名に反映" @click="reflectTranslate" class="w-full" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center border border-[#bdbdbd] border-b-0">
                            <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                                <span class="text-base">タイトル</span>
                            </div>
                            <div class="border-[#bdbdbd] px-[18px] pt-[24px] pb-[16px] w-full border-l">
                                <InputText class="w-full" v-model="dataForm.title" name="title" maxLength="35" placeholder="titleタグに使用されます"/>
                                <span class="text-red-500 text-[12px]" v-if="errorMessage?.title?.length">{{errorMessage?.title?.[0]}}</span>
                                <div class="pt-3 flex items-center justify-end">
                                    <span class="text-right">{{dataForm.title.length}}文字/30文字</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                            <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                                <span class="text-base">description</span>
                            </div>
                            <div class="border-[#bdbdbd] px-[18px] pt-[24px] pb-[16px] w-full border-l">
                                <InputText class="w-full" v-model="dataForm.description" name="description" maxLength="250" placeholder="discription及び関連記事リンクの説明文に使用されます"/>
                                <div class="pt-3 flex items-center justify-end">
                                    <span class="text-right">{{dataForm.description.length}}文字/250文字</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center border border-[#bdbdbd] border-b-0">
                            <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] ">
                                <span class="text-base">keywords</span>
                            </div>
                            <div class="border-[#bdbdbd] px-[18px] py-[24px] w-full border-l">
                                <InputText class="w-full" v-model="dataForm.keywords" name="keywords" maxLength="80" placeholder="meta keywordsに使用されます(半角カンマ区切りで入力してください）"/>
                            </div>
                        </div>
                        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b">
                            <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                                <span class="text-base">h1テキスト</span>
                            </div>
                            <div class="border-[#bdbdbd] px-[18px] pt-[24px] pb-[16px] w-full border-l">
                                <InputText class="w-full" v-model="dataForm.h1_text" name="h1_text" maxLength="35" placeholder="ページ上部にあるh1タグテキストに使用されます"/>
                                <div class="pt-3 flex items-center justify-end">
                                    <span class="text-right">{{dataForm.h1_text.length}}文字/35文字</span>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-[22px] pb-2 pt-8">基本設定</p>
                        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                            <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] ">
                                <span class="text-base">共通フッター</span>
                            </div>
                            <div class="border-[#bdbdbd] px-[18px] py-[28px] w-full border-l">
                                <div class="pt-3">
                                    <Checkbox
                                        v-model="dataForm.show_common_footer"
                                        binary
                                        class="flex gap-1"
                                        inputId="commonFooter"
                                        name="show_common_footer"
                                    />
                                    <label class="ml-2" for="show_common_footer">共通フッターを表示する</label>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center border border-[#bdbdbd] border-b">
                            <div class="font-semibold flex items-center justify-center w-[260px] min-w-[260px] py-[35px] ">
                                <span class="text-base">アクセス制限</span>
                            </div>
                            <div class="border-[#bdbdbd] px-[18px] pt-[28px] pb-[12px] w-full border-l">
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <div class="w-1/2 p-1">
                                            <label class="mr-2" for="account">アカウント：</label>
                                            <InputText name="account" v-model="dataForm.account" class="w-[70%]" maxLength="30" />
                                        </div>
                                        <div class="w-1/2 p-1">
                                            <label class="mr-2" for="password">パスワード：</label>
                                            <InputText name="password" v-model="dataForm.password" class="w-[70%]" maxLength="30" />
                                        </div>
                                    </div>
                                </div>
                                <p class="py-4">ページ毎にパスワードでロックすることが出来ます</p>
                            </div>
                        </div>

                        <p class="font-semibold text-[22px] pb-2 pt-8">ヘッダー・フッター</p>
                        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
                            <div class="w-1/3 py-6 flex items-center justify-center font-bold">フッター</div>
                            <div class="w-2/3 p-6 flex flex-col gap-y-2 border-l border-[#bdbdbd]">
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        v-model="dataForm.show_header"
                                        binary
                                        inputId="showHeader"
                                        name="show_header"
                                    />
                                    <label for="showHeader" class="ml-2">ヘッダーを表示する</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        v-model="dataForm.show_header_logo"
                                        binary
                                        class="flex gap-1"
                                        inputId="headerLogo"
                                        name="show_header_logo"
                                    ></Checkbox>
                                    <label for="show_header_logo" class="ml-2">ロゴを表示する</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        v-model="dataForm.show_header_navigation_menu"
                                        binary
                                        class="flex gap-1"
                                        inputId="headerNavMenu"
                                        name="show_header_navigation_menu"
                                    ></Checkbox>
                                    <label for="show_header_navigation_menu" class="ml-2">ナビメニューを表示する</label>
                                </div>
                                <div>
                                    <Checkbox
                                        v-model="dataForm.show_header_mv"
                                        binary
                                        class="flex gap-1"
                                        inputId="headerMv"
                                        name="show_header_mv"
                                    ></Checkbox>
                                    <label for="show_header_mv" class="ml-2">MVを表示する</label>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center border border-[#bdbdbd] border-b-0">
                            <div class="w-1/3 py-6 flex items-center justify-center font-bold">フッター</div>
                            <div class="w-2/3 p-6 flex flex-col gap-y-2 border-l border-[#bdbdbd]">
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        v-model="dataForm.show_footer"
                                        binary
                                        inputId="show_footer"
                                        name="show_footer"
                                    />
                                    <label for="show_footer" class="ml-2">フッターを表示する</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        v-model="dataForm.show_footer_logo"
                                        binary
                                        class="flex gap-1"
                                        inputId="show_footer_logo"
                                        name="show_footer_logo"
                                    ></Checkbox>
                                    <label for="show_footer_logo" class="ml-2">ロゴを表示する</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Checkbox
                                        v-model="dataForm.show_footer_navigation_menu"
                                        binary
                                        class="flex gap-1"
                                        inputId="show_footer_navigation_menu"
                                        name="show_footer_navigation_menu"
                                    ></Checkbox>
                                    <label for="show_footer_navigation_menu" class="ml-2">ナビメニューを表示する</label>
                                </div>
                                <div>
                                    <Checkbox
                                        v-model="dataForm.show_footer_sns"
                                        binary
                                        class="flex gap-1"
                                        inputId="show_footer_sns"
                                        name="show_footer_sns"
                                    ></Checkbox>
                                    <label for="show_footer_sns" class="ml-2">SNSボタンを表示する</label>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8]">
                            <div class="w-1/3 py-6 flex items-center justify-center font-bold">サブナビゲーション</div>
                            <div class="w-2/3 p-6 flex flex-col border-l border-[#bdbdbd] gap-y-2">
                                <Select v-model="dataForm.subnavigation_id" :options="subNavigationOptions" optionLabel="name" placeholder="選択してください" class="w-full" />
                                <input hidden name="subnavigation_id" :value="dataForm.subnavigation_id?.id">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border border-[#DFE7EF] rounded-b font-[Inter] mt-6">
                    <div class="flex items-center justify-between cursor-pointer bg-[#EFF3F8] py-4 border border-[#DFE7EF] rounded-b" @click="toggleDropdown('advanced')">
                        <span class="text-lg font-semibold pl-4">上級者設定</span>
                        <span class="text-gray-500 pr-8">{{ dropdownStates.advanced ? '▲' : '▼' }}</span>
                    </div>
                    <div v-show="dropdownStates.advanced" class="mt-4 px-[25px] pb-6">
                        <div class="w-full px-2">
                            <h1 class="font-semibold text-[22px]">独自CSS</h1>
                            <p class="my-2.5 text-[#ff0000]">※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。</p>
                            <div class="border-[#bdbdbd]">
                                <Ckeditor
                                    v-model="dataForm.custom_css"
                                    :config="editorConfig"
                                    :editor="editor"
                                    name="custom_css"
                                    tag-name="textarea"
                                />
                                <input type="hidden" name="custom_css" :value="dataForm.custom_css">
                            </div>
                        </div>
                        <div class="w-full mt-10 mb-6"></div>
                        <div class="w-full px-2">
                            <h1 class="font-semibold mb-3 text-[22px]">独自JS</h1>
                            <p class="my-2.5 text-[#ff0000]">※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。</p>
                            <div class="border-[#bdbdbd]">
                                <Ckeditor
                                    v-model="dataForm.custom_js"
                                    :config="editorConfig"
                                    :editor="editor"
                                    name="custom_js"
                                    tag-name="textarea"
                                />
                                <input type="hidden" name="custom_js" :value="dataForm.custom_js">
                            </div>
                        </div>
                        <div class="w-full mt-10 mb-6"></div>
                        <div class="w-full px-2">
                            <h1 class="font-semibold mb-3 text-[22px]">独自＜head＞タグ内容</h1>
                            <p class="my-2.5 text-[#ff0000]">※設定内容によってはサイト表示が大幅に崩れる事があります、ご注意ください。</p>
                            <div class="border-[#bdbdbd]">
                                <Ckeditor
                                    v-model="dataForm.custom_head_tag"
                                    :config="editorConfig"
                                    :editor="editor"
                                    name="custom_head_tag"
                                    tag-name="textarea"
                                />
                                <input type="hidden" name="custom_head_tag" :value="dataForm.custom_head_tag">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#EFF3F8] rounded-t py-6 px-4 text-[16px] text-sm flex items-center mt-8">
                <span class="text-[16px] font-semibold">公開設定</span>
            </div>
            <div class="px-8 py-[28px] w-full border border-[#DFE7EF]">
                <div class="flex-1">
                    <div class="flex justify-left">
                        <div class="w-1/4 p-1">
                            <RadioButton inputId="publish_status_yes" name="publish_status" value="public" v-model="dataForm.publish_status" />
                            <label class="ml-2" for="publish_status_yes">公開</label>
                        </div>
                        <div class="w-1/4 p-1">
                            <RadioButton inputId="publish_status_no" name="publish_status" value="private" v-model="dataForm.publish_status" />
                            <label class="ml-2" for="publish_status_no">非公開</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-[#EFF3F8] rounded-t py-6 px-4 text-[16px] text-sm flex items-center">
                <span class="text-[16px] font-semibold">テンプレート</span>
            </div>
            <div class="px-8 py-[28px] w-full border border-[#DFE7EF]">
                <div class="w-full">
                    <Checkbox
                        v-model="dataForm.is_template"
                        binary
                        class="flex gap-1"
                        inputId="is_template"
                        name="is_template"
                    />
                    <label class="ml-2" for="is_template">新規テンプレートとして登録</label>
                </div>
            </div>
            <div class="bg-[#EFF3F8] rounded-t py-6 px-4 text-[16px] text-sm flex items-center">
                <span class="text-[16px] font-semibold">公開日時</span>
            </div>
            <div class="px-8 py-[28px] w-full border border-[#DFE7EF]">
                <div class="w-full">
                    <DatePicker name="published_at" id="datepicker-24h" v-model="dataForm.published_at" dateFormat="yy-mm-dd" hourFormat="24" showTime class="w-[50%]" />
                </div>
            </div>
            <div class="bg-[#EFF3F8] rounded-t py-6 px-4 text-[16px] text-sm flex items-center">
                <span class="text-[16px] font-semibold">SNS連動</span>
            </div>
            <div class="px-8 py-[28px] w-full border border-[#DFE7EF]">
                <div class="w-full">
                    <div v-for="sns of snsOptions" :key="sns.id" class="flex items-center py-4">
                        <Checkbox v-model="dataForm.sns_id" :inputId="'sns_' + sns.id" name="sns_id[]" :value="sns.id" />
                        <label class="ml-2" for="is_template">{{ sns.name }}</label>
                    </div>
                </div>
            </div>
            <div class="bg-[#EFF3F8] rounded-t py-6 px-4 text-[16px] text-sm flex items-center">
                <span class="text-[16px] font-semibold">カテゴリー</span>
            </div>
            <div class="px-8 py-[28px] w-full border border-[#DFE7EF]">
                <div v-for="category of categoryOptions" :key="category.id" class="flex items-center py-4">
                    <Checkbox v-model="dataForm.category_id" :inputId="'category_' + category.id" :value="category.id" name="category_id[]" />
                    <label class="ml-2" for="is_template">{{ category.name }}</label>
                </div>
            </div>
            <div class="bg-[#EFF3F8] rounded-t py-6 px-4 text-[16px] text-sm flex items-center">
                <span class="text-[16px] font-semibold">アイキャッチ画像</span>
            </div>
            <div class="px-8 py-[28px] w-full border border-[#DFE7EF]">
                <div class="flex items-center border-[#bdbdbd]">
                    <ImageSelector name="eye_catch" :value="dataForm.eye_catch"/>
                </div>
            </div>

            <StickRegistButton :back-path="backPath" />
        </form>
    </div>
</template>
<script setup>
import InputText from "primevue/inputtext"
import Button from "primevue/button"
import Checkbox from "primevue/checkbox"
import Select from 'primevue/select'
import RadioButton from 'primevue/radiobutton'
import DatePicker from 'primevue/datepicker'
import {useAPI} from '@/composables/api'
import {reactive, ref, defineProps} from "vue"
import { Autoformat, ClassicEditor, CodeBlock, Essentials, Heading, Undo } from 'ckeditor5'
import { Ckeditor } from '@ckeditor/ckeditor5-vue'
import 'ckeditor5/ckeditor5.css'
import CkEditorCommon from '@/components/parts/common/CkEditor.vue'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import StickRegistButton from '@/components/parts/common/StickRegistButton.vue'

const text_translate = ref('')
const dropdownStates = ref({
    basic: true,
    advanced: true,
})

const toggleDropdown = (key) => {
    dropdownStates.value[key] = !dropdownStates.value[key];
}

const props = defineProps({
    path: String,
    tags: Array,
    subnavigations: Object,
    snses: Array,
    categories: Array,
    csrfToken: String,
    successmessage: String,
    errormessage: Array,
    oldInput: Object,
    dataUpdate: Object,
    custom_css: {
        type: String
    },
    custom_js: {
        type: String
    },
    custom_head_tag: {
        type: String
    },
    backPath: {
        type: String
    }
})
const api = useAPI()

const snsOptions = ref(props.snses)
const categoryOptions = ref(props.categories)
const subNavigationOptions = ref(props.subnavigations)

const dataUpdate = reactive(props.dataUpdate)
const tagsSelected = ref(dataUpdate?.tags ? dataUpdate?.tags.split(":::") : [])

const dataForm = reactive({
    ...props.dataUpdate,
    custom_css: dataUpdate?.custom_css || '<pre><code class="language-css"></code></pre>',
    custom_js: dataUpdate?.custom_js || '<pre><code class="language-javascript"></code></pre>',
    custom_head_tag: dataUpdate?.custom_head_tag || '<pre><code class="language-html"></code></pre>',
})

const tagsFromApi = ref([])
const tag = ref('')
const tagsHidden = ref(dataUpdate?.tags ?? '')
const errorMessage = ref(props.errormessage)
const tags = ref(props.tags)

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

const editor = ClassicEditor
const editorConfig = {
    plugins: [Autoformat, Essentials, Undo, CodeBlock, Heading]
}

const reflectTranslate = async () => {
    dataForm.directory = text_translate.value
}

const translate = async () => {
    const res = await api.blogsPosts.translate({translate_word: text_translate.value})
    text_translate.value = res?.data?.result
}

const onSubmit = async e => {
    e.target.submit()
}
</script>
<style scoped>
.tag-keyword {
    border: 1px solid #DFE7EF;
    background-color: #EFF3F8;
    color: #000;
    padding: 12px 18px;
    font-size: 14px;
    line-height: 15px;
    cursor: pointer;
    font-weight: bold;
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

:deep(.ck.ck-editor__editable_inline) {
    min-height: 504px;
}

:deep(.ck.ck-editor__main pre) {
    min-height: 504px;
}
</style>
