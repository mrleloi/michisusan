<template>
  <ColorPicker v-model="picked" v-bind="$attrs" />
  <input type="hidden" :name="$attrs.name" :value="picked" />
</template>

<script setup>
import ColorPicker from 'primevue/colorpicker'
import { ref } from 'vue'

const props = defineProps({
  value: String
})

const picked = ref(props.value)
</script>
