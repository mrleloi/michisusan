<template>
    <div>
        <p class="font-bold mb-5 px-4">css</p>

        <div class="px-8 mb-8">
            <Textarea v-model="model" rows="5" class="w-full"/>
        </div>
    </div>
</template>

<script setup>
import Textarea from 'primevue/textarea'

const model = defineModel()
</script>

<style scoped>

</style>
