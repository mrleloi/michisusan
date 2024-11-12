import { defineStore } from 'pinia'

export const useBlogsPostsStore = defineStore('blogsPosts', {    state: () => {
        return {
            blogsPostData: {},
            isPublicSetting: false
        }
    },
    actions: {
        getBlogsPostData(formData, category_id = [], sns_id = []) {
            this.blogsPostData = {...formData}
            if (category_id.length > 0) {
                this.blogsPostData = {...this.blogsPostData, ...{category_id}}
            }

            if (sns_id.length > 0) {
                this.blogsPostData = {...this.blogsPostData, ...{sns_id}}
            }
        },
        setShowDialog() {
            this.isPublicSetting = true
        },
        setHiddenDialog() {
            this.isPublicSetting = false
        }
    }
})
