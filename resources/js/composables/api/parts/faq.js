export const faqPartsAPI = ky => {
  return {
    async getCategories(siteId = null) {
      return await ky(`faq/categories`, {
        method: 'get',
        searchParams: siteId ? { siteId } : null
      }).json()
    },
    async getItemsByCategory(
      categorized,
      categoryIds,
      allCategories,
      itemCount,
      siteId = ''
    ) {
      categorized = categorized ? 1 : 0

      const usp = new URLSearchParams()
      usp.append('categorized', categorized)
      categoryIds.forEach(id => usp.append('categoryIds[]', id))
      usp.append('allCatgories', allCategories)

      usp.append('itemCount', itemCount)
      usp.append('siteId', siteId)

      return await ky(`faq/items_by_category`, {
        method: 'get',
        searchParams: usp
      }).json()
    }
  }
}
