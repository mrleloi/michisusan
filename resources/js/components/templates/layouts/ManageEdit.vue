<template>
  <Manage>
    <template #header>
      <slot name="header" />
    </template>

    <template #navibar>
      <nav class="p-4 z-10 overflow-y-auto bg-white" v-if="isOpened">
        <NavibarMenu />
      </nav>
    </template>

    <template #footer>
      <FooterMenu />
    </template>

    <template #default>
      <slot />
    </template>
  </Manage>
</template>

<script setup>
import { storeToRefs } from 'pinia'
import { useNavibarStore } from '@/store/navibar'
import NavibarMenu from '@/components/parts/layouts/manage/NavibarMenu.vue'
import FooterMenu from '@/components/parts/layouts/manage-edit/FooterMenu.vue'
import Manage from './Manage.vue'

const props = defineProps({
  templates: { type: Object, Required: false }
})

const navibar = useNavibarStore()

const { isOpened } = storeToRefs(navibar)
</script>

<style scoped>
#manage-layout {
  display: grid;
  grid-template:
    'h h' auto
    'n m' 1fr
    'f f' auto / auto 1fr;
}

nav {
  display: none;
}

@media (max-width: 640px) {
  #manage-layout {
    grid-template:
      'h' auto
      'm' 1fr
      'f' auto / 1fr;
  }

  nav {
    display: block;
    position: fixed;
    top: 50px;
    left: 0;
    width: 100vw;
    height: calc(100vh - 96px);
    transition: all 0.2s ease;
  }
}
</style>
