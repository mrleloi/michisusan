import { defineStore } from 'pinia'
import { usePartsSettingStore } from './parts-setting'

export const usePageSettingStore = defineStore('pages-setting', {
  state: () => {
    return {
      id: null,
      visible: false,
      addPartsPosition: 0,
      tab: '',
      title: '',
      withSeoTitle: false,
      description: '',
      h1Text: '',
      tags: '',
      navigationName: '',
      directory: '/',
      keywords: '',
      showTag: false,
      account: '',
      password: '',
      eyeCatch: '',
      pageId: null,
      showTopNavi: false,
      showSideNavi: false,
      showBottomNavi: false,
      showCategory: false,
      showRelatedPage: false,
      showRelatedTag: false,
      showSitemap: false,
      showCommonSideNavi: false,
      showCommonFooter: false,
      showSeoAnalysis: false,
      showHeader: false,
      showHeaderLogo: false,
      showHeaderNavimenu: false,
      showHeaderMv: false,
      showFooter: false,
      showFooterLogo: false,
      showFooterNavimenu: false,
      showFooterSns: false,
      subnavagationId: null,
      customCss: '',
      customJavascript: '',
      customHeadTag: '',
      content: [],
      publishStatus: true
    }
  },
  getters: {
    partsSetting() {
      return usePartsSettingStore()
    }
  }
})
