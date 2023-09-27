<script setup>
import Sidebar from './components/Sidebar.vue'
import Dialog from './components/Dialog.vue'
import { useCloak } from "@utils";

const { detailsVisible } = useCloak();

const keydownEvent = (e) => {
  if (e.key == ',') {
    detailsVisible.value = true
  }
  if (e.key == '.') {
    detailsVisible.value = false
  }
}

const toggleFavouriteEventHandler = (chat_id, isFav) => {
  console.log('chat_id, isFav', chat_id, isFav);
}
</script>

<template>
  <Head title="Chat" />

  <Card class="chat-root" @keydown="keydownEvent">
    <Sidebar />
    
    <Dialog @toggleFavouriteEvent="toggleFavouriteEventHandler" />
<!--    <div
      v-if="detailsVisible"
      class="z-10 absolute top-0 left-0 w-full h-full bg-black opacity-30"
      @click="detailsVisible = false"
    ></div>-->
  </Card>
</template>

<style scoped lang="scss">
.chat-root {
  @apply
    grid
    max-md:top-[56px]
    max-md:left-0
    max-md:fixed
    max-md:w-full
    max-md:h-[calc(100dvh-56px)]
    max-md:border-t
    max-md:border-slate-100
    md:grid-cols-[287px,1fr]
    max-md:shadow-none
    max-md:rounded-none;
}
</style>
