<script setup>
import Header from './sidebar/Header.vue'
import SidebarContent from './sidebar/SidebarContent.vue'
</script>

<template>
  <div class="sidebar">
    <Header />

    <SidebarContent />
  </div>
</template>

<style scoped lang="scss">
.sidebar {
  @apply
    md:w-72
    h-[calc(100vh-56px)]
    md:h-[calc(100vh-192px)]
    md:border-r
    md:border-slate-100;
}
</style>
