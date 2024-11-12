<template>
  <blockquote
    class="tiktok-embed"
    :cite="`${src}`"
    :data-unique-id="userId.substr(2)"
    data-embed-from="embed_page"
    data-embed-type="creator"
    style="max-width: 780px; min-width: 288px"
  >
    <section>
      <a target="_blank" :href="`${src}?refer=creator_embed`">{{
        userId.substr(1)
      }}</a>
    </section>
  </blockquote>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  url: String
})

const src = ref('')
const userId = ref('')

const init = ({ url }) => {
  src.value = url

  const s = document.createElement('script')
  s.src = 'https://www.tiktok.com/embed.js'
  const ele = document.getElementById('app')
  ele.appendChild(s)

  userId.value = new URL(url).pathname
}

init(props)
</script>
