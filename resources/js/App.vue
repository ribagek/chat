<script setup>
import Sidebar from './components/Sidebar.vue'
import Dialog from './components/Dialog.vue'
</script>

<template>
  <Head title="Chat" />

  <Card class="chat-root">
    <Sidebar />
    
    <Dialog />
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
