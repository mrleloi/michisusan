import _ky from 'ky'
export const newsArticlesAPI = (ky, kyTag) => {
    return {
    /*async fetch() {
      return await ky(`news_articles`, {
        method: 'get'
      }).json()
    },
    async create({ ...payload }) {
      return await ky(`news_articles`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    },
    async update({ id, ...payload }) {
      return await ky(`news_articles/${id}`, {
        method: 'put',
        body: JSON.stringify(payload)
      }).json()
    },
    async bulkUpdate({ ...payload }) {
      return await ky(`news_articles/`, {
        method: 'put',
        body: JSON.stringify(payload)
      }).json()
    },*/
    /*async delete(id) {
      return await ky(`news_articles/${id}`, {
        method: 'delete'
      }).json()
    },*/
    async translate({...payload}) {
        return await ky(`news_articles/translate`, {
            method: 'post',
            body: JSON.stringify(payload)
        }).json()
    },
    async getTags(tags) {
        return await _ky(`https://tools.create-support.info/suggest.php?q=${tags}`, {}).json()
    },

    /*async bulkDelete({ ...payload }) {
      return await ky(`news_articles/`, {
        method: 'delete',
        body: JSON.stringify(payload)
      }).json()
    }*/
  }
}
