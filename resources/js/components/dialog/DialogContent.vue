<script setup>
import Header from './Header.vue'
import MessagesList from './MessagesList.vue'
import Footer from './Footer.vue'

const props = defineProps({
  messages: Array,
  meta: Array,
});

</script>

<template>
  <div class="dialog-content h-full">
    <Header />

    <div class="flex flex-col h-[calc(100dvh-69px)] md:h-[calc(100vh-293px)]">
      <MessagesList :mess="messages" :meta="meta" />

      <Footer :mess="messages" class="mt-auto" />
    </div>
  </div>
</template>

<style scoped lang="scss">
.dialog-content {
  @apply relative max-md:z-50 max-md:fixed max-md:top-0 max-md:left-0 max-md:w-full max-md:h-[100dvh] max-md:bg-white;
}
</style>
