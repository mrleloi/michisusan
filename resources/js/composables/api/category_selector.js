export const categorySelectorAPI = ky => {
  return {
    async addMenuCategory({...payload}) {
      return await ky(`menu_item/regist_category`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    },
    async addGalleryCategory({...payload}) {
      return await ky(`gallery_item/regist_category`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    },
    async addRecruitingCategory({...payload}) {
      return await ky(`recruiting/regist_category`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    },
    async addBeforeAfterCategory({...payload}) {
      return await ky(`before_after_item/regist_category`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    },
    async addFaqCategory({...payload}) {
      return await ky(`faq_item/regist_category`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    }
  }
}
