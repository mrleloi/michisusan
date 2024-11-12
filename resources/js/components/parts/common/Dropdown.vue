<template>
  <Select
    v-model="selected"
    v-bind="$attrs"
    optionLabel="label"
    optionValue="value"
  />
  <input type="hidden" :name="$attrs.name" :value="selected" />
</template>

<script setup>
import { ref, useAttrs } from 'vue'
import Select from 'primevue/select'

const { value, options } = useAttrs()
const selected = ref(value ?? options?.[0].value)
</script>
