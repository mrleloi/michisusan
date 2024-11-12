<template>
  <form
    class="w-full table rounded-md pl-8 py-8 pr-4 bg-[#eff3f8]"
    @submit.prevent="onSubmit"
  >
    <div class="table-row-group">
      <div class="table-row">
        <div class="table-cell">
          <p class="font-bold">メニュー名</p>
        </div>
        <div class="table-cell py-4 pr-8">
          <InputText v-model="title" class="w-full" type="text" />
        </div>
      </div>
    </div>

    <div class="table-row-group">
      <div class="table-row">
        <div class="table-cell">
          <p class="font-bold">外部リンクURL</p>
        </div>
        <div class="table-cell py-4 pr-8">
          <InputText v-model="directory" class="w-full" type="text" />
        </div>
      </div>
    </div>

    <div class="table-row-group">
      <div class="table-row">
        <div class="table-cell align-top">
          <p class="font-bold pt-4">ナビメニュー表示</p>
        </div>
        <div class="table-cell py-4">
          <div class="flex flex-col gap-2">
            <checkbox
              v-model="dispNavi"
              class="flex gap-2"
              inputId="disp-navi-menu"
              binary
            >
              ナビメニューに表示する
            </checkbox>
            <checkbox
              v-model="dispNaviMenuUnder"
              class="flex gap-2"
              inputId="disp-navi-menu-under"
              binary
            >
              下部ナビメニューに表示する
            </checkbox>
          </div>
        </div>
      </div>
    </div>

    <div class="table-row-group">
      <div class="table-row">
        <div class="table-cell align-top">
          <p class="font-bold pt-4">サイトマップ</p>
        </div>
        <div class="table-cell py-4">
          <div class="flex flex-col gap-2">
            <checkbox
              v-model="dispSitemap"
              class="flex gap-2"
              inputId="sitemap"
              binary
            >
              サイトマップに載せる
            </checkbox>
          </div>
        </div>
      </div>
    </div>

    <div class="table-row-group">
      <div class="table-row">
        <div class="table-cell align-top">
          <p class="font-bold pt-4">その他</p>
        </div>
        <div class="table-cell py-4">
          <div class="flex flex-col gap-2">
            <checkbox
              v-model="OpenNewTab"
              class="flex gap-2"
              inputId="option-tab"
              binary
            >
              同一タブ(ウインドウ)で開く
            </checkbox>
          </div>
        </div>
      </div>
    </div>
    <div class="table-row-group">
      <div class="table-row">
        <div class="table-cell"></div>
        <div class="table-cell">
          <div class="flex justify-end pr-8">
            <div class="">
              <Button class="w-[100px]" type="submit" rounded>追加</Button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Checkbox from '@/components/parts/common/Checkbox.vue'
import { useAPI } from '@/composables/api'
import { reactive, ref, toValue } from 'vue'

const title = ref('')
const directory = ref('')
const dispNavi = ref(false)
const dispNaviMenuUnder = ref(false)
const dispSitemap = ref(false)
const OpenNewTab = ref(false)

const api = useAPI()

const onSubmit = async e => {
  await api.pages.create(
    toValue(
      reactive({
        title,
        directory,
        dispNavi,
        dispNaviMenuUnder,
        dispSitemap,
        OpenNewTab
      })
    )
  )
  e.target.submit()
}
</script>
