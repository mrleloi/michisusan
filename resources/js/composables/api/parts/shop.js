export const shopPartsAPI = ky => {
  return {
    async getItems(siteId = '') {
      const usp = new URLSearchParams()
      usp.append('siteId', siteId)

      return await ky(`shop/items`, {
        method: 'get',
        searchParams: usp
      }).json()
    },
    async getItem(shopItemId, siteId = '') {
      const usp = new URLSearchParams()
      usp.append('shopItemId', shopItemId)
      usp.append('siteId', siteId)

      return await ky(`shop/item`, {
        method: 'get',
        searchParams: usp
      }).json()
    }

  }
}
