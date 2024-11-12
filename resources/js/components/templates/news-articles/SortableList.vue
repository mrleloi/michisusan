<template>
  <table class="table-auto">
    <thead>
      <th v-if="actions.includes('bulk_delete')">&nbsp;</th>
      <th v-for="(value, column) in columns" v-bind:key="column[0]">
        {{ value }}
      </th>
      <th v-if="actions.includes('copy')">複製</th>
      <th v-if="actions.includes('edit')">編集</th>
      <th v-if="actions.includes('delete')">削除</th>
    </thead>
    <draggable
      v-model="list"
      tag="tbody"
      item-key="id"
      handle=".handle"
      :disabled="!actions.includes('sortable')"
      @end="onDragEnd"
    >
      <template #item="{ element }">
        <tr>
          <td v-if="actions.includes('bulk_delete')">
            <Checkbox :name="`checks[]`" v-model="checks" :value="element.id"
            ></Checkbox>
          </td>
          <td v-for="(value, column) in columns" v-bind:key="value" class="text-left">
            {{ element[column] }}
          </td>
          <td v-if="actions.includes('copy')" class="text-center">
            <a :href="`${items.path}/${element.id}/copy`">
              <PvButton size="small" label="複製" rounded></PvButton>
            </a>
          </td>
          <td v-if="actions.includes('edit')" class="text-center">
            <a :href="`${items.path}/${element.id}/edit`">
              <PvButton size="small" label="編集" rounded></PvButton>
            </a>
          </td>
          <td v-if="actions.includes('delete')" class="text-center">
            <form :action="`${items.path}/${element.id}/delete`" method="POST" @submit.prevent="onDelete($event, element)">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" :value="csrfToken">
              <PvButton type="submit" size="small" label="削除" rounded></PvButton>
            </form>
          </td>
        </tr>
      </template>
    </draggable>
  </table>
</template>

<script setup>
import { ref } from 'vue'
import PvButton from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import draggable from 'vuedraggable'

const props = defineProps({
  items: {
    type: Object,
    required: true
  },
  columns: {
    type: Object,
    required: true
  },
  actions: {
    type: Array,
    required: false,
    default: ['edit', 'delete', 'bulk_delete', 'sortable']
  },
  csrfToken: {
    type: String,
    required: true
  },
})

const rows = ref(20)
const checks = ref()
const list = ref([...props.items.data])

const onDragEnd = event => {
  const oldIndex = list.value[event.oldIndex].id
  const newIndex = list.value[event.newIndex].id

  console.log('Old index:', oldIndex)
  console.log('New index:', newIndex)
}

const onDelete = (event, article) => {
    const { title } = article
    if (confirm(`${title}を削除してよろしいですか？`)) {
        event.target.submit()
    }
}
</script>

<style scoped>
table {
  width: 100%;
  text-align: center;
  border-collapse: collapse;
}
table th {
  padding: 10px;
  background: #6366f1;
  border: solid 1px #c4cbef;
  color: #fff;
}
table td {
  padding: 0.2rem;
  border: solid 1px #c4cbef;
}
table td.text-left {
  text-align: left;
  padding-left: 0.5rem;
  padding-right: 0.5rem;
}
table td.text-center button {
    min-width: 86px;
}
</style>
