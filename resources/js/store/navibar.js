import { defineStore } from 'pinia'
import { useWindowSizeStore } from '@/store/window-size'

export const useNavibarStore = defineStore('navibar', {
  state: () => {
    const windowSize = useWindowSizeStore()
    return {
      isOpened: windowSize.isDesktop
    }
  },
  actions: {
    toggle() {
      this.isOpened = !this.isOpened
    }
  }
})
