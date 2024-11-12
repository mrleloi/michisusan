<template>
  <table class="table-auto w-full border-collapse">
    <tbody>
      <tr class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          文字色
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="pt-4 pb-2 px-4">
            <ColorPicker
              name="header_menu_text_color"
              :value="setting.header_menu_text_color"
            />
          </div>
        </td>
      </tr>
      <tr>
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          フォント
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="pt-4 pb-2 px-4">
            <Dropdown class="w-full"></Dropdown>
          </div>
        </td>
      </tr>
      <tr class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          文字の太さ
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="pt-4 pb-2 px-4">
            <Dropdown class="w-full"></Dropdown>
          </div>
        </td>
      </tr>
      <tr>
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          区切り線
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="pt-4 pb-2 px-4">
            <Dropdown class="w-full"></Dropdown>
          </div>
        </td>
      </tr>
      <tr class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          ホバー時アニメーション
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="pt-4 pb-2 px-4">
            <Dropdown class="w-full"></Dropdown>
            <div class="pt-4 pb-2 flex gap-6">
              <div class="flex gap-4">
                <p>文字色</p>
                <ColorPicker
                  name="header_menu_hover_animation_text_color"
                  :value="setting.header_menu_hover_animation_text_color"
                />
              </div>
              <div class="flex gap-4">
                <p>ライン・背景色</p>
                <ColorPicker
                  name="header_menu_hover_animation_bg_color"
                  :value="setting.header_menu_hover_animation_bg_color"
                />
              </div>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          スマホメニュー
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="p-4 flex gap-2 flex-row">
            <template v-for="{ key, label, value } in spMenuOptions" :key="key">
              <RadioButton
                class="flex gap-2"
                :inputId="key"
                v-model="showSpMenu"
                :value="value"
              >
                {{ label }}
              </RadioButton>
            </template>
          </div>
        </td>
      </tr>
      <tr class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          スマホメニュー(1)
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <LinkSettingField
            class="py-5 px-4 flex gap-2 flex-col"
            :inputId="`sp_header_menu1`"
            :setting="setting"
            :pages="pages"
          />
        </td>
      </tr>
      <tr>
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          スマホメニュー(2)
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <LinkSettingField
            class="py-5 px-4 flex gap-2 flex-col"
            :inputId="`sp_header_menu2`"
            :setting="setting"
            :pages="pages"
          />
        </td>
      </tr>
      <tr class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          スマホメニュー(3)
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <LinkSettingField
            class="py-5 px-4 flex gap-2 flex-col"
            :inputId="`sp_header_menu3`"
            :setting="setting"
            :pages="pages"
          />
        </td>
      </tr>
      <tr>
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          スマホメニュー(4)
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <LinkSettingField
            class="py-5 px-4 flex gap-2 flex-col"
            :inputId="`sp_header_menu4`"
            :setting="setting"
            :pages="pages"
          />
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { ref } from 'vue'
import ColorPicker from '@/components/parts/pv/ColorPicker.vue'
import Dropdown from '@/components/parts/common/Dropdown.vue'
import LinkSettingField from '@/components/parts/common/LinkSettingField.vue'
import RadioButton from '@/components/parts/common/RadioButton.vue'

const props = defineProps({
  setting: Object,
  pages: Array
})

const showSpMenu = ref(true)

const spMenuOptions = ref([
  {
    key: 'spMenuOption-0',
    label: '表示する',
    value: true
  },
  {
    key: 'spMenuOption-1',
    label: '表示しない',
    value: false
  }
])
</script>
