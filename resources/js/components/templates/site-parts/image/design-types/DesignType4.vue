<template>
    <Heading
        v-if="editable && attributes.showHeadingType !== SHOW_HEADING_TYPE.NONE"
        :attributes="attributes.headingAttributes"
        :editable="editable" />
    <!-- frame layer -->
    <div
        :class="`frame-layer ${editable ? '' : '!p-0'}`"
        :style="attributes.styles?.frame"
        @mouseover="hovering = true"
        @mouseleave="hovering = false">

        <!-- item layer -->
        <div :class="`item-layer relative ${editable ? '' : '!p-0'}`"
             :style="attributes.styles?.item">

            <!-- image layer -->
            <div :class="`image-layer relative ${editable ? '' : '!w-52'}`"
                 :style="attributes.styles.image">
                <div class="flex gap-4 justify-center">
                    <picture v-for="index in numberOfImages"
                             :key="index"
                             :class="`w-1/${numberOfImages}`">
                        <img v-if="getPreviewImagePath(index)"
                             class="h-full w-auto"
                             :alt="`image ${index}`"
                             :src="getPreviewImagePath(index)"
                        />
                        <img v-else
                             class="w-full h-auto"
                             :src="'/img/img_not_found.png'"
                             :alt="`image ${index}`"
                        />
                        <div class="absolute bottom-0">
                            <!-- DialogImageSelector for each image -->
                            <DialogImageSelector
                                @on-select="(payload) => updateImage(payload, index)"
                            >
                                <template v-slot:active>
                                    <div
                                        :class="`button-action button-select-image ${editable && hovering ? '' : '!hidden'}`"
                                    >
                                        <i class="pi pi-images"></i>
                                    </div>
                                </template>
                            </DialogImageSelector>
                        </div>
                    </picture>
                </div>

                <!-- actions -->
                <div>
                    <!-- Button for link setting -->
                    <div :class="`button-action button-link-setting ${editable && hovering ? '' : '!hidden'}`"
                         @click="showModelLinkSetting">
                        <i class="pi pi-link"></i>
                    </div>
                </div>
            </div>

            <!-- ButtonResize component -->
            <ButtonResize
                v-model="attributes.styles.image.width"
                v-model:styleSettings="attributes.styleSettings.image.width"
                :container-class="`w-[45%] absolute top-[calc(50%-1rem)] right-0 ${editable && hovering ? 'block' : 'hidden'}`"
            />
        </div>
    </div>
</template>

<script setup>
import ButtonResize from '@/components/parts/common/site-part/ButtonResize.vue'
import DialogImageSelector from '@/components/parts/common/DialogImageSelector.vue'
import Heading from '../../Heading/Heading.vue'
import { SHOW_HEADING_TYPE } from '../../../../../composables/site-part.js'
import { ref, defineModel } from 'vue'

const props = defineProps({
    editable: { type: Boolean, default: false }
})

const emits = defineEmits(['showModelLinkSetting'])

const attributes = defineModel('attributes')
const items = attributes.value
const numberOfImages = items.numberOfImages
const hovering = ref(false)

const showModelLinkSetting = () => {
    emits('showModelLinkSetting')
}

const updateImage = (payload, index) => {
    const { previewImagePath } = payload
    // Dynamically update attributes based on index
    items[`image${index}`] = index
    items[`previewImagePath${index}`] = previewImagePath
}

const getPreviewImagePath = (index) => {
    return items[`previewImagePath${index}`]
}
</script>

<style scoped>
.frame-layer {
    padding: 40px;
    width: 100%;
}

.item-layer {
    padding: 30px;
    display: flex;
    justify-content: center;
}

.button-action {
    position: absolute;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.button-action:hover {
    opacity: 0.8;
    cursor: pointer;
}

.button-select-image {
    background-color: #f06292;
    bottom: 0;
    left: 0;
}

.button-link-setting {
    background-color: #76e329;
    bottom: 0;
    right: 0;
}

.image-layer {
    height: auto;
}
</style>
