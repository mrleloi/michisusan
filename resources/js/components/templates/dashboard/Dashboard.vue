<template>
    <div>
        <h1 class="text-base font-bold">【デモ】AppDate Holdings様 専用管理画面</h1>

        <!-- Overall analytics -->
        <div class="px-4 mt-8">
            <Overall />
        </div>

        <!-- Charts -->
        <div class="flex mt-8">
            <div class="w-2/3">
                <LineChart />
                <PieCharts />
                <TreeMapCharts />
                <Bounces />
                <TableChart />

                <div class="p-2.5 ">
                    <div class="rounded border border-[#f5f5f5] mb-10">
                        <p class="p-4 bg-[#f5f5f5]">お客様サポート</p>
                        <div class="p-4">
                            <table class="w-full">
                                <tr class="border-t border-[#f5f5f5] hover:bg-[#f5f5f5]">
                                    <th class="p-2 text-left">電話番号</th>
                                    <td class="p-2 text-left">050-5433-5878</td>
                                </tr>
                                <tr class="border-t border-[#f5f5f5] hover:bg-[#f5f5f5]">
                                    <th class="p-2 text-left">電話受付時間</th>
                                    <td class="p-2 text-left">9:00〜18:00（年末年始、土日祝、弊社休業日除く）</td>
                                </tr>
                                <tr class="border-t border-[#f5f5f5] hover:bg-[#f5f5f5]">
                                    <th class="p-2 text-left">メールアドレス</th>
                                    <td class="p-2 text-left">
                                        <a href="mailto:support@app-web.jp" class="text-[#5867c3] hover:underline hover:text-[#23527c]">support@app-web.jp</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/3">
                <ChangeHistories />
            </div>
        </div>
    </div>
</template>

<script setup>
import LineChart from './components/LineChart.vue'
import PieCharts from './components/PieCharts.vue'
import TreeMapCharts from './components/TreeMapCharts.vue'
import Overall from './components/Overall.vue'
import Bounces from './components/Bounces.vue'
import ChangeHistories from './components/ChangeHistories.vue'
import TableChart from './components/TableChart.vue'
</script>

<style scoped>

</style>
