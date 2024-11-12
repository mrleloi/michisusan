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
                <picture>
                    <img
                        class="w-full h-auto"
                        :src="attributes.previewImagePath || '/img/img_not_found.png'"
                        alt="image" />
                </picture>

                <!-- actions -->
                <div>
                    <DialogImageSelector @on-select="(payload) => {
                    attributes.image = payload.image
                    attributes.previewImagePath = payload.previewImagePath
                }">
                        <template v-slot:active>
                            <div
                                :class="`button-action button-select-image ${editable && hovering ? '' : '!hidden'}`">
                                <i class="pi pi-images"></i>
                            </div>
                        </template>
                    </DialogImageSelector>
                    <div :class="`button-action button-link-setting ${editable && hovering ? '' : '!hidden'}`"
                         @click="showModelLinkSetting">
                        <i class="pi pi-link"></i>
                    </div>
                </div>
            </div>

            <ButtonResize
                v-model="attributes.styles.image.width"
                v-model:styleSettings="attributes.styleSettings.image.width"
                :container-class="`w-[45%] absolute top-[calc(50%-1rem)] left-[53.5%] ${editable && hovering ? 'block' : 'hidden'}`"/>
        </div>
    </div>
</template>

<script setup>
import ButtonResize from '@/components/parts/common/site-part/ButtonResize.vue'
import DialogImageSelector from '@/components/parts/common/DialogImageSelector.vue'
import { ref } from 'vue'
import Heading from '../../Heading/Heading.vue'
import { SHOW_HEADING_TYPE } from '../../../../../composables/site-part.js'

const props = defineProps({
    editable: { type: Boolean, default: false }
})

const emits = defineEmits(['showModelLinkSetting'])

const attributes = defineModel('attributes')
const hovering = ref(false)

const showModelLinkSetting = () => {
    emits('showModelLinkSetting')
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
