<template>
    <div v-if="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        {{ errorMessage }}
    </div>
    <table class="table-auto">
        <thead>
        <th v-if="actions.includes('bulk_delete')">&nbsp;</th>
        <th>テンプレート名 </th>
        <th>テンプレートを使用</th>
        </thead>
        <draggable
            v-model="list"
            tag="tbody"
            item-key="id"
            handle=".handle"
            :disabled="isReordering || !actions.includes('sortable') || disableSortable"
            @start="onDragStart"
            @end="onDragEnd"
        >
            <template #item="{ element }">
                <tr>
                    <td v-if="actions.includes('bulk_delete')">
                        <Checkbox :name="`checks[]`" v-model="checks" :value="element.id"
                        ></Checkbox>
                    </td>
                    <td>
                        {{ element['name'] }}
                    </td>
                    <td class="text-center">
                        <a  :href="`${items.path}/${element.id}/add`">
                            <PvButton size="small" label="編集" rounded>テンプレートを使用</PvButton>
                        </a>
                    </td>
                </tr>
            </template>
        </draggable>
    </table>
</template>

<script setup>
import { ref } from 'vue'
import PvButton from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import draggable from 'vuedraggable'
import { useAPI } from '@/composables/api'

const props = defineProps({
    items: {
        type: Object,
        required: true
    },
    columns: {
        type: Object,
        required: true
    },
    actions: {
        type: Array,
        required: false,
        default: ['edit', 'delete', 'bulk_delete', 'sortable']
    },
    csrfToken: {
        type: String,
        required: true
    },
    disableSortable: {
        type: Boolean,
        default: false
    }
})

const rows = ref(20)
const checks = ref()
const list = ref([...props.items.data])
const isReordering = ref(false)
const isDragging = ref(false)
const errorMessage = ref('')

const api = useAPI()
const originalList = ref(false)

const onDragStart = () => {
    isDragging.value = true
    errorMessage.value = ''
    originalList.value = [...list.value]
}

const onDragEnd = async () => {
    if (isReordering.value || props.disableSortable) return

    isReordering.value = true
    const newOrder = list.value.map((item, index) => ({
        id: item.id,
        index: index,
        order: item.order
    }))

    try {
        await api.blogsCategories.changeOrder({ items: newOrder })
        errorMessage.value = ''
    } catch (error) {
        list.value = originalList.value
        errorMessage.value = '順序の更新中にエラーが発生しました。'
    } finally {
        isReordering.value = false
        isDragging.value = false
    }
}

const onDelete = (event, category) => {
    const { name } = category
    if (confirm(`${name}を削除してよろしいですか？`)) {
        event.target.submit()
    }
}
</script>

<style scoped>
table {
    width: 100%;
    text-align: center;
    border-collapse: collapse;
}
table th {
    padding: 10px;
    background: #6366f1;
    border: solid 1px #c4cbef;
    color: #fff;
}
table td {
    padding: 0.2rem;
    border: solid 1px #c4cbef;
}
</style>
