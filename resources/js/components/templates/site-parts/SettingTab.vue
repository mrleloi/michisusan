<template>
  <div class="flex-1 flex flex-col">
    <div class="flex-1 pt-4 overflow-y-auto">
      <slot />
    </div>

    <div class="flex items-center gap-4 bg-white py-4 border-t">
      <div class="flex-1 flex items-center justify-center gap-4">
        <template v-if="tab === ''">
          <Button
            label="その他設定へ"
            class="w-[114px]"
            size="small"
            @click="tab = 'setting'"
          />
        </template>

        <template v-else>
          <Button
            label="デザイン設定へ"
            class="w-[114px]"
            size="small"
            @click="tab = ''"
          />
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import Button from 'primevue/button'
import { onUnmounted } from 'vue'
import { usePartsSettingStore } from '../../../store/parts-setting'
import { storeToRefs } from 'pinia'

const store = usePartsSettingStore()
const { tab } = storeToRefs(store)

onUnmounted(() => {
  store.$reset()
})
</script>
