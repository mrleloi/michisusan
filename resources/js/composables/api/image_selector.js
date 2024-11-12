export const imageSelectorAPI = ky => {
  return {
    async getImage(imageId) {
      return await ky(`image_file/get`, {
        method: 'get',
        searchParams: { id: imageId }
      }).json()
    },
    async getImages(imageFileCategoryId = null, page = 1) {
      return await ky(`image_file/list`, {
        method: 'get',
        searchParams: {
          image_file_category_id: imageFileCategoryId,
          page: page
        }
      }).json()
    },
    async deleteImage(imageId) {
      return await ky(`image_file/delete`, {
        method: 'delete',
        body: JSON.stringify({ id: imageId })
      }).json()
    },
    async uploadImage(formData) {
      const kynh = ky.extend({
        headers: {
          'content-type': undefined
        }
      })

      return await kynh(`image_file/upload`, {
        method: 'post',
        body: formData
      }).json()
    },
    async getCategories() {
      return await ky(`image_file/get_categories`, {
        method: 'get'
      }).json()
    }
  }
}
