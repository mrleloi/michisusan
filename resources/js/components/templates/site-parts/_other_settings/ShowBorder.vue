<template>
    <div class="flex items-center">
        <div class="w-1/3">
            <Checkbox class="mr-2" binary v-model="formSettings.activeBorderColor" :inputId="`activeBorderColor-${randomId}`" />
            <label :for="`activeBorderColor-${randomId}`">ボーダー</label>
        </div>
        <div class="w-2/3 flex items-center">
            <ColorPicker class="mr-4" v-model="formSettings.borderColor" />
            <InputText v-model.trim="formSettings.borderColor" maxLength="6" class="w-full" />
        </div>
    </div>
</template>

<script setup>
import ColorPicker from 'primevue/colorpicker'
import InputText from 'primevue/inputtext'
import { watch } from 'vue'
import Checkbox from 'primevue/checkbox'

const formSettings = defineModel('styleSettings')
const model = defineModel()

const randomId = Math.random().toString(36).slice(6)

watch([
    () => formSettings.value.activeBorderColor,
    () => formSettings.value.borderColor
], (
    [newValActive, newVal]
) => {
    model.value = newValActive ? '1px solid #' + newVal : ''
})
</script>

<style scoped>

</style>
