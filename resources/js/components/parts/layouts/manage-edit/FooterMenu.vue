<template>
  <Tabs class="">
    <TabList :pt="{ tabList: '!bg-transparent' }">
      <div class="w-full flex justify-between">
        <div class="flex">
          <Tab
            value="0"
            as="div"
            class="flex items-center gap-4"
            :pt="{ root: '!bg-transparent !text-white' }"
            @click="onPageSetting"
          >
            <i class="pi pi-cog" />
            <p>ページ設定</p>
          </Tab>
        </div>

        <div class="flex">
          <Tab
            v-if="windowSize.isDesktop"
            value="1"
            as="div"
            class="flex items-center gap-4"
            :pt="{ root: '!bg-transparent !text-white' }"
            @click="previewMode = 'desktop'"
          >
            <i class="pi pi-desktop" />
          </Tab>
          <Tab
            v-if="windowSize.isDesktop"
            value="2"
            as="div"
            class="flex items-center gap-4"
            :pt="{ root: '!bg-transparent !text-white' }"
            @click="previewMode = 'tablet'"
          >
            <i class="pi pi-tablet" />
          </Tab>
          <Tab
            v-if="windowSize.isDesktop"
            value="3"
            as="div"
            class="flex items-center gap-4"
            :pt="{ root: '!bg-transparent !text-white' }"
            @click="previewMode = 'mobile'"
          >
            <i class="pi pi-mobile" />
          </Tab>

          <Tab
            value="4"
            as="div"
            class="flex items-center gap-4"
            :pt="{ root: '!bg-transparent !text-white' }"
            @click="inPreview = !inPreview"
          >
            <i class="pi pi-external-link" />
            <p v-if="windowSize.isDesktop">プレビュー</p>
          </Tab>
          <Tab
            value="5"
            as="div"
            class="flex items-center gap-4"
            :pt="{ root: '!bg-transparent !text-white' }"
            @click="onPublicSetting"
          >
            <i class="pi pi-save" />
            <p v-if="windowSize.isDesktop">保存する</p>
          </Tab>
        </div>
      </div>
    </TabList>
  </Tabs>
</template>

<script setup>
import Tabs from 'primevue/tabs'
import TabList from 'primevue/tablist'
import Tab from 'primevue/tab'
import { useWindowSizeStore } from '@/store/window-size'
import { useNewsArticlesStore } from '@/store/news-articles.js'
import { useBlogsPostsStore } from '../../../../store/blogs-posts.js'
import { usePageSettingStore } from '../../../../store/page-setting.js'
import { storeToRefs } from 'pinia'
import PagePublicSetting from '@/components/templates/pages/PublicSettings.vue'
import PageBasicSetting from '@/components/templates/pages/PageBasicSetting.vue'
import { useBlogsTemplatesStore } from '@/store/blogs-templates.js'

const storeNewsArticle = useNewsArticlesStore()
const storeBlogsPost = useBlogsPostsStore()
const storeBlogsTemplate = useBlogsTemplatesStore()
const storePageSetting = usePageSettingStore()
const { visible: visiblePageSetting, tab: pageSettingTab } =
  storeToRefs(storePageSetting)

const windowSize = useWindowSizeStore()
const { inPreview, previewMode } = storeToRefs(windowSize)

const onPageSetting = () => {
  if (window.location.pathname.includes('/news_articles')) {
    // storeNewsArticle.setShowDialog()
  }
  if (window.location.pathname.includes('/blogs_posts')) {
    // storeBlogsPost.setShowDialog()
  }
  if (window.location.pathname.includes('/pages')) {
    pageSettingTab.value = PageBasicSetting
    visiblePageSetting.value = true
  }
}

const onPublicSetting = () => {
  if (window.location.pathname.includes('/news_articles')) {
    storeNewsArticle.setShowDialog()
  }
  if (window.location.pathname.includes('/blogs_posts')) {
    storeBlogsPost.setShowDialog()
  }
  if (window.location.pathname.includes('/blogs_templates')) {
    storeBlogsTemplate.setShowDialog()
  }
  if (window.location.pathname.includes('/pages')) {
    visiblePageSetting.value = true
    pageSettingTab.value = PagePublicSetting
  }
}
</script>
