<template>
  <Dialog
    v-model:visible="visible"
    modal
    header="カテゴリー新規追加"
    class="w-4/5"
  >
    <div class="border">
      <div class="bg-zinc-200 p-4">
        <span class="text-red-500">※</span>は必須項目です
      </div>
      <div class="p-4">
        <table class="form-table">
          <tbody>
            <tr>
              <th>カテゴリー名<span class="text-red-500">※</span></th>
              <td>
                <InputText class="w-full" v-model="name"></InputText>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="p-4 flex justify-center">
          <PvButton
            label="登録"
            rounded
            size="small"
            @click="regist"
          ></PvButton>
        </div>
      </div>
    </div>
  </Dialog>
</template>

<script setup>
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import { ref } from 'vue'
import { useAPI } from '@/composables/api'

const api = useAPI()
const emit = defineEmits(['registered'])

const show = () => {
  visible.value = true
  name.value = ''
}

const regist = () => {
  try {
    api.categorySelector
      .addGalleryCategory({
        name: name.value
      })
      .then(res => {
        visible.value = false
        emit('registered', res)
      })
  } catch (e) {
    console.log(e)
    alert('カテゴリーを追加できませんでした')
  }
}

defineExpose({
  show
})

const visible = ref(false)
const name = ref()
</script>
