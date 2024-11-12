<template>
    <div>
        <PvPaginator
            :rows="items.per_page"
            :totalRecords="items.total"
            :first="(items.current_page - 1) * items.per_page"
            @page="onPageChange"
        ></PvPaginator>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import PvPaginator from 'primevue/paginator'

const props = defineProps({
    items: {
        type: Object,
        required: true
    }
})

const onPageChange = (event) => {
    const page = event.page + 1
    const url = new URL(window.location.href)

    url.searchParams.set('page', page)

    window.location.href = url.toString()
}
</script>
