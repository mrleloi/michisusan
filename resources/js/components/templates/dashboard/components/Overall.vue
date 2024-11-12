<template>
    <div class="flex flex-wrap">
        <div class="px-4 w-1/3 mb-8 border-r-[#eeeeee] border-r">
            <span class="text-base font-semibold">
                <i class="fa-solid fa-file"></i>
                PageView
            </span>
            <div class="flex justify-between items-center">
                <span>直近1週間</span>
                <strong class="text-[38px] text-[#4bc0c0] font-bold">{{ overall.oneWeek[0] ?? 0 }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span>直近1ヶ月</span>
                <strong class="text-[38px] text-[#4bc0c0] font-bold opacity-70">{{ overall.oneMonth[0] ?? 0 }}</strong>
            </div>
        </div>

        <div class="px-4 w-1/3 mb-8 border-r-[#eeeeee] border-r">
            <span class="text-base font-semibold">
                <i class="fa-solid fa-user"></i>
                UniqueUser
            </span>
            <div class="flex justify-between items-center">
                <span>直近1週間</span>
                <strong class="text-[38px] text-[#ffbd20] font-bold">{{ overall.oneWeek[1] ?? 0 }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span>直近1ヶ月</span>
                <strong class="text-[38px] text-[#ffbd20] font-bold opacity-70">{{ overall.oneMonth[1] ?? 0 }}</strong>
            </div>
        </div>

        <div class="px-4 w-1/3 mb-8">
            <span class="text-base font-semibold">
                <i class="fa-solid fa-user-plus"></i>
                Session
            </span>
            <div class="flex justify-between items-center">
                <span>直近1週間</span>
                <strong class="text-[38px] text-[#0e82cc] font-bold">{{ overall.oneWeek[2] ?? 0 }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span>直近1ヶ月</span>
                <strong class="text-[38px] text-[#0e82cc] font-bold opacity-70">{{ overall.oneMonth[2] ?? 0 }}</strong>
            </div>
        </div>

        <div class="px-4 w-1/3 border-r-[#eeeeee] border-r">
            <span class="text-base font-semibold">
                <i class="fa-solid fa-arrows-rotate"></i>
                CVR
            </span>
            <div class="flex justify-between items-center">
                <span>直近1週間</span>
                <strong class="text-[38px] text-[#ff6384] font-bold">{{ overall.oneWeek[3] ?? 0 }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span>直近1ヶ月</span>
                <strong class="text-[38px] text-[#ff6384] font-bold opacity-70">{{ overall.oneMonth[3] ?? 0 }}</strong>
            </div>
        </div>

        <div class="px-4 w-1/3 border-r-[#eeeeee] border-r">
            <span class="text-base font-semibold">
                <i class="fa-solid fa-phone"></i>
                TEL CV
            </span>
            <div class="flex justify-between items-center">
                <span>直近1週間</span>
                <strong class="text-[38px] text-[#a485bd] font-bold opacity-70">{{ overall.oneWeek[4] ?? 0 }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span>直近1ヶ月</span>
                <strong class="text-[38px] text-[#a485bd] font-bold opacity-70">{{ overall.oneMonth[4] ?? 0 }}</strong>
            </div>
        </div>

        <div class="px-4 w-1/3">
            <span class="text-base font-semibold">
                <i class="fa-solid fa-desktop"></i>
                WEB CV
            </span>
            <div class="flex justify-between items-center">
                <span>直近1週間</span>
                <strong class="text-[38px] text-[#6ac165] font-bold">{{ overall.oneWeek[5] ?? 0 }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span>直近1ヶ月</span>
                <strong class="text-[38px] text-[#6ac165] font-bold opacity-70">{{ overall.oneMonth[5] ?? 0 }}</strong>
            </div>
        </div>
    </div>
</template>

<script setup>
import { analyticsAPI } from '@/composables/api/analytics'
import { onMounted, ref } from 'vue'

const overall = ref({
    oneWeek: [],
    oneMonth: []
})
const api = analyticsAPI()

const fetchOverallData = async () => {
    const resOneWeek = await api.getReportData(`basic_oneWeek`)
    const resOneMonth = await api.getReportData(`basic_oneMonth`)
    overall.value.oneWeek = resOneWeek.data?.basic_metrics?.rows[0] ?? []
    overall.value.oneMonth = resOneMonth.data?.basic_metrics?.rows[0] ?? []
}

onMounted(() => {
    fetchOverallData()
})
</script>

<style scoped>

</style>
