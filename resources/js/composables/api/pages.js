export const pagesAPI = ky => {
  return {
    async fetch() {
      return await ky(`pages`, {
        method: 'get'
      }).json()
    },
    async create({ ...payload }) {
      return await ky(`pages`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    },
    async update({ id, payload }) {
      return await ky(`pages/${id}`, {
        method: 'put',
        body: JSON.stringify(payload)
      }).json()
    },
    async updatePageIdByPages({ ...payload }) {
      return await ky(`pages/`, {
        method: 'put',
        body: JSON.stringify(payload)
      }).json()
    },
    async delete({ id }) {
      return await ky(`pages/${id}`, {
        method: 'delete'
      }).json()
    },
    async bulkDelete({ ...payload }) {
      return await ky(`pages/`, {
        method: 'delete',
        body: JSON.stringify(payload)
      }).json()
    }
  }
}
