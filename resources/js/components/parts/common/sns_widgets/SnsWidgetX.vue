<template>
  <div style="width: 500px">
    <a class="twitter-timeline" data-lang="ja" :href="src">
      Tweets by {{ userId.substring(1) }}
    </a>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  url: String
})

const src = ref('')
const userId = ref('')

const init = ({ url }) => {
  const u = new URL(url)
  userId.value = u.pathname
  src.value = `https://twitter.com${userId.value}?ref_src=twsrc%5Etfw`
  twttr.widgets.load()
}

init(props)
</script>
