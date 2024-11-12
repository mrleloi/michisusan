<template>
  <MultiSelect v-bind="$attrs" v-model="value"></MultiSelect>
  <template v-for="v in value" v-bind:key="v">
    <input type="hidden" :name="name" :value="v">
  </template>
</template>

<script setup>
import MultiSelect from 'primevue/multiselect';
import { ref } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  value: {
    type: Array,
  },
})

const value = ref(props.value)

</script>
