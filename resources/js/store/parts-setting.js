import { defineStore } from 'pinia'

export const usePartsSettingStore = defineStore('parts-setting', {
  state: () => {
    return {
      visible: false,
      editingParts: null,
      tab: '',
      partsType: '',
      attributes: {}
    }
  }
})
