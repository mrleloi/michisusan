<template>
  <div
    class="w-full flex flex-col justify-center items-center staffmember"
    :class="attributes.class ?? null"
    :id="attributes.id ?? null"
    :style="[background]"
  >
    <div
      class="w-full flex flex-col justify-center"
      :class="[position]"
      :style="[containerWidth, paddingY, textColor]"
    >
      <template v-if="heading">
        <SiteParts
          :name="heading.partsType"
          v-model:attributes="heading.attributes"
          :editable="editable"
        />
      </template>

      <template
        v-for="department in itemsByDepartment"
        v-bind:key="department.id"
      >
        <div
          class="heading block_header_2"
          v-if="attributes.showDepartmentName && attributes.showType !== 'ncd'"
        >
          <h3 class="h">
            {{ department.name }}
          </h3>
          <p class="">{{ department.alias }}</p>
        </div>
        <div class="wrapper_item">
          <article
            class="pop"
            v-for="item in department.staff_members"
            v-bind:key="item.id"
          >
            <div class="inner_item">
              <div class="image">
                <a href=""
                  ><img :src="`/storage/${item.image?.filename}`" />
                </a>
              </div>
              <div class="department">
                <p class="name">{{ department.name }}</p>
              </div>
              <div class="staff-member">
                <p class="name">{{ item.name }}</p>
                <p class="another-name">{{ item.another_name }}</p>
              </div>
              追加情報: {{ item.staffMemberAdditions }}
            </div>
          </article>
        </div>
      </template>

      <template v-if="button">
        <SiteParts
          :name="button.partsType"
          v-model:attributes="button.attributes"
          :editable="editable"
        />
      </template>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import SiteParts from '../SiteParts.vue'
import { useAPI } from '@/composables/api'

const api = useAPI()

defineProps({
  editable: { type: Boolean, default: false }
})

const attributes = defineModel('attributes')

const containerWidth = computed(() => {
  if (attributes.value.containerFullSize) {
    return `width: 90%`
  }

  return `max-width: ${attributes.value.containerWidth}`
})

const paddingY = computed(() => {
  return `padding-top: ${attributes.value.paddingTop}; padding-bottom: ${attributes.value.paddingBottom};`
})

const textColor = computed(() => {
  return `color: ${attributes.value.textColor}`
})
const background = computed(() => {
  if (attributes.value?.backgroundImage) {
    return `background-image: url(${attributes.value.backgroundImage});`
  }
  return `background: ${attributes.value.backgroundColor}`
})

const heading = computed(() => {
  return attributes.value.parts?.heading
})

const button = computed(() => {
  return attributes.value.parts?.button
})

const itemsByDepartment = ref({})
const contentVisible = ref({})

onMounted(() => {
  //  const categorize = attributes.value.showType == 'ncd' ? false : true;
  const categorized = attributes.value.showType !== 'ncd'
  const itemCount =
    attributes.value.showType == 's' ? 1 : attributes.value.showCount

  api.staffMemberParts
    .getItemsByDepartment(
      categorized,
      attributes.value.departmentIds,
      attributes.value.allDepartments == true ? 1 : 0,
      itemCount
    )
    .then(res => {
      itemsByDepartment.value = res.data
    })
})
</script>

<style scoped></style>
