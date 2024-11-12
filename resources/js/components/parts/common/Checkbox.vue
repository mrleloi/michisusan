<template>
  <div class="flex gap-2">
    <Checkbox v-bind="$attrs" />
    <label class="cursor-pointer" :for="$attrs.inputId"><slot /></label>
    <input type="hidden" :name="$attrs.name" :value="$attrs.modelValue" />
  </div>
</template>

<script setup>
import Checkbox from 'primevue/checkbox'
</script>
