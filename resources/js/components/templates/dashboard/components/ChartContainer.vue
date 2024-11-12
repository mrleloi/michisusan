<template>
    <div class="border border-[#dddddd] rounded">
        <div class="flex items-center justify-between p-4 bg-[#F5F5F5] border-b border-[#dddddd] rounded-t">
            <div>
                <i class="fa-solid fa-chart-column text-[#00C5DE] mr-2"></i>
                <span>{{ title }}</span>
            </div>
            <Select
                v-model="previous"
                :options="OPTIONS_PREVIOUS"
                optionLabel="text"
                optionValue="value"
                class="text-[13px] w-32"
                @change="onChangePrevious">
                <template #value="slotProps">
                    <div class="flex items-center">
                        <span class="mr-2">期間:</span>
                        <div>{{ OPTIONS_PREVIOUS.find(option => option.value === slotProps.value)?.text }}</div>
                    </div>
                </template>
                <template #option="slotProps">
                    <div class="flex items-center">
                        <div>{{ slotProps.option.text }}</div>
                    </div>
                </template>
            </Select>
        </div>
        <div class="p-4">
            <slot />
        </div>
        <div class="border-t border-[#dddddd]" v-if="expand">
            <button
                @click="isExpanded = !isExpanded"
                class="w-full p-2 text-center bg-[#F5F5F5]"
            >
                <i class="fas fa-plus" />
            </button>
            <div
                v-if="isExpanded"
                class="p-4 pt-0 text-sm text-[#333333] bg-[#F5F5F5] font-hiragino"
            >
                <slot name="expand-content"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import Select from 'primevue/select'
import { ref } from 'vue'
import { PREVIOUS_DEFAULT, OPTIONS_PREVIOUS } from '@/composables/analytics-consts.js'

defineProps({
    title: {
        type: String,
        required: true
    },
    expand: {
        type: Boolean,
        default: false
    }
})
const emits = defineEmits(['onChangePrevious'])

const previous = ref(PREVIOUS_DEFAULT)
const isExpanded = ref(false)

const onChangePrevious = () => {
    emits('onChangePrevious', previous.value)
}
</script>

<style scoped>

</style>
