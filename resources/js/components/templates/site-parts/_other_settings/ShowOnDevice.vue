<template>
    <div class="text-sm">
        <p class="font-bold px-4">表示するデバイス</p>
        <div class="px-12 pt-8 flex gap-24">
            <Checkbox binary v-model="attributes.showPCView" :inputId="`showPCView-${randomId}`">PC・タブレット</Checkbox>
            <Checkbox binary v-model="attributes.showSPView" :inputId="`showSPView${randomId}`">スマートフォン</Checkbox>
        </div>
    </div>
</template>

<script setup>
import Checkbox from '@/components/parts/common/Checkbox.vue'
const attributes = defineModel('attributes')
const randomId = Math.random().toString(36).slice(6)
</script>

<style scoped>

</style>
