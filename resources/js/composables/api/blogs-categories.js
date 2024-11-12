import _ky from 'ky'
export const blogsCategoriesAPI = (ky, kyTag) => {
    const kyWithoutRetry = ky.extend({
        retry: {
            limit: 0,
        },
    })
    return {
        async changeOrder(payload) {
            return await kyWithoutRetry('blogs_categories/order', {
                method: 'put',
                body: JSON.stringify(payload),
            }).json();
        },
    }
}
