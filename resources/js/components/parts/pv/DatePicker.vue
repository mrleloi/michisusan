<template>
    <div>
      <DatePicker v-bind="$attrs" v-model="value" @update:modelValue="onDateSelect"></DatePicker>
      <input type="hidden" :name="name" :value="fValue">
    </div>
  </template>
  
  <script setup>
  import DatePicker from 'primevue/datepicker'
  import { ref, useAttrs } from 'vue'
  import dayjs from "dayjs";
  
  const attrs = useAttrs()
  
  const props = defineProps({
    name: {
      type: String,
      required: true
    },
    value: {
      type: String,
      required: true
    },
    inputDateformat: { // dayjsのフォーマット
      type: String,
      default: 'YYYY-MM-DD'
    }
  })
  
  const value = ref(props.value ?? null)
  const fValue = ref(value.value)

  const onDateSelect = (date) => {
    fValue.value = dayjs(date).format(props.inputDateformat)
  }
  
  </script>
  