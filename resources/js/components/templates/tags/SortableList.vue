<template>
    <div v-if="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        {{ errorMessage }}
    </div>
    <table class="table-auto">
        <thead>
        <th v-if="actions.includes('bulk_delete')">&nbsp;</th>
        <template v-if="!disableSortable">
            <th v-if="actions.includes('sortable')">並替</th>
        </template>
        <th v-for="(value, column) in columns" v-bind:key="column[0]">
            {{ value }}
        </th>
        <th v-if="actions.includes('copy')">複製</th>
        <th v-if="actions.includes('edit')">編集</th>
        <th v-if="actions.includes('delete')">削除</th>
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
                    <template v-if="!disableSortable">
                        <td v-if="actions.includes('sortable')">
                            <i class="pi pi-sort-alt handle" :data-order="`${element.order}`"></i>
                        </td>
                    </template>
                    <td v-for="(value, column) in columns" v-bind:key="value">
                        {{ element[column] }}
                    </td>
                    <td v-if="actions.includes('copy')" class="text-center">
                        <a :href="`${items.path}/${element.id}/copy`">
                            <PvButton size="small" label="複製" rounded></PvButton>
                        </a>
                    </td>
                    <td v-if="actions.includes('edit')" class="text-center">
                        <a :href="`${items.path}/${element.id}/edit`">
                            <PvButton size="small" label="編集" rounded></PvButton>
                        </a>
                    </td>
                    <td v-if="actions.includes('delete')" class="text-center">
                        <form :action="`${items.path}/${element.id}/delete`" method="POST" @submit.prevent="onDelete($event, element)">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <PvButton type="submit" size="small" label="削除" rounded></PvButton>
                        </form>
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
        await api.tags.changeOrder({ items: newOrder })
        errorMessage.value = ''
    } catch (error) {
        list.value = originalList.value
        errorMessage.value = '順序の更新中にエラーが発生しました。'
    } finally {
        isReordering.value = false
        isDragging.value = false
    }
}

const onDelete = (event, tag) => {
    const { name } = tag
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
