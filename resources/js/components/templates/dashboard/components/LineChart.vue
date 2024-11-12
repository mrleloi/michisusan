<template>
    <div class="flex flex-wrap">
        <div class="w-full p-2.5 mb-10">
            <ChartContainer
                title="検索キーワード"
                @on-change-previous="fetchSearchConsoleData"
                :expand="true">
                <div ref="cvrChartRef" class="flex justify-center"></div>
                <template v-slot:expand-content>
                    <p>
                        閲覧する人がサイトに訪れてからそのサイトを閉じるまでの動作を「1セッション」といいます。<br>
                        CVR（コンバージョン率）とは、サイトを訪ずれた人が"購入"や"申し込み"などの目標にどれくらい至っているかを示す指標です。<br>
                        セッション動向とCVR動向はサイトを変更追加した際に大きく変化が出やすいです。大きな変化があった時は閲覧者が求めている情報を載せた可能性が高いですので、同じように追加していきましょう。
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
const cvrChartRef = ref(null)
let cvrChart = null

const processChartData = (response) => {
    if (!response.success) return []

    const rows = response.data?.cvr?.rows || []
    const data = [['Date', 'コンバージョン数', 'セッション数', 'ページビュー数', 'ユーザ数', '操作履歴']]

    rows.forEach(row => {
        data.push([
            row[0],              // Date
            parseInt(row[1]),    // コンバージョン数
            parseInt(row[2]),    // セッション数
            parseInt(row[3]),    // ページビュー数
            parseInt(row[4]),    // ユーザ数
            parseInt(row[5] || 0) // 操作履歴
        ])
    })

    return data
}

const createChartOptions = () => ({
    height: 450,
    chartArea: {
        width: '90%',
        height: '75%'
    },
    legend: {
        position: 'top',
        alignment: 'center',
        maxLines: 1,
        textStyle: {
            fontSize: 12
        }
    },
    series: {
        0: { // コンバージョン数
            type: 'line',
            color: '#FF6384',
            lineWidth: 2,
            curveType: 'function'
        },
        1: { // セッション数
            type: 'line',
            color: '#36A2EB',
            lineWidth: 2,
            curveType: 'function'
        },
        2: { // ページビュー数
            type: 'line',
            color: '#4BC0C0',
            lineWidth: 2,
            curveType: 'function'
        },
        3: { // ユーザ数
            type: 'line',
            color: '#FFCD56',
            lineWidth: 2,
            curveType: 'function'
        },
        4: { // 操作履歴
            type: 'line',
            color: '#FF9F40',
            lineWidth: 2,
            curveType: 'function'
        }
    },
    curveType: 'function',
    hAxis: {
        gridlines: {
            color: '#f3f3f3',
            count: -1
        },
        textStyle: {
            fontSize: 11
        }
    },
    vAxis: {
        gridlines: {
            color: '#f3f3f3'
        },
        textStyle: {
            fontSize: 11
        },
        viewWindow: {
            min: 0
        },
    },
    pointSize: 4,
    explorer: {
        actions: ['dragToZoom', 'rightClickToReset'],
        axis: 'horizontal',
        keepInBounds: true,
        maxZoomIn: 4.0
    },
    interpolateNulls: true,
    tooltip: {
        trigger: 'focus',
        isHtml: true,
        showColorCode: true,
    },
    focusTarget: 'category',
})

const createChart = (container, data) => {
    const options = createChartOptions();
    const chart = new google.visualization.ComboChart(container);
    const dataTable = google.visualization.arrayToDataTable(data);

    // Add event listeners for hover
    google.visualization.events.addListener(chart, 'onmouseover', (e) => {
        const tooltip = container.querySelector('.google-visualization-tooltip');
        if (tooltip) {
            tooltip.style.opacity = '1';
            tooltip.style.visibility = 'visible';

            // Điều chỉnh vị trí tooltip
            const chartArea = chart.getChartLayoutInterface().getChartAreaBoundingBox();
            const x = e.x + chartArea.left;
            const y = e.y + chartArea.top;

            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
        }
    });

    google.visualization.events.addListener(chart, 'onmouseout', (e) => {
        const tooltip = container.querySelector('.google-visualization-tooltip');
        if (tooltip) {
            tooltip.style.opacity = '0';
            tooltip.style.visibility = 'hidden';
        }
    });

    // Add mousemove event để tooltip follow chuột
    container.addEventListener('mousemove', (e) => {
        const tooltip = container.querySelector('.google-visualization-tooltip');
        if (tooltip && tooltip.style.visibility === 'visible') {
            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left + 10;
            const y = e.clientY - rect.top + 10;

            // Giới hạn tooltip trong container
            const maxX = container.offsetWidth - tooltip.offsetWidth;
            const maxY = container.offsetHeight - tooltip.offsetHeight;

            tooltip.style.left = Math.min(Math.max(0, x), maxX) + 'px';
            tooltip.style.top = Math.min(Math.max(0, y), maxY) + 'px';
        }
    });

    chart.draw(dataTable, options);
    return chart;
}

const fetchSearchConsoleData = async (previous) => {
    try {
        const response = await api.getReportData(`cvr_graph_${previous}`)
        const data = processChartData(response)
        if (data.length > 0) {
            cvrChart = createChart(cvrChartRef.value, data)
        }
    } catch (error) {
        console.error('Error fetching data:', error)
    }
}

const handleResize = () => {
    if (cvrChart && cvrChartRef.value) {
        cvrChart.draw(cvrChart.getDataTable(), createChartOptions())
    }
}

onMounted(() => {
    const loadGoogleCharts = () => {
        return new Promise((resolve) => {
            if (window.google && window.google.visualization) {
                resolve()
                return
            }
            google.charts.load('current', { 'packages': ['corechart'] })
            google.charts.setOnLoadCallback(resolve)
        })
    }

    const initChart = async () => {
        if (!window.google) {
            const script = document.createElement('script')
            script.src = 'https://www.gstatic.com/charts/loader.js'
            script.async = true
            await new Promise(resolve => {
                script.onload = resolve
                document.head.appendChild(script)
            })
        }

        await loadGoogleCharts()
        await fetchSearchConsoleData(PREVIOUS_DEFAULT)
    }

    initChart()
    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
})
</script>

<style scoped>
:deep(.google-visualization-tooltip) {
    border: 1px solid #E0E0E0;
    border-radius: 4px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 6px;
}
:deep(.google-visualization-tooltip-list) {
    margin: 0 !important;
    padding: 0 !important;
}
:deep(.google-visualization-tooltip-item) {
    margin: 0 !important;
    padding: 0 !important;
    text-wrap: nowrap !important;
}
:deep(.google-visualization-tooltip-item:first-child) {
    padding: 4px !important;
    text-align: center !important;
    background: #00c5dc !important;
}
:deep(.google-visualization-tooltip-item span) {
    color: white !important;
    font-size: 14px !important;
}
:deep(.google-visualization-tooltip-item div) {
    margin: 0 10px 0 0 !important;
    width: 10px !important;
    height: 10px !important;
}
</style>
