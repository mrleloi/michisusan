<template>
    <div class="flex items-center">
        <div class="w-1/3">
            <Checkbox class="mr-2" binary v-model="formSettings.activeBorderRadius" :inputId="`activeBorderRadius-${randomId}`" />
            <label :for="`activeBorderRadius-${randomId}`">角丸</label>
        </div>
        <Select
            v-model="formSettings.borderRadius"
            class="w-2/3"
            optionLabel="label"
            optionValue="value"
            :options="[
                { label: '2px', value: '2px' },
                { label: '4px', value: '4px' },
                { label: '8px', value: '8px' },
                { label: '16px', value: '16px' },
                { label: '32px', value: '32px' },
                { label: '50%', value: '50%' },
            ]"/>
    </div>
</template>

<script setup>
import Select from 'primevue/select'
import Checkbox from 'primevue/checkbox'
import { watch } from 'vue'

const model = defineModel()
const formSettings = defineModel('styleSettings')

const randomId = Math.random().toString(36).slice(6)

watch([
    () => formSettings.value.activeBorderRadius,
    () => formSettings.value.borderRadius
], (
    [newValActive, newVal]
) => {
    model.value = newValActive ? newVal : ''
})
</script>

<style scoped>

</style>
