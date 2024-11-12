<template>
  <table class="table-auto w-full border-collapse">
    <tbody>
      <tr class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          {{ label }}ロゴ画像
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="py-5 px-4 flex gap-2 flex-col">
            <div class="flex items-center gap-8">
              <ImageSelector v-if="inputId == 'sticky_footer'" v-model="logoImageId" :name="`footer_logo_image_id`" :value="`${logoImageId}`"></ImageSelector>
              <ImageSelector v-else v-model="logoImageId" :name="`${inputId}_logo_image_id`" :value="`${logoImageId}`"></ImageSelector>
            </div>
            <p>
              推奨サイズは横400px以上、縦88px以上です<br />
              デザインテンプレートの種類によっては透過PNGが必須となります
            </p>
          </div>
        </td>
      </tr>
      <tr>
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          表示設定
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div
            v-if="inputId === 'header'"
            class="py-5 px-4 flex gap-2 flex-col"
          >
            <Checkbox
              v-model="showTranslation"
              :inputId="`show_${inputId}_translation`"
              :name="`show_${inputId}_translation`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              翻訳機能を表示する
            </Checkbox>
            <Checkbox
              v-model="showTel1"
              :inputId="`show_${inputId}_tel1`"
              :name="`show_${inputId}_tel1`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              電話番号(1)を表示する</Checkbox
            >
            <Checkbox
              v-model="showTel2"
              :inputId="`show_${inputId}_tel2`"
              :name="`show_${inputId}_tel2`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              電話番号(2)を表示する</Checkbox
            >
            <Checkbox
              v-model="showAddress"
              :inputId="`show_${inputId}_address`"
              :name="`show_${inputId}_address`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              住所を表示する</Checkbox
            >
            <Checkbox
              v-model="showBusinessHours"
              :inputId="`show_${inputId}_business_hours`"
              :name="`show_${inputId}_business_hours`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              営業時間を表示する</Checkbox
            >
            <Checkbox
              v-model="showButton"
              :inputId="`show_${inputId}_button`"
              :name="`show_${inputId}_button`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              ボタンを表示する</Checkbox
            >
            <Checkbox
              v-model="showPCSNSLink"
              :inputId="`show_pc_${inputId}_sns_link`"
              :name="`show_pc_${inputId}_sns_link`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              PC時にもヘッダーSNSリンクを表示する</Checkbox
            >
          </div>

          <div
            v-if="inputId === 'sticky_footer'"
            class="py-5 px-4 flex gap-2 flex-col"
          >
            <Checkbox
              v-model="showStickyFooter"
              :inputId="`show_sticky_footer`"
              :name="`show_sticky_footer`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              追従フッターを表示する</Checkbox
            >
            <Checkbox
              v-model="showTel1"
              :inputId="`show_${inputId}_tel1`"
              :name="`show_${inputId}_tel1`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              電話番号(1)を表示する</Checkbox
            >
            <Checkbox
              v-model="showTel2"
              :inputId="`show_${inputId}_tel2`"
              :name="`show_${inputId}_tel2`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              電話番号(2)を表示する</Checkbox
            >
            <Checkbox
              v-model="showBusinessHours"
              :inputId="`show_${inputId}_business_hours`"
              :name="`show_${inputId}_business_hours`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              営業時間を表示する</Checkbox
            >
            <Checkbox
              v-model="showButton"
              :inputId="`show_${inputId}_button`"
              :name="`show_${inputId}_button`"
              binary
              :trueValue="1"
              :falseValue="0"
            >
              ボタンを表示する</Checkbox
            >
          </div>
        </td>
      </tr>
      <tr class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          ボタン設定 (1)
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <LinkSettingField
            class="py-5 px-4 flex gap-2 flex-col"
            :inputId="`${inputId}_button1`"
            :setting="setting"
            :pages="$attrs.pages"
            openLinkType
          />
        </td>
      </tr>
      <tr>
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          ボタン設定 (2)
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <LinkSettingField
            class="py-5 px-4 flex gap-2 flex-col"
            :inputId="`${inputId}_button2`"
            :setting="setting"
            :pages="$attrs.pages"
            openLinkType
          />
        </td>
      </tr>
      <tr v-if="inputId === 'header'" class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          デフォルトの表示位置
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="py-5 px-4 flex gap-2 flex-col">
            <div class="flex gap-2 flex-row">
              <template
                v-for="{ key, label, value } in headerPositionChoices"
                :key="key"
              >
                <RadioButton
                  class="flex gap-2"
                  :inputId="key"
                  :name="`${inputId}_default_position`"
                  v-model="checked"
                  :value="value"
                >
                  {{ label }}
                </RadioButton>
              </template>
            </div>
          </div>
        </td>
      </tr>
      <tr v-if="inputId === 'sticky_footer'" class="bg-[#EFF3F8]">
        <td
          class="p-[0.2rem] border border-solid border-[#c4cbef] font-bold text-center"
        >
          フッターナビ項目
        </td>
        <td class="w-9/12 p-[0.2rem] border border-solid border-[#c4cbef]">
          <div class="py-5 px-4 flex gap-2 flex-col">
            <div class="flex gap-2 flex-row">
              <template
                v-for="{ key, label, value } in footerNaviChoices"
                :key="key"
              >
                <RadioButton
                  class="flex gap-2"
                  :inputId="key"
                  v-model="checked"
                  :value="value"
                >
                  {{ label }}
                </RadioButton>
              </template>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { ref } from 'vue'
import ImageSelector from '@/components/parts/common/ImageSelector.vue'
import Checkbox from '@/components/parts/common/Checkbox.vue'
import RadioButton from '@/components/parts/common/RadioButton.vue'
import LinkSettingField from '@/components/parts/common/LinkSettingField.vue'

const props = defineProps({
  label: { type: String },
  inputId: { type: String },
  setting: { type: Object }
})

const checked = ref(props.setting[`${props.inputId}_default_position`])
const isDeleteLogo = ref(false)

const headerPositionChoices = ref([
  {
    key: 'button-0',
    label: '左揃え',
    value: 1
  },
  {
    key: 'button-1',
    label: '中央揃え',
    value: 2
  },
  {
    key: 'button-2',
    label: '右揃え',
    value: 3
  }
])

const footerNaviChoices = ref([
  {
    key: 'button-0',
    label: '長い項目は省略する',
    value: 'ellipsis'
  },
  {
    key: 'button-1',
    label: '長い項目も省略しない',
    value: 'all'
  }
])

const showStickyFooter = ref(props.setting[`show_sticky_footer`])
const showTranslation = ref(props.setting[`show_${props.inputId}_translation`])
const showTel1 = ref(props.setting[`show_${props.inputId}_tel1`])
const showTel2 = ref(props.setting[`show_${props.inputId}_tel2`])
const showAddress = ref(props.setting[`show_${props.inputId}_address`])
const showBusinessHours = ref(
  props.setting[`show_${props.inputId}_business_hours`]
)
const showButton = ref(props.setting[`show_${props.inputId}_button`])
const showPCSNSLink = ref(props.setting[`show_pc_${props.inputId}_sns_link`])
const logoImageId = ref(props.setting[props.inputId === 'sticky_footer' ? 'footer_logo_image_id' : `${props.inputId}_logo_image_id`])
</script>
