<template>
  <div class="flex gap-2">
    <RadioButton v-bind="$attrs" />
    <label class="cursor-pointer" :for="$attrs.inputId">
      <slot />
    </label>
  </div>
</template>

<script setup>
import RadioButton from 'primevue/radiobutton'
</script>
