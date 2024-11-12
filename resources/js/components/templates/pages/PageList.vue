<template>
  <Draggable
    v-model="pageTree"
    class="pl-0 p-4"
    :eachDroppable="eachDroppable"
    @after-drop="onUpdatePages"
  >
    <template #default="{ node, stat }">
      <div class="flex justify-between items-center py-2 gap-4">
        <Checkbox v-if="true" v-model="selected" :value="node.id" />
        <div v-else class="w-6 h-6" />

        <div
          class="flex-1 flex justify-between items-center pr-4 rounded-md bg-[#f5f5f5]"
        >
          <div class="flex items-center">
            <template v-if="true">
              <div
                class="h-16 w-10 flex justify-center items-center rounded-l-md cursor-move bg-[#b3b3b3]"
              >
                <i class="pi pi-bars" />
              </div>
            </template>
            <template v-else>
              <div class="h-16 w-10" />
            </template>

            <p class="font-bold pl-4">
              <a
                class="mr-1"
                :href="node.directory"
                target="_blank"
                :style="{ color: $dt('primary.700').value }"
                >{{ node.title }}</a
              >: {{ node.directory }} <br />{{ node.description }}
            </p>
          </div>

          <div class="flex gap-4">
            <slot name="buttons">
              <Button
                icon="pi pi-file-edit btn-icon"
                text
                :pt:icon:style="{ color: $dt('primary.700').value }"
                @click="onEdit(node)"
              />
              <Button
                icon="pi pi-cog"
                text
                :pt:icon:style="{ color: $dt('primary.700').value }"
              />
              <Button
                icon="pi pi-trash"
                text
                :pt:icon:style="{ color: $dt('primary.700').value }"
                @click="onDelete(node)"
              />
              <Button
                rounded
                class="!border-transparent !text-white p-button-sm"
                :class="`!bg-[${node?.publish_status ? '#3B82F6' : '#64748B'}]`"
                @click="onUpdate(node)"
              >
                {{ node?.publish_status ? '公開中' : '非公開' }}
              </Button>
            </slot>
          </div>
        </div>
      </div>
    </template>
  </Draggable>
</template>

<script setup>
import { ref } from 'vue'
import { usePagesStore } from '@/store/pages'
import { storeToRefs } from 'pinia'

import { $dt } from '@primevue/themes'
import Button from 'primevue/button'
import Checkbox from 'primevue/checkbox'

import { Draggable } from '@he-tree/vue'
import '@he-tree/vue/style/default.css'
import { useAPI } from '@/composables/api'

const api = useAPI()
const store = usePagesStore()
const { selected } = storeToRefs(store)

const props = defineProps({
  pages: {
    type: Array,
    default: () => []
  }
})

const pageTree = ref(props.pages)

const eachDroppable = targetStat => {
  return targetStat.level < 3
}

const onUpdatePages = async () => {
  await api.pages.updatePageIdByPages({
    pages: pageTree.value
  })
  reload()
}

const onUpdate = async node => {
  const { id, ...payload } = node
  node.publish_status = !node.publish_status
  payload.publish_status = payload.publish_status ? 0 : 1
  await api.pages.update({ id, payload })
  reload()
}

const reload = async () => {
  const res = await api.pages.fetch()
  pageTree.value = res.pages
}

const onDelete = async node => {
  const { id, title } = node
  if (confirm(`${title}を削除してよろしいですか？`)) {
    await api.pages.delete({ id })
    reload()
  }
}

const onEdit = node => {
  location.href = `/admin/pages/${node.id}/edit`
}
</script>

<style scoped></style>
