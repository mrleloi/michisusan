<template>
  <div>
    <InputNumber v-bind="$attrs" v-model="value"></InputNumber>
    <input type="hidden" :name="name" :value="value">
  </div>
</template>

<script setup>
import InputNumber from 'primevue/inputnumber'
import { ref } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  }
})

const value = ref(!props.value ? null : parseInt(props.value) )

</script>
