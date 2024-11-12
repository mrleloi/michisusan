import _ky from 'ky'
export const translateAPI = (ky) => {
  return {
    async translate({ ...payload }) {
      return await ky(`translate`, {
        method: 'post',
        body: JSON.stringify(payload)
      }).json()
    }
  }
}
