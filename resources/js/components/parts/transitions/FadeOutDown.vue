<template>
  <Transition
    enter-active-class="animate__animated animate__fadeIn"
    leave-active-class="animate__animated animate__fadeOut"
  >
    <div v-if="fadeout" class="cover" />
  </Transition>

  <Transition
    enter-active-class="animate__animated animate__slideInUp"
    leave-active-class="animate__animated animate__slideOutDown"
  >
    <slot v-if="slidedown" />
  </Transition>
</template>

<script setup>
import { onMounted, ref } from 'vue'

const slidedown = ref(true)
const fadeout = ref(true)

onMounted(async () => {
  const wait = async (callback, ms) =>
    new Promise(executor => {
      setTimeout(() => {
        callback()
        executor()
      }, ms)
    })
  slidedown.value = false
  await wait(() => {
    fadeout.value = false
  }, 750)
})
</script>

<style scoped>
.cover {
  background: white;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: 999998;
}
</style>
