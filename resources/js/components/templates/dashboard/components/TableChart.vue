<template>
    <div class="flex flex-wrap">
        <div class="w-full p-2.5 mb-10">
            <ChartContainer
                title="検索キーワード"
                @on-change-previous="fetchSearchConsoleData"
                :expand="true">
                <div ref="searchConsoleChartRef" class="flex justify-center"></div>
                <template v-slot:expand-content>
                    <p>
                        Googleの検索結果にサイトが表示された数や、その平均検索順位、クリック数が表示されています。<br>
                        順位が低めでクリックされた数が多い場合には順位向上によるアクセス増加が期待できますので、そのキーワードを主としたページの構築をしてみましょう。
                    </p>
                </template>
            </ChartContainer>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { analyticsAPI } from '@/composables/api/analytics'
import { PREVIOUS_DEFAULT } from '@/composables/analytics-consts.js'
import ChartContainer from './ChartContainer.vue'

const api = analyticsAPI()

const searchConsoleChartRef = ref(null)

let searchConsoleChart = null

// Process data for Google Charts TreeMap
const processChartData = (response) => {
    if (!response.success) return []

    let rows = response.data?.keywords.rows

    const header = ['検索キーワード', 'クリック数', '表示回数', 'クリック率', '掲載順位']
    const processedData = [header]

    return processedData.concat(rows)
}

// Create Google Charts options
const createChartOptions = () => ({
    width: '100%',
    sort: {
        enable: true
    },
    cssClassNames: {
        headerRow: 'custom-header-row',
        tableRow: 'custom-table-row',
        oddTableRow: 'custom-odd-table-row',
    }
})

// Create and draw chart
const createChart = (container, data) => {
    const options = createChartOptions()
    const chart = new google.visualization.Table(container)
    const dataTable = google.visualization.arrayToDataTable(data)

    chart.draw(dataTable, options)
    return chart
}

const fetchSearchConsoleData = async (previous) => {
    const response = await api.getSearchConsoleData(previous)
    const data = processChartData(response)
    searchConsoleChart = createChart(searchConsoleChartRef.value, data)
}

const handleResize = () => {
    if (searchConsoleChart) searchConsoleChart.draw(searchConsoleChart.getDataTable(), createChartOptions())
}

onMounted(() => {
    // Load Google Charts
    if (!window.google) {
        const script = document.createElement('script')
        script.src = 'https://www.gstatic.com/charts/loader.js'
        script.async = true
        script.onload = () => {
            google.charts.load('current', { 'packages': ['table'] })
            google.charts.setOnLoadCallback(() => {
                fetchSearchConsoleData(PREVIOUS_DEFAULT)
            })
        }
        document.head.appendChild(script)
    } else {
        google.charts.load('current', { 'packages': ['table'] })
        google.charts.setOnLoadCallback(() => {
            fetchSearchConsoleData(PREVIOUS_DEFAULT)
        })
    }

    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
})
</script>

<style scoped>
:deep(.custom-header-row) {
    background-color: #00c5dc;
    color: white;
}
:deep(.custom-header-row th) {
    padding: .5rem;
    background-image: none;
}
:deep(.custom-table-row td) {
    padding: 5px;
}
:deep(.custom-odd-table-row td) {
    background: #f9f9f9;
    padding: 5px;
}
:deep(.custom-table-row td:nth-child(4):after),
:deep(.custom-odd-table-row td:nth-child(4):after) {
    content: '%'
}
:deep(.custom-table-row:hover),
:deep(.custom-odd-table-row:hover) {
    background: #f5f5f5;
}
</style>
