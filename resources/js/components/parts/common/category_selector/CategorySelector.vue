<template>
  <div class="flex gap-5 w-full flex-wrap">
    <div class="flex-1 selector" v-if="multiple">
      <MultiSelect
        v-bind="$attrs"
        v-model="value"
        :options="options"
      ></MultiSelect>
    </div>
    <div class="flex-1 selector" v-else>
      <Select v-bind="$attrs" v-model="value" :options="options"></Select>
    </div>

    <div class="flex-0 flex items-center">
      <pv-button
        label="カテゴリー新規作成"
        rounded
        @click="loadComponent"
      ></pv-button>
    </div>
  </div>

  <template v-if="multiple">
    <template v-for="v in value" v-bind:key="v">
      <input type="hidden" :name="name" :value="v" />
    </template>
  </template>
  <template v-else>
    <input type="hidden" :name="name" :value="value" />
  </template>

  <component :is="dialog" ref="dc" @registered="onRegistered" />
</template>

<script setup>
import MultiSelect from 'primevue/multiselect'
import Select from 'primevue/select'
import { ref, shallowRef, nextTick } from 'vue'

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  value: {
    type: [Number, String, Array]
  },
  options: {
    type: Object
  },
  dialog_component: {
    type: String
  },
  multiple: {
    type: Boolean,
    default: false
  }
})

const loadComponent = async () => {
  dialog.value = (await import(`../category_selector/${props.dialog_component}.vue`)).default
  await nextTick()
  dc.value.show()
}

const onRegistered = res => {
  const name = res.name
  const id = res.id

  options.value.push({ id, name })
  if (props.multiple) {
    value.value.push(id)
  } else {
    value.value = id
  }
}

const value = ref(props.value)
const options = ref(props.options)
const dialog = shallowRef()
const dc = ref(null)
</script>
