<template>
  <Dialog v-model:visible="visible" class="w-[90vw]">
    <template #container="{ closeCallback }">
      <div class="flex flex-col rounded-md">
        <div
          class="bg-[#5457CD] flex justify-between items-center rounded-t-md px-4 py-2"
        >
          <h1 class="text-white">{{ header }}</h1>

          <form
            :action="props.page?.id ? './update' : './create'"
            method="post"
            class="flex items-center gap-4"
          >
            <Button
              label="キャンセル"
              @click="closeCallback"
              class="w-[90px]"
              size="small"
              severity="danger"
            />

            <template v-if="isPublicSetting">
              <slot />
              <input type="hidden" name="title" :value="title" />
              <input
                v-if="withSeoTitle"
                type="hidden"
                name="with_seo_title"
                :value="withSeoTitle ? '1' : '0'"
              />
              <input
                v-if="description"
                type="hidden"
                name="description"
                :value="description"
              />
              <input
                v-if="h1Text"
                type="hidden"
                name="h1_text"
                :value="h1Text"
              />
              <input
                v-if="navigationName"
                type="hidden"
                name="navigation_name"
                :value="navigationName"
              />
              <input
                v-if="directory"
                type="hidden"
                name="directory"
                :value="directory"
              />
              <input
                v-if="keywords"
                type="hidden"
                name="keywords"
                :value="keywords ? '1' : '0'"
              />
              <input
                v-if="showTag"
                type="hidden"
                name="show_tag"
                :value="showTag ? '1' : '0'"
              />
              <input
                v-if="account"
                type="hidden"
                name="account"
                :value="account"
              />
              <input
                v-if="password"
                type="hidden"
                name="password"
                :value="password"
              />
              <input
                v-if="eyeCatch"
                type="hidden"
                name="eye_catch"
                :value="eyeCatch"
              />
              <input
                v-if="pageId"
                type="hidden"
                name="page_id"
                :value="pageId"
              />
              <input
                v-if="showTopNavi"
                type="hidden"
                name="show_top_navi"
                :value="showTopNavi ? '1' : '0'"
              />
              <input
                v-if="showSideNavi"
                type="hidden"
                name="show_side_navi"
                :value="showSideNavi ? '1' : '0'"
              />
              <input
                v-if="showBottomNavi"
                type="hidden"
                name="show_bottom_navi"
                :value="showBottomNavi ? '1' : '0'"
              />
              <input
                v-if="showCategory"
                type="hidden"
                name="show_category"
                :value="showCategory ? '1' : '0'"
              />
              <input
                v-if="showRelatedPage"
                type="hidden"
                name="show_related_page"
                :value="showRelatedPage ? '1' : '0'"
              />
              <input
                v-if="showRelatedTag"
                type="hidden"
                name="show_related_tag"
                :value="showRelatedTag ? '1' : '0'"
              />
              <input
                v-if="showSitemap"
                type="hidden"
                name="show_sitemap"
                :value="showSitemap ? '1' : '0'"
              />
              <input
                v-if="showCommonSideNavi"
                type="hidden"
                name="show_common_side_navi"
                :value="showCommonSideNavi ? '1' : '0'"
              />
              <input
                v-if="showCommonFooter"
                type="hidden"
                name="show_common_footer"
                :value="showCommonFooter ? '1' : '0'"
              />
              <input
                v-if="showSeoAnalysis"
                type="hidden"
                name="show_seo_analysis"
                :value="showSeoAnalysis ? '1' : '0'"
              />
              <input
                v-if="showHeader"
                type="hidden"
                name="show_header"
                :value="showHeader ? '1' : '0'"
              />
              <input
                v-if="showHeaderLogo"
                type="hidden"
                name="show_header_logo"
                :value="showHeaderLogo ? '1' : '0'"
              />
              <input
                v-if="showHeaderNavimenu"
                type="hidden"
                name="show_header_navimenu"
                :value="showHeaderNavimenu ? '1' : '0'"
              />
              <input
                v-if="showHeaderMv"
                type="hidden"
                name="show_header_mv"
                :value="showHeaderMv ? '1' : '0'"
              />
              <input
                v-if="showFooter"
                type="hidden"
                name="show_footer"
                :value="showFooter ? '1' : '0'"
              />
              <input
                v-if="showFooterLogo"
                type="hidden"
                name="show_footer_logo"
                :value="showFooterLogo ? '1' : '0'"
              />
              <input
                v-if="showFooterNavimenu"
                type="hidden"
                name="show_footer_navimenu"
                :value="showFooterNavimenu ? '1' : '0'"
              />
              <input
                v-if="showFooterSns"
                type="hidden"
                name="show_footer_sns"
                :value="showFooterSns ? '1' : '0'"
              />
              <input
                v-if="subnavagationId"
                type="hidden"
                name="subnavagation_id"
                :value="subnavagationId"
              />
              <input
                v-if="customCss"
                type="hidden"
                name="custom_css"
                :value="customCss"
              />
              <input
                v-if="customJavascript"
                type="hidden"
                name="custom_javascript"
                :value="customJavascript"
              />
              <input
                v-if="customHeadTag"
                type="hidden"
                name="custom_head_tag"
                :value="customHeadTag"
              />
              <input
                v-if="content"
                type="hidden"
                name="content"
                :value="JSON.stringify(content)"
              />
              <input
                type="hidden"
                name="publish_status"
                :value="publishStatus ? '1' : '0'"
              />

              <Button
                label="保存"
                type="submit"
                class="w-[90px]"
                size="small"
                severity="success"
              />
            </template>
            <template v-else>
              <Button
                label="決定"
                @click="closeCallback"
                class="w-[90px]"
                size="small"
                severity="success"
              />
            </template>
          </form>
        </div>

        <div
          class="w-full h-[60vh] flex flex-col items-center gap-4 bg-white overflow-y-auto py-8"
        >
          <component :is="tab" :pages="pages" />
        </div>

        <div
          v-if="!isPublicSetting"
          class="flex items-center gap-4 bg-white py-4"
        >
          <div class="flex-1 flex items-center justify-center gap-4">
            <Button
              label="基本設定"
              class="w-[114px]"
              size="small"
              @click="tab = tabs.basic"
            />
            <Button
              label="拡張設定"
              class="w-[114px]"
              size="small"
              @click="tab = tabs.extension"
            />
            <Button
              label="上級者設定"
              class="w-[114px]"
              size="small"
              @click="tab = tabs.advanced"
            />
          </div>
        </div>
      </div>
    </template>
  </Dialog>
</template>

<script setup>
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import PageBasicSetting from './PageBasicSetting.vue'
import PageExtensionSetting from './PageExtensionSetting.vue'
import PageAdvancedSetting from './PageAdvancedSetting.vue'
import PublicSettings from './PublicSettings.vue'
import { usePageSettingStore } from '../../../store/page-setting'
import { storeToRefs } from 'pinia'
import { computed, ref } from 'vue'

const props = defineProps({
  newPage: { type: Boolean, default: false },
  page: { type: Object, default: null },
  pages: { type: Array }
})

const tabs = ref({
  basic: PageBasicSetting,
  extension: PageExtensionSetting,
  advanced: PageAdvancedSetting
})

const store = usePageSettingStore()
const {
  visible,
  tab,
  title,
  withSeoTitle,
  description,
  h1Text,
  tags,
  navigationName,
  directory,
  keywords,
  showTag,
  account,
  password,
  eyeCatch,
  pageId,
  showTopNavi,
  showSideNavi,
  showBottomNavi,
  showCategory,
  showRelatedPage,
  showRelatedTag,
  showSitemap,
  showCommonSideNavi,
  showCommonFooter,
  showSeoAnalysis,
  showHeader,
  showHeaderLogo,
  showHeaderNavimenu,
  showHeaderMv,
  showFooter,
  showFooterLogo,
  showFooterNavimenu,
  showFooterSns,
  subnavagationId,
  customCss,
  customJavascript,
  customHeadTag,
  content,
  publishStatus
} = storeToRefs(store)

const isPublicSetting = computed(
  () => tab.value.__name == PublicSettings.__name
)

const header = computed(() =>
  isPublicSetting.value ? '公開設定' : 'ページ設定'
)

const init = () => {
  tab.value = tabs.value.basic
  visible.value = props.newPage

  if (props.page) {
    delete props.page.content
    store.$patch({ ...props.page })
  }
}

init()
</script>
