import _ky from 'ky'
export const tagsAPI = (ky, kyTag) => {
    const kyWithoutRetry = ky.extend({
        retry: {
            limit: 0,
        },
    })
    return {
        async changeOrder(payload) {
            return await kyWithoutRetry('tags/order', {
                method: 'put',
                body: JSON.stringify(payload),
            }).json();
        },
    }
}
