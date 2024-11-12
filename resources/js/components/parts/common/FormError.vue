<template>
  <ul :class="`text-red-500 ${errorKey}-errors`">
    <li v-for="error in errors[errorKey]" class="error">
      {{ error }}
    </li>
  </ul>
</template>

<script setup>
const props = defineProps({
  errors: {
    type: Object,
    required: true,
    default: {}
  },
  errorKey: {
    type: String,
    required: true,
    default: ''
  }
})
</script>
