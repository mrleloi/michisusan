import { defineStore } from 'pinia'
import { usePartsSettingStore } from './parts-setting'

export const useNewsArticlesSettingStore = defineStore('news-articles-setting', {
    state: () => {
        return {
            visible: false,
            addPartsPosition: 0,
            content: [],
        }
    },
    getters: {
        partsSetting() {
            return usePartsSettingStore()
        }
    }
})
