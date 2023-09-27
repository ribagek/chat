<script setup>
import Header from './sidebar/Header.vue'
import SidebarContent from './sidebar/SidebarContent.vue'
import { useCloak } from "@utils";

const { detailsVisible } = useCloak();
</script>

<template>
  <div class="sidebar relative">
    <Header />

    <SidebarContent />

    <div
      v-if="detailsVisible"
      class="absolute top-0 left-0 w-full h-full bg-black opacity-30 rounded-l-lg"
      style="z-index: 10;"
      @click="detailsVisible = false"
    ></div>
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
