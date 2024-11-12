<template>
    <div>
        <p class="font-bold mb-3">
            <slot name="title">
                spサイズ幅
            </slot>
        </p>

        <Select
            v-model="selected"
            class="flex-0 w-48"
            :options="sizesOptions" />
    </div>
</template>

<script setup>
import Select from 'primevue/select'
import { ref, watch } from 'vue'
const model = defineModel('styles')
const selected = ref('40%')

const sizesOptions = [
    '10%', '15%', '20%', '25%', '30%', '35%', '40%', '45%', '50%', '55%',
    '60%', '65%', '70%', '75%', '80%', '85%', '90%', '95%', '100%',
]

watch(selected, (newVal) => {
    model.value['@media (max-width: 768px)'] = newVal
})

</script>

<style scoped>

</style>
