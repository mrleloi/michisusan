<template>
  <div v-if="enableDeleteCheckboxButton" class="my-4">
    <Button
      size="small"
      label="チェックした項目を全て削除"
      @click="deleteCheck"
      rounded
    />
  </div>
  <table class="form-table">
    <slot name="header"></slot>
    <draggable
      v-model="fields"
      tag="tbody"
      item-key="_index"
      handle=".handle"
      @end="onDragEnd"
    >
      <template #item="{ element: field, index }">
        <tr>
          <td v-if="enableDeleteCheckboxButton" class="text-center w-14">
            <Checkbox v-model="field._checked" :binary="true"></Checkbox>
          </td>
          <td class="text-center w-14">
            <i class="pi pi-sort-alt handle cursor-grab"></i>
          </td>
          <slot :field="field" :index="index"></slot>
          <td class="text-center w-2">
            <Button
              icon="pi pi-times"
              severity="danger"
              rounded
              aria-label="削除"
              @click="removeField(index)"
            />
          </td>
        </tr>
      </template>
    </draggable>
  </table>

  <div class="flex justify-end mt-4">
    <Button size="small" label="追加" @click="addField" rounded></Button>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Button from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import draggable from 'vuedraggable'

const props = defineProps({
  fields: {
    type: Array,
    required: true,
    default: []
  },
  addObject: {
    type: Object,
    required: true
  },
  initializeCallback: {
    type: Function,
    default: (field, index, props) => {}
  },
  enableDeleteCheckboxButton: {
    type: Boolean,
    default: false
  }
})

let no = 0
const fields = ref([])
props.fields.forEach((field, index) => {
  const c = structuredClone(field)
  c._index = no++
  c._checked = false
  props.initializeCallback(c, index, props)
  fields.value.push(c)
})

const addField = () => {
  const c = structuredClone(props.addObject)
  c._index = no++
  c._checked = false
  fields.value.push(c)
}
const removeField = start => {
  fields.value.splice(start, 1)
}
const onDragEnd = event => {
  console.log('onDragEnd', event, fields.value)
  //const fromId = fields.value[event.oldIndex].id
  //const toId = fields.value[event.newIndex].id
}
const deleteCheck = () => {
  fields.value = fields.value.filter((c, index) => {
    return c._checked === false
  })
}
</script>
