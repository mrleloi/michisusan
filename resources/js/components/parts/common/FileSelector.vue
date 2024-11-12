<template>
    <div class="flex gap-6">
        <slot>
            <label
                :for='name'
                class="text-sm font-bold text-white bg-[#3B82F6] px-4 py-2.5 rounded-full cursor-pointer">
                ファイルを選択
            </label>
        </slot>
        <p class="flex items-center gap-4">
            <span class="text-sm font-medium">{{ fileUpload?.name || '選択されていません' }}</span>
            <span v-if="fileUpload" class="text-[1.5rem] cursor-pointer" @click="clearFileUpload">&times;</span>
        </p>
        <input
            type='file'
            :id='name'
            :name="name"
            :accept='accept'
            class='hidden'
            @change="onChangeFile"
            ref="inputFileRef">
    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    accept: {
        type: String,
        required: false,
        default: '*/*'
    },
    name: {
        type: String,
        required: true
    },
    maxSize: {
        type: Number,
        required: false,
        default: 10
    }
})

const fileUpload = ref(null)
const inputFileRef = ref(null)

const onChangeFile = (event) => {
    const file = event.target.files[0]

    if (!file) {
        return
    }

    const maxSizeBytes = props.maxSize * 1024 * 1024
    if (file.size > maxSizeBytes) {
        alert(`ファイルの容量は${props.maxSize}MBまでです`)
        return
    }

    fileUpload.value = file
}

const clearFileUpload = () => {
    fileUpload.value = null
    if (inputFileRef.value) {
        inputFileRef.value.value = '' // Reset input file
    }
}

</script>
