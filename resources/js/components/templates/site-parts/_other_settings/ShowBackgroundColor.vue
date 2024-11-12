<template>
    <div class="flex items-center">
        <div class="w-1/3">
            <Checkbox class="mr-2" binary v-model="formSettings.activeBackgroundColor" :inputId="`activeBackgroundColor-${randomId}`" />
            <label :for="`activeBackgroundColor-${randomId}`">背景色</label>
        </div>
        <div class="w-2/3 flex items-center">
            <ColorPicker class="mr-10" v-model="formSettings.backgroundColor" />
            <InputText v-model.trim="formSettings.backgroundColor" maxLength="6" class="w-full"/>
        </div>
    </div>
</template>

<script setup>
import Checkbox from 'primevue/checkbox'
import ColorPicker from 'primevue/colorpicker'
import InputText from 'primevue/inputtext'
import { watch } from 'vue'

const model = defineModel()
const formSettings = defineModel('styleSettings')

const randomId = Math.random().toString(36).slice(6)

watch([
    () => formSettings.value.activeBackgroundColor,
    () => formSettings.value.backgroundColor
], (
    [newValActive, newVal]
) => {
    model.value = newValActive ? '#' + newVal : ''
})
</script>

<style scoped>

</style>
