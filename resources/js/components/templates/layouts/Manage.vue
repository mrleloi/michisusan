<template>
  <div id="manage-layout" class="w-full h-full">
    <header class="h-full text-white">
      <slot name="header" />
    </header>

    <slot name="navibar">
      <nav class="p-4 z-10 overflow-y-auto bg-white" v-if="isOpened">
        <NavibarMenu />
      </nav>
    </slot>

    <main class="overflow-y-auto main-bg">
      <slot />
    </main>

    <footer class="text-white">
      <slot name="footer" />
    </footer>

    <template v-if="animationEnabled">
      <FadeOutDown>
        <div class="cover" />
      </FadeOutDown>
    </template>
  </div>
</template>

<script setup>
import FadeOutDown from '@/components/parts/transitions/FadeOutDown.vue'
import NavibarMenu from '@/components/parts/layouts/manage/NavibarMenu.vue'
import { storeToRefs } from 'pinia'
import { useNavibarStore } from '@/store/navibar'
import { useWindowSizeStore } from '@/store/window-size'
import { computed, watch } from 'vue'

const navibar = useNavibarStore()
const windowSize = useWindowSizeStore()

const { isOpened } = storeToRefs(navibar)
const { width } = storeToRefs(windowSize)

const animationEnabled = computed(() => {
  const { VITE_MANAGE_ANIMATION } = import.meta.env
  const enabled = VITE_MANAGE_ANIMATION
    ? VITE_MANAGE_ANIMATION.toLowerCase() == 'true'
    : true
  console.log(enabled)
  return enabled
})

watch(width, () => {
  windowSize.openNavibar()
})
</script>

<style scoped>
#manage-layout {
  display: grid;
  grid-template:
    'h h' auto
    'n m' 1fr
    'f f' 45px / 300px 1fr;
}

@media (max-width: 640px) {
  #manage-layout {
    grid-template:
      'h' auto
      'm' 1fr
      'f' 45px / 1fr;
  }

  nav {
    position: fixed;
    top: 50px;
    left: 0;
    width: 100vw;
    height: calc(100vh - 96px);
    transition: all 0.2s ease;
  }
}

header {
  grid-area: h;
  background: #363885;
}

nav {
  grid-area: n;
}

main {
  grid-area: m;
}

footer {
  grid-area: f;
  background: #363885;
}

.cover {
  background: #363885;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: 999999;
}
</style>
