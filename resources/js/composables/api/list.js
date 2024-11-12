export const listAPI = ky => {
  return {
    async changeOrder(listType, from, to) {
      return await ky(`change_order/${listType}`, {
        method: 'put',
        body: JSON.stringify({from, to })
      }).json()
    }
  }
}
