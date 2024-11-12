<template>
  <div>
    <Image
      v-if="rValue && previewImagePath"
      :src="previewImagePath"
      class="block py-2 preview"
    ></Image>
    <div class="flex flex-wrap gap-x-16 items-baseline">
      <Button label="メディア" @click="show" class="image" rounded></Button>
      <div v-if="rValue && canDelete">
        削除: <Checkbox v-model="checked" :binary="true" />
      </div>
    </div>
  </div>
  <input v-if="rValue" type="hidden" :name="name" :value="rValue" />
  <input
    type="hidden"
    :name="deleteNameCallback(name)"
    :value="checked ? 1 : 0"
  />

  <Dialog
    v-model:visible="visible"
    pt:root:class="!border-0 !bg-white"
    pt:mask:class="backdrop-blur-sm"
    class="w-11/12"
  >
    <template #container="{ closeCallback }">
      <div
        class="bg-[#5457CD] flex justify-between items-center rounded-t-md px-4 py-2"
      >
        <span class="text-white font-bold">メディア</span>

        <div class="flex items-center gap-4">
          <Button
            label="キャンセル"
            @click="closeCallback"
            class="btn-articles btn-articles-cancel"
          />
        </div>
      </div>
      <div
        class="w-full flex bg-white overflow-y-auto py-2 justify-between px-4 my-3"
      >
        <Select
          v-model="imageCategory"
          class="flex-0 w-48"
          :options="imageCategories"
          optionLabel="name"
          optionValue="id"
          placeholder="カテゴリーを選択"
          @change="onSelectCategory"
        ></Select>
        <FileUpload
          name="file"
          mode="basic"
          class="flex-0"
          accept="image/*"
          :maxFileSize="1000000"
          :auto="true"
          customUpload
          @select="onFileSelect"
          chooseLabel="アップロード"
        ></FileUpload>
      </div>
      <div
        class="w-full h-[55vh] flex flex-col bg-white overflow-y-auto relative"
      >
        <div class="px-5 flex gap-3 flex-wrap my-2">
          <div v-if="!images.total && !loading">画像が見つかりませんでした</div>
          <Image
            v-for="image in images.data"
            v-bind:key="image.id"
            @click="onImageClick(image.id)"
            @load="onImageLoaded"
            class="glow-image"
            :class="selectedImageId == image.id ? 'glow' : ''"
          >
            <template #image>
              <img
                :src="'/storage/' + image.thumbnail_filename"
                alt="image"
                @error="onImageLoaded($event, true)"
              />
            </template>
          </Image>
        </div>
        <div
          class="absolute h-full w-full flex items-center justify-center bg-opacity-80 bg-white"
          v-if="loading"
        >
          <ProgressSpinner />
        </div>
      </div>

      <div
        class="flex items-center gap-4 bg-white py-4 px-4 justify-center h-20"
      >
        <Paginator
          v-if="images.total"
          :rows="images.per_page"
          :totalRecords="images.total"
          @page="onPageChange"
        ></Paginator>
      </div>
      <div class="flex items-center gap-4 bg-white py-4 px-4 justify-end">
        <Button
          label="削除"
          @click="onDeleteClick"
          severity="danger"
          rounded
        ></Button>
        <Button
          :disabled="!selectedImageId"
          label="選択"
          @click="onSelectClick"
          rounded
        ></Button>
      </div>
    </template>
  </Dialog>
</template>

<script setup>
import Button from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import Dialog from 'primevue/dialog'
import Select from 'primevue/select'
import Image from 'primevue/image'
import FileUpload from 'primevue/fileupload'
import Paginator from 'primevue/paginator'
import Skeleton from 'primevue/skeleton'

import ProgressSpinner from 'primevue/progressspinner'
import { onMounted, ref } from 'vue'
import { useAPI } from '@/composables/api'

const api = useAPI()

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number]
  },
  canDelete: {
    type: Boolean,
    default: true
  },
  deleteNameCallback: {
    type: Function,
    default: name => {
      return name + '_delete'
    }
  }
})

const show = async () => {
  visible.value = true
  selectedImageId.value = null
  loadImages()
  getImageCategories()
}

const loadImages = (page = 1) => {
  loading.value = true
  api.imageSelector.getImages(imageCategory.value, page).then(res => {
    images.value = res.data['image_list']
    if (!images.value.length) {
      loading.value = false
    }
  })
}

const onImageClick = id => {
  selectedImageId.value = id
}

const onImageLoaded = (e, isError = false) => {
  if (isError) {
    e.target.src = '/img/img_not_found.png'
  }
  loadedImages.value++
  if (loadedImages.value == images.value.data.length) {
    loading.value = false
  }
}

const onDeleteClick = () => {
  try {
    if (
      selectedImageId.value &&
      confirm('削除後のデータは復旧できません。よろしいですか？')
    ) {
      api.imageSelector.deleteImage(selectedImageId.value).then(() => {
        loadImages()
      })
    }
  } catch (e) {
    alert('画像を削除できませんでした')
  }
}

const onSelectClick = async id => {
  checked.value = false
  visible.value = false
  rValue.value = selectedImageId.value
  setImagePreviewUrl(rValue.value)
}

const onFileSelect = async e => {
  try {
    const formData = new FormData()

    for (let i = 0; i < e.files.length; i++) {
      formData.append('file', e.files[0])
    }
    if (imageCategory.value) {
      formData.append('image_file_category_id', imageCategory.value)
    }

    await api.imageSelector.uploadImage(formData)
    loadImages()
  } catch (e) {
    alert('アップロードできませんでした。ファイルの内容を確認してください。')
  }
}

const setImagePreviewUrl = id => {
  api.imageSelector.getImage(id).then(res => {
    if (res.data['image'] === null) {
      previewImagePath.value = null
      rValue.value = null
    } else {
      previewImagePath.value = '/storage/' + res.data['image'].filename
    }
  })
}

const getImageCategories = () => {
  api.imageSelector.getCategories().then(res => {
    imageCategories.value = res.data['image_categories']
    if (Object.keys(res.data).length !== 0) {
      imageCategories.value.unshift({ id: 0, name: 'カテゴリーを選択' })
    } else {
      imageCategories.value = [{ id: 0, name: 'カテゴリーを選択' }]
    }
  })
}

const onSelectCategory = () => {
  loadImages()
}

const onPageChange = e => {
  loadImages(e.page + 1)
}

onMounted(() => {
  if (rValue.value) {
    setImagePreviewUrl(rValue.value)
  }
})

const rValue = ref(props.value)
const selectedImageId = ref()
const previewImagePath = ref()
const imageCategories = ref([])
const imageCategory = ref(0)
const visible = ref(false)
const checked = ref(false)
const images = ref([])
const loading = ref(false)
const loadedImages = ref(0)
</script>

<style scoped>
.glow-image {
  padding: 5px;
  font-size: 16px;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  outline: none;
  transition: box-shadow 0.3s ease;
}

/* ボタンがフォーカスされたときのスタイル */
.glow-image.glow {
  box-shadow:
    0 0 10px 2px rgba(52, 152, 219, 0.8),
    0 0 20px 5px rgba(52, 152, 219, 0.5);
}

/* ボタンがホバーされたときの軽いエフェクト */
.glow-button:hover {
  background-color: #2980b9;
}

.preview :deep(img),
.glow-image :deep(img) {
  width: 200px;
  height: 200px;
  object-fit: contain;
}
</style>
