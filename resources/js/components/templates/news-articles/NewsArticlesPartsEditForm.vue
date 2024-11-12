<template>
    <div class="h-full" :class="previewSize">
        <div class="site-header">
            <p>header</p>
        </div>

        <div class="site-content py-4">
            <template v-if="content.length">
                <draggable
                    v-model="content"
                    group="content"
                    item-key="id"
                    handle=".handle"
                >
                    <template #item="{ element, index }">
                        <div
                            class="flex flex-col items-center relative border-[#6169a9]"
                            :class="{ 'border-4': hovering === index }"
                            @mouseover="hovering = index"
                            @mouseleave="hovering = null"
                        >
                            <EditToolBar
                                v-if="hovering === index"
                                :index="index"
                                :attributes="element.attributes"
                                @update="onUpdate"
                                @duplicate="onDuplicate(index, element)"
                                @like=""
                                @changeParts="openModal(index, element)"
                                @remove="content.splice(index, 1)"
                            >
                            </EditToolBar>

                            <div v-if="!index" class="absolute">
                                <Button
                                    icon="pi pi-plus"
                                    size="small"
                                    @click="onDialogOpen(index)"
                                />
                            </div>

                            <SiteParts
                                :name="element.partsType"
                                v-model:attributes="element.attributes"
                                editable
                            />

                            <div class="absolute top-full z-10">
                                <Button
                                    icon="pi pi-plus"
                                    size="small"
                                    @click="onDialogOpen(index + 1)"
                                />
                            </div>
                        </div>
                    </template>
                </draggable>
            </template>
            <template v-else>
                <div class="w-full flex flex-col items-center gap-8">
                    <Button icon="pi pi-plus" size="small" @click="onDialogOpen(0)" />

                    <p class="text-center">
                        『＋』アイコンを押すと表示される各ツールを使用して、ページを作成しましょう。<br />
                        お気に入りからブロック・パーツを使用する場合は重複コンテンツに注意してください。
                    </p>
                </div>
            </template>
        </div>

        <div class="site-footer">
            <p>footer</p>
        </div>
    </div>
</template>

<script setup>
import { usePageSettingStore } from '@/store/page-setting'
import { storeToRefs } from 'pinia'
import Button from 'primevue/button'
import draggable from 'vuedraggable'
import SiteParts from '../site-parts/SiteParts.vue'
import {computed, reactive, ref} from 'vue'
import { useWindowSizeStore } from '../../../store/window-size'
import EditToolBar from '../site-parts/EditToolBar.vue'
const store = usePageSettingStore()
const { addPartsPosition: position, content } = storeToRefs(store)
const windowSize = useWindowSizeStore()
const { previewMode } = storeToRefs(windowSize)

import {defineProps} from "vue";
const props = defineProps(['dataUpdate'])
const dataUpdate = reactive(props.dataUpdate)
content.value = reactive(dataUpdate?.content ? JSON.parse(dataUpdate.content) : [])

const hovering = ref(null)

const previewSize = computed(() => {
    if (!windowSize.isDesktop) {
        return 'w-full'
    }
    if (previewMode.value === 'desktop') {
        return 'w-full'
    } else if (previewMode.value === 'tablet') {
        return 'w-[768px]'
    } else {
        return 'w-[363px]'
    }
})

const onDialogOpen = p => {
    position.value = p
    store.partsSetting.visible = true
}

const onUpdate = (index, target, value, ...args) => {
    console.log(index, target, value, args)
    content.value[index].attributes[target] = value
}

const onDuplicate = (index, { attributes, ...settings }) => {
    content.value.splice(index, 0, {
        id: content.length + 1,
        ...settings,
        attributes: { ...attributes }
    })
}

const openModal = (index, parts) => {
    store.partsSetting.editingParts = parts
    onDialogOpen(index + 1)
}

previewMode.value = 'desktop'
</script>
