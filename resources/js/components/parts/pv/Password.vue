<template>
    <div>
      <Password v-bind="$attrs" v-model="value"></Password>
      <input type="hidden" :name="name" :value="value">
    </div>
  </template>
  
  <script setup>
  import Password from 'primevue/password'
  import { ref } from 'vue'
  
  const props = defineProps({
    name: {
      type: String,
      required: true
    },
    value: {
      type: String,
      required: true
    }
  })
  
  const value = ref(props.value ?? null)
  
  </script>
  