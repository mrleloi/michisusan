<template>
  <Button label="送信テスト" rounded @click="onClick"></Button>
</template>

<script setup>
import { ref } from 'vue'
import { useAPI } from '@/composables/api'
import Button from 'primevue/button'

const props = defineProps({})

const api = useAPI()

const onClick = event => {
  const formData = new FormData(document.forms[0])
  const formObj = Object.fromEntries(formData.entries())
  delete formObj._method
  delete formObj._token

  console.log(formObj)

  api.sendmail
    .sendInquiryTestMail(formObj)
    .then(() => {
      alert('送信テストを完了しました')
    })
    .catch(async e => {
      if (e.response !== undefined) {
        const res = await e.response.json()

        if (res.errors.error_code != 500) {
          alert(res.errors.error_message)
        } else {
          alert(
            'メールサーバーにログインできませんでした。設定を確認してください'
          )
        }
      } else {
        alert(
          'メールサーバーとの接続ができませんでした。設定を確認してください'
        )
      }
    })
}
</script>

<style scoped></style>
