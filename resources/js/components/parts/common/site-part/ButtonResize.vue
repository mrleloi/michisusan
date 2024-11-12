<template>
    <div :class="containerClass">
        <Slider
            v-model="value"
            class="w-full"
            :max="max" :min="min"
            @slideend="change"
            unstyled
            :pt="{
                handle: {
                    class: 'custom-slider-handle'
                }
            }"
        />
    </div>
</template>

<script setup>
import Slider from 'primevue/slider'
import { ref } from 'vue'

defineProps({
    max: { type: Number, default: 100 },
    min: { type: Number, default: 15 },
    containerClass: { type: String, default: '' },
})

const model = defineModel()
const modelSetting = defineModel('styleSettings')
const value = ref(modelSetting.value)

const change = () => {
    modelSetting.value = value.value
    model.value = value.value + '%'
}
</script>

<style scoped>
:deep(.custom-slider-handle) {
    background: #ffaa00;
    width: 2rem;
    height: 2rem;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
}

:deep(.custom-slider-handle:hover) {
    opacity: .8;
    cursor: col-resize;
}

:deep(.custom-slider-handle:before) {
    content: '\e972';
    font-family: 'primeicons';
    padding-top: .25rem;
    padding-right: .25rem;
    border: 1px dotted #ffffff;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    display: block;
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}
</style>
