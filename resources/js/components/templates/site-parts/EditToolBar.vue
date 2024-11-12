<template>
  <ul class="absolute right-0 flex z-20" style="background: rgba(97, 105, 169, 1)">
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <img
        v-if="attributes.containerFullSize"
        src="/img/compress-solid.svg"
        class="w-[16px]"
        @click="
          $emit(
            'update',
            index,
            'containerFullSize',
            !attributes.containerFullSize
          )
        "
      />
      <img
        v-else
        src="/img/expand-solid.svg"
        class="w-[16px]"
        @click="
          $emit(
            'update',
            index,
            'containerFullSize',
            !attributes.containerFullSize
          )
        "
      />
    </li>
    <li
      class="flex justify-center items-center p-2 cursor-pointer"
      @click="containerWidth.toggle"
    >
      <img src="/img/arrows-left-right-to-line-solid.svg" class="w-[16px]" />
      <Popover ref="containerWidth">
        <ul class="list-none p-0 m-0 flex flex-col">
          <li
            v-for="s in widthSize"
            class="flex items-center gap-2 px-2 py-3 hover:bg-emphasis cursor-pointer rounded-border"
            @click="selectContainerWidth(s)"
          >
            {{ s }}
          </li>
        </ul>
      </Popover>
    </li>
    <li
      class="flex justify-center items-center p-2 cursor-pointer"
      @click="textColorPicker.toggle"
    >
      <img src="/img/font-solid.svg" class="w-[16px]" />

      <Popover ref="textColorPicker">
        <ColorPicker
          v-model="textColor"
          appendTo="self"
          @change="$emit('update', index, 'textColor', `#${textColor}`)"
          inline
        />
      </Popover>
    </li>
    <li
      class="flex justify-center items-center p-2 cursor-pointer"
      @click="bgColorPicker.toggle"
    >
      <img src="/img/palette-solid.svg" class="w-[16px]" />

      <Popover ref="bgColorPicker">
        <ColorPicker
          v-model="bgColor"
          appendTo="self"
          @change="$emit('update', index, 'backgroundColor', `#${bgColor}`)"
          inline
        />
      </Popover>
    </li>
    <li
      class="flex justify-center items-center p-2 cursor-pointer"
      @click="$emit('update', index, 'backgroundImage', '')"
    >
      <i class="pi pi-palette p-2 text-white cursor-pointer" />
    </li>
    <li
      class="flex justify-center items-center p-2 cursor-pointer"
      @click="paddingTop.toggle"
    >
      <img src="/img/arrows-up-to-line-solid.svg" class="w-[16px]" />
      <Popover ref="paddingTop">
        <ul class="list-none p-0 m-0 flex flex-col">
          <li
            v-for="s in paddingSize"
            class="flex items-center gap-2 px-2 py-3 hover:bg-emphasis cursor-pointer rounded-border"
            @click="selectPaddingTop(s)"
          >
            {{ s }}
          </li>
        </ul>
      </Popover>
    </li>
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <img
        src="/img/arrows-down-to-line-solid.svg"
        class="w-[16px]"
        @click="paddingBottom.toggle"
      />
      <Popover ref="paddingBottom">
        <ul class="list-none p-0 m-0 flex flex-col">
          <li
            v-for="s in paddingSize"
            class="flex items-center gap-2 px-2 py-3 hover:bg-emphasis cursor-pointer rounded-border"
            @click="selectPaddingBottom(s)"
          >
            {{ s }}
          </li>
        </ul>
      </Popover>
    </li>
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <i
        class="pi pi-stopwatch p-2 text-white cursor-pointer"
        @click="fadein.toggle"
      />
      <Popover ref="fadein">
        <ul class="list-none p-0 m-0 flex flex-col">
          <li
            v-for="f in fadeinDirection"
            :key="f.key"
            class="flex items-center gap-2 px-2 py-3 hover:bg-emphasis cursor-pointer rounded-border"
            @click="selectFadein(f.key)"
          >
            {{ f.label }}
          </li>
        </ul>
      </Popover>
    </li>
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <i
        class="pi pi-flag-fill p-2 text-white cursor-pointer"
        @click="anchor.toggle"
      />

      <Popover ref="anchor">
        <InputText
          v-model="anchorName"
          @change="$emit('update', index, 'anchor', anchorName)"
          placeholder="アンカー名を入力"
        ></InputText>
      </Popover>
    </li>
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <i
        class="pi pi-cog p-2 text-white cursor-pointer"
        @click="$emit('changeParts')"
      />
    </li>
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <i
        class="pi pi-clone p-2 text-white cursor-pointer"
        @click="$emit('duplicate')"
      />
    </li>
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <i class="pi pi-bars p-2 text-white cursor-pointer handle" />
    </li>
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <i
        class="pi pi-heart-fill p-2 text-white cursor-pointer"
        @click="$emit('like')"
      />
    </li>
    <li class="flex justify-center items-center p-2 cursor-pointer">
      <i
        class="pi pi-trash p-2 text-white cursor-pointer"
        @click="$emit('remove')"
      />
    </li>
  </ul>
</template>

<script setup>
import { ref } from 'vue'
import ColorPicker from 'primevue/colorpicker'
import Popover from 'primevue/popover'
import InputText from 'primevue/inputtext'

const emit = defineEmits([
  'update',
  'duplicate',
  'remove',
  'like',
  'changeParts'
])
const props = defineProps({
  index: Number,
  attributes: Object
})

const bgColorPicker = ref()
const textColorPicker = ref()
const containerWidth = ref()
const paddingTop = ref()
const paddingBottom = ref()
const fadein = ref()
const anchor = ref()

const bgColor = ref('')
const textColor = ref('')
const anchorName = ref('')

const selectContainerWidth = value => {
  emit('update', props.index, 'containerWidth', value)
  containerWidth.value.hide()
}

const selectPaddingTop = value => {
  emit('update', props.index, 'paddingTop', value)
  containerWidth.value.hide()
}

const selectPaddingBottom = value => {
  emit('update', props.index, 'paddingBottom', value)
  containerWidth.value.hide()
}
const selectFadein = value => {
  emit('update', props.index, 'fadein', value)
  containerWidth.value.hide()
}

const widthSize = ref([
  '指定なし',
  '400px',
  '500px',
  '600px',
  '700px',
  '800px',
  '900px',
  '1000px',
  '1100px',
  '1200px',
  '1300px',
  '1400px',
  '1500px',
  '1600px',
  '1700px',
  '1800px'
])

const paddingSize = ref([
  '100px',
  '90px',
  '80px',
  '70px',
  '60px',
  '50px',
  '40px',
  '30px',
  '20px',
  '10px',
  '0px'
])

const fadeinDirection = ref([
  {
    key: '',
    label: 'なし'
  },
  {
    key: 'down',
    label: '上から'
  },
  {
    key: 'right',
    label: '右から'
  },
  {
    key: 'up',
    label: '下から'
  },
  {
    key: 'left',
    label: '左から'
  }
])
</script>
