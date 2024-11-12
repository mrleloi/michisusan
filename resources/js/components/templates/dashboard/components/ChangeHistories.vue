<template>
    <div class="p-2.5">
        <div class="rounded border border-[#dddddd]">
            <p class="px-4 py-5 bg-[#f5f5f5] border-b border-[#dddddd]">
                <i class="fa-solid fa-bell text-[#00c5dc] mr-1"></i>
                更新履歴
            </p>

            <div class="p-4">
                <div class="mb-4">
                    <a
                        href="#" v-for="(log, index) in logs.slice(0, 5)" :key="index"
                        :class="`flex items-center justify-between px-4 py-2.5 ${index % 2 === 0 ? 'bg-[#f8f8f8]' : ''} hover:bg-[#f3f3f3]`">
                        <i class="fa-solid fa-comment text-[#00c5dc] mr-1"></i>
                        <span class="w-3/4 text-ellipsis text-nowrap overflow-hidden">{{ log?.page_title }}</span>
                        <span class="ml-auto text-nowrap">{{ log?.diff_time }}</span>
                    </a>
                </div>

                <a href="/admin/change_logs" class="block w-fit px-4 py-2 rounded-full border border-[#adadad] hover:bg-[#e6e6e6] ml-auto">更新履歴一覧</a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { analyticsAPI } from '@/composables/api/analytics'
import { onMounted, ref } from 'vue'

const logs = ref([])
const api = analyticsAPI()

const fetchChangeLogs = async () => {
    const response = await api.getChangeLogsDashboard()
    logs.value = response.data?.change_logs ?? []
}

onMounted(() => {
    fetchChangeLogs()
})
</script>

<style scoped>

</style>
