<template>
    <!--  Model image link settings  -->
    <Dialog
        v-model:visible="visible"
        class="w-[600px]"
        pt:root:class="!border-0 !bg-white"
        pt:mask:class="backdrop-blur-sm" >
        <template #container="{ closeCallback }">
            <div class="bg-[#5457CD] flex justify-between items-center rounded-t-md px-4 py-2">
                <span class="text-white font-bold">リンク設定</span>

                <div class="flex items-center gap-4">
                    <Button
                        label="キャンセル"
                        @click="closeCallback"
                        severity="danger"
                        class="btn-articles"
                    />
                    <Button
                        label="決定"
                        @click="onSaveLinkSetting"
                        class="btn-articles btn-articles-submit"
                    />
                </div>
            </div>

            <div class="flex flex-col gap-4 px-8 py-4">
                <RadioButton
                    :inputId="`linkSettingTypeNone-${randomId}`"
                    v-model="formLinkSetting.linkSettingType"
                    :value="LINK_SETTING_TYPE.NONE">
                    無し
                </RadioButton>

                <div class="flex items-center gap-6">
                    <RadioButton
                        :inputId="`linkSettingTypeSelect-${randomId}`"
                        v-model="formLinkSetting.linkSettingType"
                        :value="LINK_SETTING_TYPE.SELECT_PAGE">
                        ページを選択
                    </RadioButton>

                    <Select
                        v-model="formLinkSetting.linkSelectedUrl"
                        class="flex-0 w-48"
                        :options="[1, 2, 3].map(v => ({ id: v, name: `Page ${v}` }))"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="カテゴリーを選択"
                    ></Select>
                </div>

                <div>
                    <RadioButton
                        v-model="formLinkSetting.linkSettingType"
                        :inputId="`linkSettingTypeOptional-${randomId}`"
                        :value="LINK_SETTING_TYPE.OPTIONAL">
                        任意で設定
                    </RadioButton>
                    <InputText class="w-full h-[38px] mt-4" v-model.trim="formLinkSetting.linkCustomUrl" placeholder="URL"/>
                </div>

                <div>
                    <Checkbox
                        v-model="formLinkSetting.openLinkOnNewTab"
                        class="mt-4"
                        :input-id="`linkSettingOpenLinkOnNewTab-${randomId}`"
                        binary />
                    <label class="ml-2 cursor-pointer" :for="`linkSettingOpenLinkOnNewTab-${randomId}`">別ウインドウ(別タブ)で開く</label>
                </div>
            </div>

        </template>
    </Dialog>
    <!--  -->

    <div class="w-full px-5 py-10">
        <DesignType3
            v-if="attributes.designType === 3"
            v-model:attributes="attributes"
            :editable="editable"
            @showModelLinkSetting="showModelLinkSetting" />

        <DesignType4
            v-if="attributes.designType === 4"
            v-model:attributes="attributes"
            :editable="editable"
            @showModelLinkSetting="showModelLinkSetting" />
    </div>
</template>

<script setup>
import Dialog from 'primevue/dialog'
import Button from 'primevue/button'
import Select from 'primevue/select'
import Checkbox from 'primevue/checkbox'
import InputText from 'primevue/inputtext'
import RadioButton from '@/components/parts/common/RadioButton.vue'
import { LINK_SETTING_TYPE } from '@/composables/site-part.js'
import { ref } from 'vue'
import DesignType3 from './design-types/DesignType3.vue'
import DesignType4 from './design-types/DesignType4.vue'

const props = defineProps({
    editable: { type: Boolean, default: false }
})

const attributes = defineModel('attributes')
const visible = ref(false)
const randomId = Math.random().toString(36).substring(7)

const formLinkSetting = ref({
    linkSettingType: LINK_SETTING_TYPE.NONE,
    linkSelectedUrl: '',
    linkCustomUrl: '',
    openLinkOnNewTab: false,
})

const showModelLinkSetting = async () => {
    loadFormLinkSetting()
    visible.value = true
}

const onSaveLinkSetting = () => {
    attributes.value.linkSettingType = formLinkSetting.value.linkSettingType
    attributes.value.openLinkOnNewTab = formLinkSetting.value.openLinkOnNewTab
    attributes.value.linkSettingUrl = formLinkSetting.value.linkSettingType === LINK_SETTING_TYPE.SELECT_PAGE
        ? formLinkSetting.value.linkSelectedUrl
        : formLinkSetting.value.linkCustomUrl
    visible.value = false
}

const loadFormLinkSetting = () => {
    formLinkSetting.value.linkSettingType = attributes.value.linkSettingType
    formLinkSetting.value.linkSelectedUrl = attributes.value.linkSettingType === LINK_SETTING_TYPE.SELECT_PAGE
        ? attributes.value.linkSettingUrl
        : ''
    formLinkSetting.value.linkCustomUrl = attributes.value.linkSettingType === LINK_SETTING_TYPE.OPTIONAL
        ? attributes.value.linkSettingUrl
        : ''
    formLinkSetting.value.openLinkOnNewTab = attributes.value.openLinkOnNewTab
}
</script>
