<template>
    <div class="flex justify-center gap-5 sticky bottom-0 bg-white py-5 z-10">
        <a
            class="text-white bg-[#FF3D32] w-[174px] h-[40px] text-sm font-bold rounded-full flex justify-center items-center"
            :href="backPath">
            {{textBackBtn }}
        </a>

        <button
            class="text-white bg-[#4CD07D] w-[174px] h-[40px] text-sm font-bold rounded-full"
            type="submit">
            登録
        </button>
    </div>
</template>

<script setup>
defineProps({
    backPath: {
        type: String,
        required: false,
        default: '/admin'
    },
    textBackBtn: {
        type: String,
        required: false,
        default: ' 一覧に戻る '
    },
})
</script>

<style scoped>

</style>
