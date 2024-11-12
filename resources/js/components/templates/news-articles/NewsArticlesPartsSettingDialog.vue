<template>
    <Dialog v-model:visible="visible" class="w-[80vw]">
        <template #container="{ closeCallback }">
            <div class="flex flex-col rounded-md">
                <div
                    class="bg-[#5457CD] flex justify-between items-center rounded-t-md px-4 py-2"
                >
                    <h1 class="text-white">パーツ設定</h1>

                    <div class="flex items-center gap-4">
                        <Button
                            label="キャンセル"
                            @click="onClose(closeCallback)"
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
                        <PartsMenu @update="e => (parts = e)" />
                    </div>

                    <SettingTab>
                        <component :is="parts" />
                    </SettingTab>
                </div>
            </div>
        </template>
    </Dialog>
</template>

<script setup>
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import { usePageSettingStore } from '@/store/page-setting'
import { storeToRefs } from 'pinia'

import PartsMenu from '@/components/templates/site-parts/PartsMenu.vue'
import SettingTab from '@/components/templates/site-parts/SettingTab.vue'
import HeadingSetting from '../site-parts/Heading/HeadingSetting.vue'
import { computed, shallowRef } from 'vue'

const store = usePageSettingStore()

const visible = computed({
    get: () => store.partsSetting.visible,
    set: value => {
        store.partsSetting.visible = value
    }
})

const { content, addPartsPosition: position } = storeToRefs(store)

const onSave = callback => {
    const { partsType, attributes, editingParts } = store.partsSetting
    if (editingParts && editingParts.partsType === partsType) {
        const p = content.value.find(v => v.id === editingParts.id)
        const arr = [
            'designType',
            'titleStyle',
            'subtitleStyle',
            'id',
            'className',
            'style',
            'showPCView',
            'showSPView'
        ]
        arr.map(v => {
            p.attributes[v] = attributes[v]
        })
    } else {
        content.value.splice(position.value, 0, {
            id: content.value.length + 1,
            partsType,
            attributes: Object.assign({}, attributes)
        })
    }

    onClose(callback)
    console.log(content.value)
}

const onClose = callback => {
    store.partsSetting.editTarget = null
    callback()
}

const parts = shallowRef(HeadingSetting)
</script>
