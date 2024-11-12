<template>
    <div class="flex flex-wrap">
        <div class="w-full p-2.5 mb-10">
            <ChartContainer title="地域 (国内)" @on-change-previous="fetchDomesticData">
                <div ref="domesticChartRef" class="flex justify-center"></div>
            </ChartContainer>
        </div>

        <div class="w-full p-2.5 mb-10">
            <ChartContainer title="地域 (市区町村)" @on-change-previous="fetchCityData">
                <div ref="cityChartRef" class="flex justify-center"></div>
            </ChartContainer>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { analyticsAPI } from '@/composables/api/analytics'
import { PREVIOUS_DEFAULT } from '@/composables/analytics-consts.js'
import ChartContainer from './ChartContainer.vue'

const api = analyticsAPI()

const isLoading = ref(true)
const isGoogleLoaded = ref(false)

const domesticChartRef = ref(null)
const cityChartRef = ref(null)

let domesticChart = null
let cityChart = null
let resizeTimeout = null



// Process data for Google Charts TreeMap
const processChartData = (response, type) => {
    if (!response.success) return []

    let rows = []
    switch (type) {
        case 'domestic':
            rows = response.data?.domestics?.rows || []
            break
        case 'city':
            rows = response.data?.citys?.rows || []
            break
    }

    const header = ['Location', 'Parent', 'Market trade volume', 'Market increase/decrease']
    const processedData = [header]
    const headingChart = type === 'domestic' ? '国内' : '市区町村'
    processedData.push([headingChart, null, 0, 0])

    // Process each row
    rows.forEach((row) => {
        const value = parseInt(row[1])
        const label = row[0]
        processedData.push([
            label,
            headingChart,
            value,
            value,
        ])
    })

    return processedData
}

// Create Google Charts options
const createChartOptions = () => ({
    showScale: true,
    minColor: '#EE5555',
    midColor: '#C9CCCB',
    maxColor: '#77CCBB',
    headerHeight: 15,
    maxDepth: 1,
    fontColor: 'black',
    maxPostDepth: 1,
    height: 400,
})

// Create and draw chart
const createChart = (container, data) => {
    if (!isGoogleLoaded.value || !container || !data?.length) {
        console.warn('Dependencies not ready for chart creation')
        return null
    }

    try {
        const options = createChartOptions()
        const chart = new google.visualization.TreeMap(container)
        const dataTable = google.visualization.arrayToDataTable(data)

        // Format labels
        dataTable.setFormattedValue(0, 0, dataTable.getValue(0, 0))
        for (let i = 1; i < dataTable.getNumberOfRows(); i++) {
            const label = dataTable.getValue(i, 0)
            const value = dataTable.getValue(i, 2)
            dataTable.setFormattedValue(i, 0, `${label} (${value})`)
        }

        // Disable selection
        google.visualization.events.addListener(chart, 'select', () => {
            chart.setSelection([])
        })

        if (container.offsetWidth > 0) {
            chart.draw(dataTable, options)
            return chart
        } else {
            console.warn('Container has no width')
            return null
        }
    } catch (error) {
        console.error('Error creating chart:', error)
        return null
    }
}

const fetchDomesticData = async (previous) => {
    try {
        if (!isGoogleLoaded.value) {
            console.warn('Google Charts not loaded yet')
            return
        }
        const response = await api.getReportData(`domestic_graph_${previous}`)
        const data = processChartData(response, 'domestic')
        if (data?.length && domesticChartRef.value) {
            domesticChart = createChart(domesticChartRef.value, data)
        }
    } catch (error) {
        console.error('Error fetching domestic data:', error)
    }
}

const fetchCityData = async (previous) => {
    try {
        if (!isGoogleLoaded.value) {
            console.warn('Google Charts not loaded yet')
            return
        }
        const response = await api.getReportData(`city_graph_${previous}`)
        const data = processChartData(response, 'city')
        if (data?.length && cityChartRef.value) {
            cityChart = createChart(cityChartRef.value, data)
        }
    } catch (error) {
        console.error('Error fetching city data:', error)
    }
}

const handleResize = () => {
    if (!isGoogleLoaded.value) return

    // Debounce resize handler
    if (resizeTimeout) clearTimeout(resizeTimeout)
    resizeTimeout = setTimeout(() => {
        if (domesticChart && domesticChartRef.value) {
            domesticChart.draw(domesticChart.getDataTable(), createChartOptions())
        }
        if (cityChart && cityChartRef.value) {
            cityChart.draw(cityChart.getDataTable(), createChartOptions())
        }
    }, 250)
}

const loadGoogleCharts = () => {
    return new Promise((resolve, reject) => {
        try {
            if (window.google && window.google.visualization) {
                isGoogleLoaded.value = true
                resolve()
                return
            }

            if (!window.google) {
                reject(new Error('Google Charts not found'))
                return
            }

            google.charts.load('current', { 'packages': ['treemap'] })
            google.charts.setOnLoadCallback(() => {
                isGoogleLoaded.value = true
                resolve()
            })
        } catch (error) {
            reject(error)
        }
    })
}

const initCharts = async () => {
    isLoading.value = true
    try {
        if (!window.google) {
            const script = document.createElement('script')
            script.src = 'https://www.gstatic.com/charts/loader.js'
            script.async = true
            await new Promise((resolve, reject) => {
                script.onload = resolve
                script.onerror = reject
                document.head.appendChild(script)
            })
        }

        await loadGoogleCharts()

        // Wait DOM to complete
        await nextTick()

        if (domesticChartRef.value && cityChartRef.value) {
            await Promise.all([
                fetchDomesticData(PREVIOUS_DEFAULT),
                fetchCityData(PREVIOUS_DEFAULT)
            ])
        }
    } catch (error) {
        console.error('Error initializing charts:', error)
    } finally {
        isLoading.value = false
    }
}

onMounted(() => {
    initCharts()
    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    if (resizeTimeout) clearTimeout(resizeTimeout)
    window.removeEventListener('resize', handleResize)
})
</script>

<style scoped>
/* Add any custom styles here */
</style>
