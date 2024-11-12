<template>
  <DraggableTable
    :fields="fields"
    :add-object="addObject"
    :initialize-callback="initializeCallback"
    :enable-delete-checkbox-button="true"
  >
    <template v-slot:header>
      <tr class="list-form">
        <th></th>
        <th>並替</th>
        <th>必須</th>
        <th>フォーム項目設定</th>
        <th>削除</th>
      </tr>
    </template>
    <template v-slot:default="d">
      <td class="text-center">
        <input type="hidden" :name="`rows[${d.index}][required]`" :value="0" />
        <label class="sp-only mr-2">必須</label>
        <Checkbox
          :name="`rows[${d.index}][required]`"
          :value="1"
          :trueValue="1"
          :falseValue="0"
          v-model="d.field.required"
          :binary="true"
        ></Checkbox>
      </td>
      <td>
        <input
          type="hidden"
          :name="`rows[${d.index}][id]`"
          :value="d.field.id"
        />
        <input
          type="hidden"
          :name="`rows[${d.index}][sort_order]`"
          :value="d.field.sort_order"
        />
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
          <label :for="`rows[${d.index}][field_type]`">タイプ</label>
        </div>
        <div>
          <Select
            :id="`rows[${d.index}][field_type]`"
            v-model="d.field.field_type"
            :options="fieldTypeOptions"
            option-value="key"
            option-label="label"
            placeholder="選択してください"
          ></Select>
          <input
            type="hidden"
            :name="`rows[${d.index}][field_type]`"
            :value="d.field.field_type"
          />
          <FormError
            :error-key="`rows.${d.field._index}.field_type`"
            :errors="errors"
          ></FormError>
        </div>
        <div class="mt-5">
          <label :for="`rows[${d.index}][contents]`">選択内容</label>
        </div>
        <div>
          <InputText
            :name="`rows[${d.index}][contents]`"
            :id="`rows[${d.index}][contents]`"
            v-model="d.field.contents"
            class="w-full"
          ></InputText>
          <FormError
            :error-key="`rows.${d.field._index}.contents`"
            :errors="errors"
          ></FormError>
          <p class="mt-2">
            ラジオボタン・チェックボックス・プルダウンを選択した場合、表示する内容を半角カンマ(,)区切りで入力してください。また、郵便番号と住所を連動させたい場合は、同じ内容の文字列（1234、等）をそれぞれご入力ください。
          </p>
        </div>
        <div class="mt-5">
          <label :for="`rows[${d.index}][remarks]`">備考</label>
        </div>
        <div>
          <Textarea
            rows="3"
            class="w-full"
            :name="`rows[${d.index}][remarks]`"
            v-model="d.field.remarks"
          ></Textarea>
          <FormError
            :error-key="`rows.${d.field._index}.remarks`"
            :errors="errors"
          ></FormError>
        </div>
      </td>
    </template>
  </DraggableTable>
</template>
<script setup>
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import Checkbox from 'primevue/checkbox'
import DraggableTable from '../../parts/common/DraggableTable.vue'
import Textarea from 'primevue/textarea'
import FormError from '../../parts/common/FormError.vue'

const props = defineProps({
  fields: {
    type: Array,
    required: true,
    default: []
  },
  fieldTypeOptions: {
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

const addObject = {
  id: null,
  sort_order: 0,
  field_name: '',
  field_type: '',
  required: false,
  contents: '',
  remarks: ''
}
const initializeCallback = (c, index, props) => {
  c.field_type = c.field_type ?? ''
  if (c.field_type !== '') {
    c.field_type = parseInt(c.field_type, 10)
  }
}
</script>
