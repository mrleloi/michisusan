<template>
    <div>
        <p class="font-bold mb-8">画像クリップ</p>
        <div class="flex flex-wrap gap-14">
            <div class="flex">
                <Checkbox
                    v-model="typeChecked"
                    :input-id="`clip-check-1-${randomId}`"
                    class="mr-2" :value="TYPES.CLIP_1"
                    @change="handleChangeTypeChecked(TYPES.CLIP_1)"/>
                <label :for="`clip-check-1-${randomId}`">クリップ1</label>
                <div class="image-clip-demo image-clip-1"></div>
            </div>
            <div class="flex">
                <Checkbox
                    v-model="typeChecked"
                    :input-id="`clip-check-2-${randomId}`"
                    class="mr-2" :value="TYPES.CLIP_2"
                    @change="handleChangeTypeChecked(TYPES.CLIP_2)"/>
                <label :for="`clip-check-2-${randomId}`">クリップ2</label>
                <div class="image-clip-demo image-clip-2"></div>
            </div>
            <div class="flex">
                <Checkbox
                    v-model="typeChecked"
                    :input-id="`clip-check-3-${randomId}`"
                    class="mr-2" :value="TYPES.CLIP_3"
                    @change="handleChangeTypeChecked(TYPES.CLIP_3)"/>
                <label :for="`clip-check-3-${randomId}`">クリップ3</label>
                <div class="image-clip-demo image-clip-3"></div>
            </div>
            <div class="flex">
                <Checkbox
                    v-model="typeChecked"
                    :input-id="`clip-check-4-${randomId}`"
                    class="mr-2" :value="TYPES.CLIP_4"
                    @change="handleChangeTypeChecked(TYPES.CLIP_4)"/>
                <label :for="`clip-check-4-${randomId}`">クリップ4</label>
                <div class="image-clip-demo image-clip-4"></div>
            </div>
            <div class="flex">
                <Checkbox
                    v-model="typeChecked"
                    :input-id="`clip-check-5-${randomId}`"
                    class="mr-2" :value="TYPES.CLIP_5"
                    @change="handleChangeTypeChecked(TYPES.CLIP_5)"/>
                <label :for="`clip-check-5-${randomId}`">クリップ5</label>
                <div class="image-clip-demo image-clip-5"></div>
            </div>
            <div class="flex">
                <Checkbox
                    v-model="typeChecked"
                    :input-id="`clip-check-6-${randomId}`"
                    class="mr-2" :value="TYPES.CLIP_6"
                    @change="handleChangeTypeChecked(TYPES.CLIP_6)"/>
                <label :for="`clip-check-6-${randomId}`">正円</label>
                <div class="image-clip-demo image-clip-6"></div>
            </div>
            <div class="flex">
                <Checkbox
                    v-model="typeChecked"
                    :input-id="`clip-check-7-${randomId}`"
                    class="mr-2" :value="TYPES.CLIP_7"
                    @change="handleChangeTypeChecked(TYPES.CLIP_7)"/>
                <label :for="`clip-check-7-${randomId}`">ひずみ円</label>
                <div class="image-clip-demo image-clip-7"></div>
            </div>
        </div>

        <p class="mt-8">デザインによっては装飾が反映されない場合がございます。</p>
    </div>
</template>

<script setup>
import Checkbox from 'primevue/checkbox'
import { ref } from 'vue'

const randomId = Math.random().toString(36).slice(6)
const model = defineModel()
const modelStyles = defineModel('styles')
const TYPES = {
    CLIP_1: 1,
    CLIP_2: 2,
    CLIP_3: 3,
    CLIP_4: 4,
    CLIP_5: 5,
    CLIP_6: 6,
    CLIP_7: 7,
}
const typeChecked = ref([])

const handleChangeTypeChecked = (type) => {
    if (!typeChecked.value.length) {
        model.value = ''
        return
    }

    typeChecked.value = [type]
    switch (type) {
        case TYPES.CLIP_1:
            model.value = 'polygon(0 0, 100% 0, 90% 90%, 0 100%)'
            break
        case TYPES.CLIP_2:
            model.value = 'polygon(0 0, 90% 10%, 100% 100%, 0 100%)'
            break
        case TYPES.CLIP_3:
            model.value = 'polygon(10% 10%, 100% 0, 90% 90%, 0 100%)'
            break
        case TYPES.CLIP_4:
            model.value = 'polygon(0 0, 90% 10%, 100% 100%, 10% 90%)'
            break
        case TYPES.CLIP_5:
            model.value = 'polygon(0 10%, 100% 0, 100% 90%, 0 100%)'
            break
        case TYPES.CLIP_6:
            model.value = ''
            modelStyles.value.borderRadius = '100%'
            modelStyles.value.aspectRatio = '1'
            modelStyles.value.objectFit = 'cover'
            modelStyles.value.height = 'auto !important'
            break
        case TYPES.CLIP_7:
            model.value = ''
            modelStyles.value.borderRadius = '50% 50% 50% 70% / 50% 50% 70% 60%'
            modelStyles.value.aspectRatio = '1'
            modelStyles.value.objectFit = 'cover'
            modelStyles.value.height = 'auto !important'
            break
        default:
            model.value = ''
            break
    }
}
</script>

<style scoped>
.image-clip-demo {
    width: 20px;
    height: 20px;
    background-color: #D0D0D0;
    margin-left: .5rem;
}

.image-clip-1 {
    clip-path: polygon(0 0, 100% 0, 90% 90%, 0 100%);
}

.image-clip-2 {
    clip-path: polygon(0 0, 90% 10%, 100% 100%, 0 100%);
}

.image-clip-3 {
    clip-path: polygon(10% 10%, 100% 0, 90% 90%, 0 100%);
}

.image-clip-4 {
    clip-path: polygon(0 0, 90% 10%, 100% 100%, 10% 90%);
}

.image-clip-5 {
    clip-path: polygon(0 10%, 100% 0, 100% 90%, 0 100%);
}

.image-clip-6 {
    border-radius: 100%;
    aspect-ratio: 1;
}

.image-clip-7 {
    border-radius: 50% 50% 50% 70% / 50% 50% 70% 60%;
    aspect-ratio: 1;
}
</style>
