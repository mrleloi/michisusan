<template>
    <div class="py-6">
        <div class="grid grid-cols-3">
            <div
                v-for="(item, index) in list"
                :key="index"
                class="border p-2 relative group flex flex-col items-center"
            >
                <div class="self-start pt-1 opacity-100">
                    <Checkbox
                        name="checks[]"
                        v-model="checks"
                        :value="item.id"
                    ></Checkbox>
                </div>

                <div
                    class="h-[280px] w-[95%] relative bg-cover bg-center mt-6 mb-8 group"
                    :style="{ backgroundImage: `url(${'/storage/' + item.filename})` }" @click="showImage(item)"
                >
                    <div
                        class="absolute inset-0 bg-white/100 transition-opacity opacity-0 group-hover:opacity-70 group-hover:backdrop-blur-sm"
                    ></div>

                    <div
                        class="absolute inset-0 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity"
                    >
                        <button
                            @click.stop="editItem(item.id)"
                            class="text-gray-700 hover:text-blue-700 mx-2"
                        >
                            <i class="pi pi-pen-to-square" style="font-size: 1.2rem"></i>
                        </button>
                        <form :action="`${items.path}/${item.id}/delete`" method="POST" @submit.prevent="onDelete($event)">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <button @click.stop class="text-gray-700 hover:text-red-700 mx-4"><i class="pi pi-times" style="font-size: 1.2rem"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Modal for Enlarged Image -->
                <div v-if="isModalVisible" class="fixed inset-0 bg-black/70 flex justify-center items-center z-50">
                    <div>
                        <img :src="enlargedImageUrl" alt="Enlarged Image" class="max-h-[90vh] max-w-[90vw] rounded shadow-lg" />
                        <button @click="closeModal" class="absolute top-2 right-8 text-white text-[62px]">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import Checkbox from 'primevue/checkbox'

const props = defineProps({
    items: {
        type: Object,
        required: true
    },
    actions: {
        type: Array,
        required: false,
        default: ['edit', 'delete', 'selectable']
    },
    csrfToken: {
        type: String,
        required: false
    }
})

const checks = ref()
const list = ref([...props.items.data])
const isModalVisible = ref(false)
const enlargedImageUrl = ref('')

function showImage(item) {
    enlargedImageUrl.value = `/storage/${item.filename}`;
    isModalVisible.value = true;
}

function closeModal() {
    isModalVisible.value = false;
}

const editItem = (index) => {
    window.location.href = `${props.items.path}/${index}/edit `
}

const onDelete = (event) => {
    if (confirm(`を削除してよろしいですか？`)) {
        event.target.submit()
    }
}
</script>

<style scoped>
</style>
