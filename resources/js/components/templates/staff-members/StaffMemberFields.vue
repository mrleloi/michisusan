<template>
  <DraggableTable
    :fields="fields"
    :add-object="addObject"
    :initialize-callback="initializeCallback"
  >
    <template v-slot:default="d">
      <td>
        <input type="hidden" :name="`rows[${d.index}][id]`" :value="d.field.id"></input>
        <input type="hidden" :name="`rows[${d.index}][sort_order]`" :value="d.field.sort_order"></input>
        <div><label :for="`rows[${d.index}][field_name]`">項目名</label></div>
        <div>
          <InputText
            :name="`rows[${d.index}][field_name]`"
            :id="`rows[${d.index}][field_name]`"
            v-model="d.field.field_name"
            class="w-full"
          ></InputText>
          <FormError
            :error-key="`rows.${d.field._index}.field_name`"
            :errors="errors"
          ></FormError>
        </div>
        <div class="mt-5">
          <label :for="`rows[${d.index}][contents]`">内容</label>
        </div>
        <div>
          <CkEditor
            :name="`rows[${d.index}][contents]`"
            :value="d.field.contents"
          ></CkEditor>
          <FormError
            :error-key="`rows.${d.field._index}.contents`"
            :errors="errors"
          ></FormError>
        </div>
      </td>
    </template>
  </DraggableTable>
</template>
<script setup>
import InputText from 'primevue/inputtext'
import DraggableTable from '../../parts/common/DraggableTable.vue'
import CkEditor from '../../parts/common/CkEditor.vue'
import FormError from '../../parts/common/FormError.vue'

const props = defineProps({
  fields: {
    type: Array,
    required: true,
    default: []
  },
  errors: {
    type: Object,
    required: true,
    default: {}
  }
})

const addObject = { id: null, sort_order: 0, field_name: '', contents: '' }
const initializeCallback = (c, index, props) => {
  c.contents = c.contents ?? '' //CkEditor対策
}

console.log('fields', props.fields)
</script>
