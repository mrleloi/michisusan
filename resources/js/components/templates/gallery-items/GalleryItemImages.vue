<template>
  <DraggableTable
    :fields="fields"
    :add-object="{ id: null, sort_order: 0, image_id: '' }"
  >
    <template v-slot:default="d">
      <td>
        <ImageSelector
          :name="`rows[${d.index}][image_id]`"
          :value="d.field.image_id"
          :can-delete="false"
          :delete-name-callback="
            name => {
              return name.slice(0, name.length - 1) + '_delete]'
            }
          "
        ></ImageSelector>

        <input type="hidden" :name="`rows[${d.index}][id]`" :id="`rows[${d.index}][id]`" :value="d.field.id"></input>
        <FormError
          :error-key="`rows.${d.index}.id`"
          :errors="errors"
        ></FormError>
      </td>
    </template>
  </DraggableTable>
</template>
<script setup>
import InputText from 'primevue/inputtext'
import DraggableTable from '../../parts/common/DraggableTable.vue'
import ImageSelector from '../../parts/common/ImageSelector.vue'
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
</script>
