<template>
    <div class="flex gap-5">
        <div class="flex gap-2">
            <Checkbox
                v-model="model.following_part"
                binary
                :input-id="`${prefixName}_show_following_part`" />
            <label :for="`${prefixName}_show_following_part`" class="ml-2">追従SNS</label>
            <input type="hidden" :name="`${prefixName}_show_following_part`" :value="model.following_part ? 1 : 0">
        </div>
        <div class="flex gap-2">
            <Checkbox
                v-model="model.pc_header"
                binary
                :input-id="`${prefixName}_show_pc_header`"
                :name="`${prefixName}_show_pc_header`" />
            <label :for="`${prefixName}_show_pc_header`" class="ml-2">PCヘッダー</label>
            <input type="hidden" :name="`${prefixName}_show_pc_header`" :value="model.pc_header ? 1 : 0">
        </div>
        <div class="flex gap-2">
            <Checkbox
                v-model="model.sp_header"
                binary
                :input-id="`${prefixName}_show_sp_header`"
                :name="`${prefixName}_show_sp_header`" />
            <label :for="`${prefixName}_show_sp_header`" class="ml-2">SPヘッダー (バーガーメニュー外)</label>
            <input type="hidden" :name="`${prefixName}_show_sp_header`" :value="model.sp_header ? 1 : 0">
        </div>
    </div>
</template>

<script setup>
import Checkbox from 'primevue/checkbox'
import { onMounted, ref } from 'vue'

const props = defineProps({
    prefixName: {
        type: String,
        required: true
    },
    dataItem: {
        type: Object,
        required: false
    }
})

const model = ref({
    following_part: true,
    pc_header: true,
    sp_header: true,
})

const setDataModel = () => {
    if (props.dataItem?.length === 0) {
        return
    }

    model.value.following_part = props.dataItem[`${props.prefixName}_show_following_part`] === 1
    model.value.pc_header = props.dataItem[`${props.prefixName}_show_pc_header`] === 1
    model.value.sp_header = props.dataItem[`${props.prefixName}_show_sp_header`] === 1
}

onMounted(() => {
    setDataModel()
})
</script>

<style scoped>

</style>
