<template>
  <iframe
    :src="src"
    width="340"
    height="500"
    style="border: none; overflow: hidden"
    scrolling="no"
    frameborder="0"
    allowfullscreen="true"
    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
  ></iframe>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  url: String,
  appId: String
})

const src = ref('')

const init = ({ url, appId }) => {
  src.value = `https://www.facebook.com/plugins/page.php?href=${url}&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=${appId}`
}

init(props)
</script>
