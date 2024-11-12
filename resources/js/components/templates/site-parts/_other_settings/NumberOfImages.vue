<template>
    <div class="text-sm">
        <p class="font-bold px-4">画像数</p>
        <div class="pl-8 pt-4">
            <Select
                v-model="model"
                class="flex-0 w-48"
                :options="[2, 3, 4, 5]"
            ></Select>
        </div>
    </div>
</template>

<script setup>
import Select from 'primevue/select'

const model = defineModel()
</script>

<style scoped>

</style>
