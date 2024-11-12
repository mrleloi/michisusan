import { defineStore } from 'pinia'

export const useNewsArticlesStore = defineStore('newsArticles', {
    state: () => {
        return {
            newsArticleData: {},
            isPublicSetting: false
        }
    },
    actions: {
        getNewsArticleData(formData, category_id = [], sns_id = []) {
            this.newsArticleData = {...formData}
            if (category_id.length > 0) {
                this.newsArticleData = {...this.newsArticleData, ...{category_id}}
            }

            if (sns_id.length > 0) {
                this.newsArticleData = {...this.newsArticleData, ...{sns_id}}
            }
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
