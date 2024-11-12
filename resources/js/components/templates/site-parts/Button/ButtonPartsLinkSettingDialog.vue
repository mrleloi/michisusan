<template>
  <Dialog v-model:visible="visible" class="w-[40vw]">
    <template #container="{ closeCallback }">
      <div class="flex flex-col rounded-md">
        <div
          class="bg-[#5457CD] flex justify-between items-center rounded-t-md px-4 py-2"
        >
          <h1 class="text-white">パーツ設定</h1>

          <div class="flex items-center gap-4">
            <Button
              label="キャンセル"
              @click="closeCallback"
              class="w-[90px]"
              size="small"
              severity="danger"
            />

            <Button
              label="決定"
              @click="onSave(closeCallback)"
              class="w-[90px]"
              size="small"
              severity="success"
            />
          </div>
        </div>

        <div class="w-full h-[60vh] flex flex-row bg-white">
          <div class="overflow-y-auto">
            <div class="flex flex-col gap-4 p-4">
              <div class="flex items-center gap-4">
                <RadioButton
                  v-model="select"
                  inputId="internal"
                  value="internal"
                />
                <label for="internal">ページ選択</label>
                <Select />
              </div>

              <div class="flex items-center gap-4">
                <RadioButton
                  v-model="select"
                  inputId="external"
                  value="external"
                />
                <label for="external">任意で設定</label>
                <InputText type="text" v-model="inputUrl" />
              </div>

              <div class="flex items-center gap-4">
                <Checkbox
                  inputId="openWindow"
                  v-model="openWindow"
                  :binary="true"
                />
                <label for="openWindow">別ウインドウ(別タブ)で開く</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </Dialog>
</template>

<script setup>
import Button from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import RadioButton from 'primevue/radiobutton'
import Select from 'primevue/select'
import { ref, watch } from 'vue'

const visible = defineModel('visible')
const url = defineModel('url')
const openWindow = defineModel('openWindow')

const select = ref('internal')
const inputUrl = ref('')

const onSave = e => {
  if (select.value === 'external') {
    url.value = inputUrl.value
  } else {
    url.value = ''
  }
  visible.value = false
}

watch(visible, value => {
  if (value) {
    if (url.value) {
      // ページ内リンクであればselect.valueを'internal'にし選択状態に
      select.value = 'external'
      inputUrl.value = url.value
    }

    console.log('true')
  } else {
    inputUrl.value = ''
    console.log('false')
  }
})
</script>

<style scoped></style>
