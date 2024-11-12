<template>
  <Tabs>
    <TabList :pt="{ tabList: '!bg-transparent' }">
      <Tab
        value="0"
        as="div"
        class="flex items-center gap-4"
        :pt="{ root: '!bg-transparent !text-white' }"
      >
        <i class="pi pi-external-link" />
        <p v-if="windowSize.isDesktop"><a href="/" target="_blank">ホームページを確認する</a></p>
      </Tab>

      <Tab
        value="1"
        as="div"
        class="flex items-center gap-4"
        :pt="{ root: '!bg-transparent !text-white' }"
      >
        <i class="pi pi-sign-out" />
        <p v-if="windowSize.isDesktop"><a href="/admin/logout">ログアウト</a></p>
      </Tab>

      <Tab
        value="2"
        as="div"
        class="flex items-center gap-4"
        :pt="{ root: '!bg-transparent !text-white' }"
      >
        <i class="pi pi-bell" />
      </Tab>

      <Tab
        v-if="!windowSize.isDesktop"
        value="3"
        as="div"
        class="flex items-center gap-4"
        :pt="{ root: '!bg-transparent !text-white' }"
        @click="navibar.toggle()"
      >
        <i class="pi pi-bars" />
      </Tab>
    </TabList>
  </Tabs>
</template>

<script setup>
import Tabs from 'primevue/tabs'
import TabList from 'primevue/tablist'
import Tab from 'primevue/tab'
import { useNavibarStore } from '@/store/navibar'
import { useWindowSizeStore } from '@/store/window-size'

const navibar = useNavibarStore()
const windowSize = useWindowSizeStore()
</script>
