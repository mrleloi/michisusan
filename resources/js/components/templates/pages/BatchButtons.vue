<template>
  <ul class="flex gap-4">
    <li>
      <Button rounded @click="exec('publish')">一括公開</Button>
    </li>
    <li>
      <Button rounded @click="exec('private')">一括非公開</Button>
    </li>
    <li>
      <Button rounded @click="exec('delete')">一括削除</Button>
    </li>
    <slot :exec="exec" />
  </ul>
</template>

<script setup>
import Button from 'primevue/button'
import { usePagesStore } from '@/store/pages'
import { storeToRefs } from 'pinia'
import { useAPI } from '@/composables/api'

const api = useAPI()
const pages = usePagesStore()
const { selected } = storeToRefs(pages)

const exec = async value => {
  if (value) {
    if (value === 'delete') {
      await api.pages.bulkDelete({ ids: selected })
    } else {
      await api.pages.bulkUpdate({
        ids: selected.value,
        isPublic: value == 'publish'
      })
    }
  }
}
</script>
