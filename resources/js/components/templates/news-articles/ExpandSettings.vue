<template>
    <h1 class="font-bold px-5 mb-9">拡張設定</h1>
    <div class="w-full px-14">
        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
            <div class="w-1/3 py-6 flex items-center justify-center font-bold font-hiragino">関連タグ</div>
            <div class="w-2/3 p-6 flex items-center border-l border-[#bdbdbd]">
                <Checkbox v-model="expandForm.show_related_tags"
                          binary
                          class="flex gap-1"
                          inputId="relatedTags"
                          name="show_related_tags" />
                <label for="relatedTags" class="ml-2">関連タグを表示する</label>
            </div>
        </div>
        <div class="flex items-center border border-[#bdbdbd] border-b-0">
            <div class="w-1/3 py-6 flex items-center justify-center font-bold font-hiragino">共通フッター</div>
            <div class="w-2/3 p-6 flex items-center border-l border-[#bdbdbd]">
                <Checkbox v-model="expandForm.show_common_footer"
                          binary
                          class="flex gap-1"
                          inputId="commonFooter"
                          name="show_common_footer" />
                <label for="commonFooter" class="ml-2">共通フッターを表示する</label>
            </div>
        </div>
        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8]">
            <div class="w-1/3 py-6 flex items-center justify-center font-bold font-hiragino">アクセス制限</div>
            <div class="w-2/3 p-6 flex flex-col border-l border-[#bdbdbd] gap-y-2">
                <div><label>アカウント：</label>
                    <InputText v-model="expandForm.access_restriction_account" class="w-[117px] h-[38px]" name="access_restriction_account" maxLength="30"/>
                </div>
                <span class="text-red-500 text-[12px]" v-if="errorMessage?.account?.length">{{errorMessage?.account?.[0]}}</span>
                <div><label>パスワード：</label>
                    <InputText v-model="expandForm.access_restriction_password" class="w-[117px] h-[38px]" name="access_restriction_password" maxLength="30"/>
                </div>
                <span class="text-red-500 text-[12px]" v-if="errorMessage?.password?.length">{{errorMessage?.password?.[0]}}</span>
                <p>ページ毎にパスワードでロックすることが出来ます</p>
            </div>
        </div>
    </div>
    <div class="border-t w-full mt-14 mb-6"></div>
    <h1 class="font-bold px-5 mb-9">画像関連</h1>
    <div class="w-full px-14">
        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8]">
            <div class="w-1/3 py-6 flex items-center justify-center font-bold font-hiragino">アイキャッチ画像</div>
            <div class="w-2/3 p-6 flex items-center border-l border-[#bdbdbd]">
                <ImageSelector name="eye_catch" :value="expandForm.eye_catch"/>
            </div>
        </div>
    </div>
    <div class="border-t w-full mt-14 mb-6"></div>
    <h1 class="font-bold px-5 mb-9">ヘッダー・フッター</h1>
    <div class="w-full px-14 pb-11">
        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8] border-b-0">
            <div class="w-1/3 py-6 flex items-center justify-center font-bold font-hiragino">ヘッダー</div>
            <div class="w-2/3 p-6 flex flex-col gap-y-2 border-l border-[#bdbdbd]">
                <div>
                    <Checkbox v-model="expandForm.show_header"
                              binary
                              class="flex gap-1"
                              inputId="showHeader"
                              name="show_header" />
                    <label for="showHeader" class="ml-2">ヘッダーを表示する</label>
                </div>
                <div>
                    <Checkbox v-model="expandForm.show_header_logo"
                              binary
                              class="flex gap-1"
                              inputId="headerLogo"
                              name="show_header_logo" />
                    <label for="headerLogo" class="ml-2">ロゴを表示する</label>
                </div>
                <div>
                    <Checkbox v-model="expandForm.show_header_navigation_menu"
                              binary
                              class="flex gap-1"
                              inputId="headerNavMenu"
                              name="show_header_navigation_menu" />
                    <label for="headerNavMenu" class="ml-2">ナビメニューを表示する</label>
                </div>
                <div>
                    <Checkbox v-model="expandForm.show_header_mv"
                              binary
                              class="flex gap-1"
                              inputId="headerMv"
                              name="show_header_mv" />
                    <label for="headerMv" class="ml-2">MVを表示する</label>
                </div>
            </div>
        </div>
        <div class="flex items-center border border-[#bdbdbd] border-b-0">
            <div class="w-1/3 py-6 flex items-center justify-center font-bold font-hiragino">フッター</div>
            <div class="w-2/3 p-6 flex flex-col gap-y-2 border-l border-[#bdbdbd]">
                <div>
                    <Checkbox v-model="expandForm.show_footer"
                              binary
                              class="flex gap-1"
                              inputId="showFooter"
                              name="show_footer" />
                    <label for="showFooter" class="ml-2">フッターを表示する</label>
                </div>
                <div>
                    <Checkbox v-model="expandForm.show_footer_logo"
                              binary
                              class="flex gap-1"
                              inputId="footerLogo"
                              name="show_footer_logo" />
                    <label for="footerLogo" class="ml-2">ロゴを表示する</label>
                </div>
                <div>
                    <Checkbox v-model="expandForm.show_footer_navigation_menu"
                              binary
                              class="flex gap-1"
                              inputId="footerNavMenu"
                              name="show_footer_navigation_menu" />
                    <label for="footerNavMenu" class="ml-2">ナビメニューを表示する</label>
                </div>
                <div>
                    <Checkbox v-model="expandForm.show_footer_sns"
                              binary
                              class="flex gap-1"
                              inputId="footerSns"
                              name="show_footer_sns" />
                    <label for="footerSns" class="ml-2">SNSボタンを表示する</label>
                </div>
            </div>
        </div>
        <div class="flex items-center border border-[#bdbdbd] bg-[#eff3f8]">
            <div class="w-1/3 py-6 flex items-center justify-center font-bold font-hiragino">サブナビゲーション</div>
            <div class="w-2/3 p-6 flex flex-col border-l border-[#bdbdbd] gap-y-2">
                <Select v-model="expandForm.subnavigation_id" :options="subNavigationOptions" optionLabel="name" placeholder="選択してください" class="w-full md:w-52"  />
                <input hidden name="subnavigation_id" :value="expandForm.subnavigation_id?.id">
            </div>
        </div>
    </div>
</template>

<script setup>
import InputText from 'primevue/inputtext'
import Checkbox from 'primevue/checkbox'
import Button from 'primevue/button'
import Select from 'primevue/select'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import {reactive, ref, defineProps} from 'vue'
const props = defineProps(['subNavigationOptions', 'errorMessage', 'dataUpdate', 'oldInput'])
const subNavigationOptions = ref(props.subNavigationOptions)
const errorMessage = ref(props.errorMessage)
const dataUpdate = reactive(props.dataUpdate)
const subNavigationOptionSelect = reactive(props.subNavigationOptions.find((value) => {
    if (dataUpdate?.subnavigation_id?.id)
        return value.id == dataUpdate?.subnavigation_id?.id
    return value.id == dataUpdate?.subnavigation_id
}))

const expandForm = reactive({
    show_related_tags: props.oldInput?.show_related_tags ?? (dataUpdate?.show_related_tags ? true : false),
    show_common_footer: props.oldInput?.show_common_footer ?? (dataUpdate?.show_common_footer ? true : false),
    access_restriction_account: props.oldInput?.access_restriction_account ?? dataUpdate?.access_restriction_account ?? '',
    access_restriction_password: props.oldInput?.access_restriction_password ?? dataUpdate?.access_restriction_password ?? '',
    eye_catch: props.oldInput?.eye_catch ?? (dataUpdate?.eye_catch ?? null),
    show_header: props.oldInput?.show_header ?? (dataUpdate?.show_header ? true : false),
    show_header_logo: props.oldInput?.show_header_logo ?? (dataUpdate?.show_header_logo ? true : false),
    show_header_navigation_menu: props.oldInput?.show_header_navigation_menu ?? (dataUpdate?.show_header_navigation_menu ? true : false),
    show_header_mv: props.oldInput?.show_header_mv ?? (dataUpdate?.show_header_mv ? true : false),
    show_footer: props.oldInput?.show_footer ?? (dataUpdate?.show_footer ? true : false),
    show_footer_logo: props.oldInput?.show_footer_logo ?? (dataUpdate?.show_footer_logo ? true : false),
    show_footer_navigation_menu: props.oldInput?.show_footer_navigation_menu ?? (dataUpdate?.show_footer_navigation_menu ? true : false),
    show_footer_sns: props.oldInput?.show_footer_sns ?? (dataUpdate?.show_footer_sns ? true : false),
    subnavigation_id: props.oldInput?.subnavigation_id ?? subNavigationOptionSelect,
})
</script>

<style scoped>

</style>
