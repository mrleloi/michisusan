import { defineStore } from 'pinia'

export const useBlogsTemplatesStore = defineStore('blogsTemplates', {    state: () => {
        return {
            blogsPostData: {},
            isPublicSetting: false
        }
    },
    actions: {
        getBlogsPostData(formData) {
            this.blogsPostData = {...formData}
        },
        setShowDialog() {
            this.isPublicSetting = true
        },
        setHiddenDialog() {
            console.log('setHiddenDialog', this.isPublicSetting)
            this.isPublicSetting = false
        }
    }
})
