<template>
    <Manage>
        <template #header>
            <slot name="header" />
        </template>


        <template>
            <slot name="navibar">
                <nav class="p-4 z-10 overflow-y-auto bg-white" v-if="isOpened">
                    <NavibarMenu />
                </nav>
            </slot>
        </template>
        <slot />

        <template #footer>
            <FooterMenu />
        </template>
    </Manage>
</template>

<script setup>
import NavibarMenu from '@/components/parts/layouts/manage/NavibarMenu.vue'
import FooterMenu from '@/components/parts/layouts/manage-edit/FooterMenu.vue'
import { storeToRefs } from 'pinia'
import { useNavibarStore } from '@/store/navibar'
import Manage from './Manage.vue'

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
      'f' 45px / 1fr;
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
