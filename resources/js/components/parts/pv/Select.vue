<template>
  <div>
    <Select v-bind="$attrs" v-model="value"></Select>
    <input type="hidden" :name="name" :value="value" />
  </div>
</template>

<script setup>
import Select from 'primevue/select'
import { ref } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
  },
})

const value = ref(props.value)
</script>
