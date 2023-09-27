<script setup>
import { ref } from 'vue'
import Header from './Header.vue'
import MessagesList from './MessagesList.vue'
import Footer from './Footer.vue'

const messages = ref([])
</script>

<template>
  <div class="dialog-content">
    <Header />

    <div class="flex flex-col h-[calc(100dvh-69px)] md:h-[calc(100vh-293px)]">
      <MessagesList :mess="messages" />

      <Footer :mess="messages" class="mt-auto" />
    </div>
  </div>
</template>

<style scoped lang="scss">
.dialog-content {
  @apply relative max-md:z-50 max-md:fixed max-md:top-0 max-md:left-0 max-md:w-full max-md:h-[100dvh] max-md:bg-white;
}
</style>
