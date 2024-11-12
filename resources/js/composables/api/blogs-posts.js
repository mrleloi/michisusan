import _ky from 'ky'
export const blogsPostsAPI = (ky, kyTag) => {
    return {
    async translate({...payload}) {
        return await ky(`blogs_posts/translate`, {
            method: 'post',
            body: JSON.stringify(payload)
        }).json()
    },
    async getTags(tags) {
        return await _ky(`https://tools.create-support.info/suggest.php?q=${tags}`, {}).json()
    },
  }
}
