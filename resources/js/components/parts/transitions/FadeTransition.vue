<template>
  <Transition
    :enter-active-class="transition.enterActiveClass"
    :leave-active-class="transition.leaveActiveClass"
  >
    <slot v-if="visible" />
  </Transition>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  transition: String
})

const visible = defineModel('visible')

const transition = computed(() => {
  switch (props.transition) {
    case 'up':
      return {
        enterActiveClass: 'animate__animated animate__fadeInUp',
        leaveActiveClass: 'animate__animated animate__fadeOutDown'
      }
    case 'left':
      return {
        enterActiveClass: 'animate__animated animate__fadeInLeft',
        leaveActiveClass: 'animate__animated animate__fadeOutLeft'
      }
    case 'right':
      return {
        enterActiveClass: 'animate__animated animate__fadeInRight',
        leaveActiveClass: 'animate__animated animate__fadeOutRight'
      }
    case 'down':
      return {
        enterActiveClass: 'animate__animated animate__fadeInDown',
        leaveActiveClass: 'animate__animated animate__fadeOutUp'
      }
    default:
      return {
        enterActiveClass: '',
        leaveActiveClass: ''
      }
  }
})
</script>
