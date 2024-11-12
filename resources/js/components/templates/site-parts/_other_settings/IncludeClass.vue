<template>
    <div>
        <p class="font-bold mb-3">class</p>
        <InputText v-model="model" class="w-full"/>
    </div>
</template>

<script setup>
import InputText from 'primevue/inputtext'

const model = defineModel()
</script>

<style scoped>

</style>
