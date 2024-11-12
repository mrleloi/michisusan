export const beforeAfterPartsAPI = ky => {
  return {
    async getCategories(siteId = null) {
      return await ky(`before_after/categories`, {
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
      usp.append('allCatgories', allCategories == true ? 1 : 0)

      usp.append('itemCount', itemCount)
      usp.append('siteId', siteId)

      return await ky(`before_after/items_by_category`, {
        method: 'get',
        searchParams: usp
      }).json()
    }
  }
}
