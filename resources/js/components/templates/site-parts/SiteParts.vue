<template>
  <FadeTransition v-model:visible="visible" :transition="transitionType">
    <component
      :is="component"
      v-bind="$attrs"
      v-model:attributes="attributes"
    />
  </FadeTransition>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import Heading from './Heading/Heading.vue'
import ButtonParts from './Button/ButtonParts.vue'
import FadeTransition from '../../parts/transitions/FadeTransition.vue'
import Calendar from './Calendar/Calendar.vue'
import SNSParts from './SNS/SNSParts.vue'
import Text from './Text/Text.vue'
import Image from './image/Image.vue'
import BeforeAfterParts from './BeforeAfter/BeforeAfterParts.vue'
import MenuParts from './Menu/MenuParts.vue'
import StaffMemberParts from './StaffMember/StaffMemberParts.vue'
import GalleryParts from './Gallery/GalleryParts.vue'
import ShopParts from './Shop/ShopParts.vue'
import FaqParts from './Faq/FaqParts.vue'
import RecruitingParts from './recruiting/RecruitingParts.vue'

const props = defineProps({
  name: String
})

const attributes = defineModel('attributes')
const visible = ref(true)

const component = computed(() => {
  switch (props.name) {
    case 'Heading':
      return Heading
    case 'Text':
      return Text
    case 'Button':
      return ButtonParts
    case 'SNS':
      return SNSParts
    case 'Calendar':
      return Calendar
    case 'Image':
      return Image
    case 'BeforeAfter':
      return BeforeAfterParts
    case 'Menu':
      return MenuParts
    case 'StaffMember':
      return StaffMemberParts
    case 'Gallery':
      return GalleryParts
    case 'Shop':
      return ShopParts
    case 'Faq':
      return FaqParts
    case 'Recruiting':
      return RecruitingParts
  }
})

const transitionType = computed(() => {
  return attributes.value.fadein
})

watch(transitionType, value => {
  visible.value = !value

  setTimeout(() => {
    visible.value = true
  })
})
</script>
