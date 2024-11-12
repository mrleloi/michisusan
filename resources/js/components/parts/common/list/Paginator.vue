<template>
  <div>
    <PvPaginator
      :rows="items.per_page"
      :totalRecords="items.total"
      :first="items.from"
      @page="onPage"
    ></PvPaginator>
  </div>
  <div class="text-center mb-10">
    {{ items.total }}件中{{ items.from }}〜{{ items.to }}件を表示
  </div>
</template>

<script setup>
import PvPaginator from 'primevue/paginator'

const props = defineProps({
  items: {
    type: Object,
    required: true
  }
})

const onPage = e => {
  const url = new URL(window.location.href)

  url.searchParams.delete('page')
  url.searchParams.append('page', e.page + 1)
  location.href = url
}
</script>
