import { defineStore } from 'pinia'
import { useWindowSize } from '@vueuse/core'
import { useNavibarStore } from '@/store/navibar'

export const useWindowSizeStore = defineStore('window-size', {
  state: () => {
    return { ...useWindowSize(), inPreview: false, previewMode: '' }
  },
  getters: {
    isMobile(state) {
      return state.width < 640
    },
    isDesktop(state) {
      return state.width > 1024
    },
    isTablet() {
      return !this.isDesktop && !this.isMobile
    }
  },
  actions: {
    openNavibar() {
      const navibar = useNavibarStore()
      navibar.isOpened = this.isDesktop
    }
  }
})
