<template>
  <div v-for="option in options" :key="option.key" class="flex">
    <PvRadioButton v-model="selectedItem" :name="name" :value="option.key" />
    <label :for="option.key" class="ml-1">{{ option.label }}</label>
  </div>
  <input type="hidden" :value="selectedItem" />
</template>

<script setup>
import PvRadioButton from 'primevue/radiobutton'
import { ref } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  options: {
    type: Object,
    required: true
  },
  value: {
    type: [String, Number]
  }
})

const selectedItem = ref(props.value)
</script>
