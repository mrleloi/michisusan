import _ky from 'ky'

export const analyticsAPI = (ky = _ky) => {
    return {
        async getReportData(mode) {
            return await ky.post(`/api/google-analytics/report-data`, {
                json: {
                    mode: mode
                },
                headers: {
                    'Content-Type': 'application/json'
                }
            }).json()
        },

        async getSearchConsoleData(mode) {
            return await ky.post(`/api/google-analytics/search-console`, {
                json: {
                    mode: mode
                },
                headers: {
                    'Content-Type': 'application/json'
                }
            }).json()
        },

        async getChangeLogsDashboard() {
            return await ky.post('/api/change_logs', {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).json()
        }
    }
}
