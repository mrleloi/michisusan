<template>
    <div class="flex items-center">
        <div class="w-1/3">
            <Checkbox class="mr-2" binary v-model="formSettings.activeShadowColor" :inputId="`activeShadowColor-${randomId}`" />
            <label :for="`activeShadowColor-${randomId}`">シャドウ</label>
        </div>
        <div class="w-2/3 flex items-center">
            <ColorPicker class="mr-4" v-model="formSettings.shadowColor" />
            <InputText v-model.trim="formSettings.shadowColor" maxLength="6" class="w-full" />
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
    () => formSettings.value.activeShadowColor,
    () => formSettings.value.shadowColor
], (
    [newValActive, newVal]
) => {
    model.value = newValActive ? `#${newVal} 0px 1px 2px 0px, #${newVal} 0px 2px 6px 2px` : ''
})
</script>

<style scoped>

</style>
