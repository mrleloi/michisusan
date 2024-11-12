<template>
    <Checkbox v-bind="$attrs" v-model="value" :binary="true" value="value"></Checkbox>
    <input type="hidden" :name="name" :value="value == '' ? '0' : '1'">
</template>

<script setup>
import Checkbox from 'primevue/checkbox'
import { ref } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  value: {
    type: [Number, String],
    required: true
  }
})

const value = ref(props.value ? true : false)
</script>
