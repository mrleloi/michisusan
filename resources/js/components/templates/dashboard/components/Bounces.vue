<template>
    <div class="grid grid-cols-4 gap-4 mb-10">
        <div class="bounce-item-box">
            <div class="bounce-item-heading">直近1週間直帰数</div>
            <p class="bounce-item-content">{{ bounces[0] ?? 0 }}</p>
        </div>
        <div class="bounce-item-box">
            <div class="bounce-item-heading">直近1ヶ月直帰数</div>
            <p class="bounce-item-content">{{ bounces[1] ?? 0 }}</p>
        </div>
        <div class="bounce-item-box">
            <div class="bounce-item-heading">直近1週間直帰率</div>
            <p class="bounce-item-content">{{ bounces[2] ?? 0 }}</p>
        </div>
        <div class="bounce-item-box">
            <div class="bounce-item-heading">直近1ヶ月直帰率</div>
            <p class="bounce-item-content">{{ bounces[3] ?? 0 }}</p>
        </div>
        <div class="bounce-item-box">
            <div class="bounce-item-heading">直近1週間新規ユーザー数</div>
            <p class="bounce-item-content">{{ bounces[4] ?? 0 }}</p>
        </div>
        <div class="bounce-item-box">
            <div class="bounce-item-heading">直近1ヶ月新規ユーザー数</div>
            <p class="bounce-item-content">{{ bounces[5] ?? 0 }}</p>
        </div>
        <div class="bounce-item-box">
            <div class="bounce-item-heading">直近1週間リピーター数</div>
            <p class="bounce-item-content">{{ bounces[6] ?? 0 }}</p>
        </div>
        <div class="bounce-item-box">
            <div class="bounce-item-heading">直近1ヶ月リピーター数</div>
            <p class="bounce-item-content">{{ bounces[7] ?? 0 }}</p>
        </div>
    </div>
</template>

<script setup>
import { analyticsAPI } from '@/composables/api/analytics'
import { onMounted, ref } from 'vue'

const bounces = ref([])
const api = analyticsAPI()

const fetchBouncesData = async () => {
    const response = await api.getReportData(`bounces`)
    bounces.value = response.data?.bounces?.rows[0] ?? []
}

onMounted(() => {
    fetchBouncesData()
})
</script>

<style scoped>
.bounce-item-box {
    border: 1px solid #EFAA56;
    border-radius: .25rem;
    text-align: center;
}

.bounce-item-heading {
    background-color: #EFAA56;
    color: white;
    text-align: left;
    padding: .5rem;
    font-weight: bold;
    border-bottom: 1px solid #EFAA56;
}

.bounce-item-content {
    padding: 1rem;
}
</style>
