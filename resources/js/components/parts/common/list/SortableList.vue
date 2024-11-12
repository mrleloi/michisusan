<template>
  <table class="table-auto">
    <thead>
      <tr>
        <th v-if="actions.includes('selectable')">&nbsp;</th>
        <th v-if="actions.includes('sortable')">並替</th>
        <th v-for="value in columns" v-bind:key="value">
          {{ value }}
        </th>
        <th v-if="actions.includes('detail')">詳細</th>
        <th v-if="actions.includes('history')">履歴</th>
        <th v-if="actions.includes('copy')">複製</th>
        <th v-if="actions.includes('showpreview')">表示</th>
        <th v-if="actions.includes('edit')">編集</th>
        <th v-if="actions.includes('delete')">削除</th>
      </tr>
    </thead>
    <draggable
      v-model="list"
      tag="tbody"
      item-key="id"
      handle=".handle"
      :disabled="!actions.includes('sortable')"
      @end="onDragEnd"
    >
      <template #item="{ element }">
        <tr>
          <td
            v-if="actions.includes('selectable')"
            class="text-center w-10 one-line-header"
          >
            <Checkbox
              name="checks[]"
              v-model="checks"
              :value="element.id"
              :disabled="disableCheck && element[disableCheck] > 0"
            ></Checkbox>
          </td>
          <td
            v-if="actions.includes('sortable')"
            class="text-center w-14 one-line-header"
          >
            <i class="pi pi-sort-alt handle cursor-grab"></i>
          </td>
          <td
            v-for="(columnFormat, valuePath) in cColumns"
            v-bind:key="valuePath"
            :class="columnFormat.format"
          >
            <template v-if="columnFormat.format.includes('comma_num')">
              {{
                parseInt(getValueByPath(element, valuePath)).toLocaleString()
              }}
            </template>
            <template v-else-if="columnFormat.format.includes('visible')">
              <div class="text-center">
                {{
                  getValueByPath(element, valuePath) == 1 ? '表示' : '非表示'
                }}
              </div>
            </template>
            <template v-else-if="columnFormat.format.includes('image')">
              <Image
                v-if="getValueByPath(element, valuePath)"
                :src="/storage/ + getValueByPath(element, valuePath)"
                width="100"
                height="100"
                preview
                class="text-center"
              ></Image>
            </template>
            <template v-else-if="columnFormat.format.includes('htmlpreview')">
              {{ htmlPreview(getValueByPath(element, valuePath)) }}
            </template>
            <template v-else>
              {{ getValueByPath(element, valuePath) }}
            </template>
          </td>
          <td
            v-if="actions.includes('detail')"
            class="text-center w-28"
            :class="'buttons-' + buttonRowsCount"
          >
            <a :href="`${items.path}/${element.id}`">
              <PvButton size="small" label="詳細" rounded></PvButton>
            </a>
          </td>
          <td
            v-if="actions.includes('history')"
            class="text-center w-28"
            :class="'buttons-' + buttonRowsCount"
          >
            <a :href="`${items.path}/${element.id}/history`">
              <PvButton size="small" label="履歴" rounded></PvButton>
            </a>
          </td>
          <td
            v-if="actions.includes('copy')"
            class="text-center w-28"
            :class="'buttons-' + buttonRowsCount"
          >
            <a :href="`${items.path}/${element.id}/copy`">
              <PvButton size="small" label="複製" rounded></PvButton>
            </a>
          </td>
          <td
            v-if="actions.includes('showpreview')"
            class="text-center w-28"
            :class="'buttons-' + buttonRowsCount"
          >
          <PvButton size="small" label="表示" rounded @click="showPreview(element.id)"></PvButton>
          </td>
          <td
            v-if="actions.includes('edit')"
            class="text-center w-28"
            :class="'buttons-' + buttonRowsCount"
          >
            <a :href="`${items.path}/${element.id}/edit`">
              <PvButton size="small" label="編集" rounded></PvButton>
            </a>
          </td>
          <td
            v-if="actions.includes('delete')"
            class="text-center w-28"
            :class="'buttons-' + buttonRowsCount"
          >
            <form
              :action="`${items.path}/${element.id}`"
              method="post"
              @submit="onBeforeDelete($event, itemName ?? element.name)"
            >
              <input type="hidden" name="_method" value="DELETE" />
              <input type="hidden" name="_token" v-bind:value="csrfToken" />
              <PvButton
                type="submit"
                size="small"
                label="削除"
                :disabled="disableDelete && element[disableDelete] > 0"
                rounded
              ></PvButton>
            </form>
          </td>
        </tr>
      </template>
    </draggable>
  </table>
</template>

<script setup>
import { ref } from 'vue'
import { useAPI } from '@/composables/api'
import Checkbox from 'primevue/checkbox'
import Image from 'primevue/image'
import draggable from 'vuedraggable'

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
    default: ['edit', 'delete', 'selectable', 'sortable']
  },
  csrfToken: {
    type: String,
    required: false
  },
  disableCheck: {
    type: String
  },
  disableDelete: {
    type: String
  },
  itemName: {
    type: String
  }

})

const checks = ref()
const list = ref([...props.items.data])
const api = useAPI()

const htmlPreview = html => {
  try {
    const root = new DOMParser().parseFromString(html, 'text/html')

    return root.body.textContent
  } catch (e) {
    return ''
  }
}

const onDragEnd = event => {
  const fromId = list.value[event.oldIndex].id
  const toId = list.value[event.newIndex].id

  const listType = props.items.path
    .substr(props.items.path.lastIndexOf('/'))
    .replace('/', '')

  api.list.changeOrder(listType, fromId, toId).catch(e => {
    alert('順番の変更が正しく行われませんでした')
  })
}

const onBeforeDelete = (event, name) => {
  if (!confirm(name + 'を削除してよろしいですか？')) {
    event.preventDefault()
  }
}

const convertColumns = columns => {
  const r = Object.keys(columns).reduce((a, v) => {
    const s = v.split(':')

    a[s[0]] = { name: columns[v], format: s.length == 2 ? s[1].split(',') : [] }
    return a
  }, {})

  return r
}

const buttonRowsCount = (() =>
  ['delete', 'edit', 'copy', 'history', 'detail', 'showpreview'].filter(i => props.actions.includes(i)).length)()

const getValueByPath = (obj, path, $lv = 1) => {
  const paths = path.split(':')
  const keys = paths[0].split('.')
  let current = obj

  for (let key of keys) {
    if (key === '*') {
      if (Array.isArray(current)) {
        return current.map(item =>
          getValueByPath(item, keys.slice($lv).join('.'))
        )
      } else {
        return undefined // '*'の時点で配列がなければundefinedを返す
      }
    }

    if (!current[key]) {
      return undefined // 存在しないキーの場合はundefinedを返す
    }

    current = current[key] // 次のネストに移動
    $lv++
  }

  return current
}

const showPreview = () => {
  alert("プレビュー開発中")
}

const cColumns = convertColumns(props.columns)
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}
table th {
  padding: 10px;
  background: #6366f1;
  border: solid 1px #c4cbef;
  color: #fff;
}
table td {
  padding: 0.5rem;
  border: solid 1px #c4cbef;
}
table td.image {
  text-align: center;
}

table td.visible,
table th.visible {
  width: 6rem;
}

@media screen and (max-width: 550px) {
  table tr {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 1rem;
    border-bottom: solid 1px #c4cbef;
    border-right: solid 1px #c4cbef;
  }

  table td {
    display: flex;
    align-items: center;
    width: 100%;
    border-bottom: none;
    border-right: none;
  }

  table td.text-center {
    width: 100%;
    justify-content: center;
  }

  table td.text-center.one-line-header {
    width: 100%;
    background-color: #eee;
  }

  table td.buttons-3 {
    width: calc(100% / 3);
  }

  table thead {
    display: none;
  }

  table td.visible,
  table th.visible {
    width: 100%;
  }
}
</style>
