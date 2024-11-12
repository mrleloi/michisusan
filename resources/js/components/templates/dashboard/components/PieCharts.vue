<template>
    <div class="flex flex-wrap">
        <div class="w-1/2 p-2.5 mb-10">
            <ChartContainer title="集客経路" :expand="true" @on-change-previous="fetchPathData">
                <div ref="pathChartRef" class="flex justify-center"></div>
                <template #expand-content>
                    <p>
                        どういう経路でサイトにたどり着いたかを示します。
                        <br>
                        Google、Yahoo、Bingなどいと検索エンジンから検索での流入が多いことを意味します。
                        <br>
                        検索エンジン、ソーシャルメディア、他のサイトなどをバランスよく伸ばしていきましょう。
                    </p>
                </template>
            </ChartContainer>
        </div>

        <div class="w-1/2 p-2.5 mb-10">
            <ChartContainer title="端末別アクセス数" :expand="true" @on-change-previous="fetchBrowserData">
                <div ref="browserChartRef" class="flex justify-center"></div>
                <template #expand-content>
                    <p>
                        サイトに訪れてくれた方がどんな端末で見たのかがわかります。傾向に合わせた戦略を立てていきましょう。
                    </p>
                </template>
            </ChartContainer>
        </div>

        <div class="w-1/2 p-2.5 mb-10">
            <ChartContainer title="ブラウザ別" @on-change-previous="fetchDeviceData">
                <div ref="deviceChartRef" class="flex justify-center"></div>
            </ChartContainer>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { analyticsAPI } from '@/composables/api/analytics'
import { DEFAULT_COLORS, OTHER_COLOR, PREVIOUS_DEFAULT } from '@/composables/analytics-consts.js'
import ChartContainer from './ChartContainer.vue'

const api = analyticsAPI()

const pathChartRef = ref(null)
const browserChartRef = ref(null)
const deviceChartRef = ref(null)

let pathChart = null
let browserChart = null
let deviceChart = null

const defaultColors = [...DEFAULT_COLORS]

// Process data for Google Charts
const processChartData = (response, type) => {
    if (!response.success) return []

    let rows = []
    switch (type) {
        case 'browser':
            rows = response.data?.browser?.browser?.rows || []
            break
        case 'path':
            rows = response.data?.paths?.rows || []
            break
        case 'device':
            rows = response.data?.devices?.rows || []
            break
    }

    return [['Label', 'Value'], ...rows.map(row => {
        let label = row[0]
        if (type === 'device') {
            label = label.charAt(0).toUpperCase() + label.slice(1)
        }
        return [label, parseInt(row[1])]
    })]
}

// Create Google Charts options
const createChartOptions = () => ({
    height: 200,
    pieSliceText: 'percentage',
    pieStartAngle: 100,
    chartArea: {
        width: '70%',
        height: '90%'
    },
    legend: {
        position: 'right',
        textStyle: {
            fontSize: 12
        }
    },
    colors: defaultColors,
    tooltip: {
        text: 'percentage',
    },
    slices: {}
})

// Create and draw chart
const createChart = (container, data) => {
    const options = createChartOptions()

    // Set color for 'Other' slice
    const otherIndex = data.findIndex(row => row[0] === 'Other')
    if (otherIndex > 0) {
        options.slices[otherIndex - 1] = { color: OTHER_COLOR }
    }

    const chart = new google.visualization.PieChart(container)
    const dataTable = google.visualization.arrayToDataTable(data)
    chart.draw(dataTable, options)
    return chart
}

const fetchPathData = async (previous) => {
    const response = await api.getReportData(`path_graph_${previous}`)
    const data = processChartData(response, 'path')
    pathChart = createChart(pathChartRef.value, data)
}

const fetchBrowserData = async (previous) => {
    const response = await api.getReportData(`browser_graph_${previous}`)
    const data = processChartData(response, 'browser')
    browserChart = createChart(browserChartRef.value, data)
}

const fetchDeviceData = async (previous) => {
    const response = await api.getReportData(`device_graph_${previous}`)
    const data = processChartData(response, 'device')
    deviceChart = createChart(deviceChartRef.value, data)
}

// Handle window resize
const handleResize = () => {
    if (pathChart) pathChart.draw(pathChart.getDataTable(), createChartOptions())
    if (browserChart) browserChart.draw(browserChart.getDataTable(), createChartOptions())
    if (deviceChart) deviceChart.draw(deviceChart.getDataTable(), createChartOptions())
}

onMounted(() => {
    // Load Google Charts
    if (!window.google) {
        const script = document.createElement('script')
        script.src = 'https://www.gstatic.com/charts/loader.js'
        script.async = true
        script.onload = () => {
            google.charts.load('current', { 'packages': ['corechart'] })
            google.charts.setOnLoadCallback(() => {
                fetchPathData(PREVIOUS_DEFAULT)
                fetchBrowserData(PREVIOUS_DEFAULT)
                fetchDeviceData(PREVIOUS_DEFAULT)
            })
        }
        document.head.appendChild(script)
    } else {
        google.charts.load('current', { 'packages': ['corechart'] })
        google.charts.setOnLoadCallback(() => {
            fetchPathData(PREVIOUS_DEFAULT)
            fetchBrowserData(PREVIOUS_DEFAULT)
            fetchDeviceData(PREVIOUS_DEFAULT)
        })
    }

    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
})
</script>

<style scoped>
:deep(.p-select-label) {
    padding: 7px 15px;
}

:deep(.p-select) {
    border-radius: 999px;
}
</style>
