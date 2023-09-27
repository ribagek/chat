<script setup>
import {
  ScrollAreaRoot,
  ScrollAreaViewport,
  ScrollAreaScrollbar,
} from 'radix-vue'
import { useSidebarTabs } from '@utils'

const { list: tabs, active, change } = useSidebarTabs()
</script>

<template>
  <ScrollAreaRoot class="overflow-hidden">
    <!-- scroll viewport -->
    <ScrollAreaViewport class="w-full h-full rounded wrapper">
      <div class="filter">
        <div
        v-for="(tab, index) in tabs"
        :key="index"
        class="filter-item"
        :class="{ active: tab.value == active }"
        @click="change(tab.value)"
        >{{ tab.label }}</div>
      </div>
    </ScrollAreaViewport>

    <!-- scroll area -->
    <ScrollAreaScrollbar orientation="horizontal" />
  </ScrollAreaRoot>
</template>

<style scoped lang="scss">
:deep(.wrapper) {
  &:after {
    z-index: 100;
    position: absolute;
    top: 0;
    right: 0px;
    content: '';
    width: 10px;
    height: 100%;
    background: #fff;

    filter: blur(4px);
  }
}
  .filter {
    width: 100%;
    height: 44px;

    @apply flex px-3 items-center space-x-3 whitespace-nowrap overflow-auto;

    .filter-item {
      position: relative;
      height: 100%;
      
      @apply flex items-center cursor-pointer select-none;
    }

    .active {
      // ..
      
      &:after {
        content: '';
        position: absolute;
        bottom: 0px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #60A1DD;
      }
    }
  }
</style>
