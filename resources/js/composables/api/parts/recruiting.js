export const recruitingPartsAPI = ky => {
  return {
    async getCategories(siteId = null) {
      return await ky(`recruiting/categories`, {
        method: 'get',
        searchParams: siteId ? { siteId } : null
      }).json()
    },
    async getItemsByCategory(siteId = null) {
      return await ky(`recruiting/items_by_category`, {
        method: 'get',
        searchParams: siteId ? { siteId } : null
      }).json()
    }
  }
}
