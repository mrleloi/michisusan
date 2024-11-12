<template>
  <InputText
    ref="inputRef"
    v-bind="$attrs"
    v-on:input="countLength($event.target)"
    :maxlength="maxlength"
  ></InputText>
  <div class="flex justify-end">{{ length }}文字 / {{ maxLength }}文字</div>
</template>

<script setup>
import InputText from 'primevue/inputtext'
import { onMounted, ref, unref } from 'vue'

const props = defineProps({
  maxlength: {
    type: Number,
    required: true
  }
})
const length = ref(0)
const maxLength = ref(props.maxlength)

const inputRef = ref(null)

const countLength = el => {
  length.value = el.value.length
}

onMounted(() => {
  //console.log('onMounted', inputRef.value.$el)
  countLength(inputRef.value.$el)
})
</script>
