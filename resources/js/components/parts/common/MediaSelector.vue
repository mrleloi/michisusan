<template>
  <Button class="w-[80px]" size="small" label="メディア" rounded />
  <Checkbox class="flex gap-1" v-bind="$attrs" binary> 削除 </Checkbox>
</template>

<script setup>
import Button from 'primevue/button'
import Checkbox from './Checkbox.vue'
</script>
