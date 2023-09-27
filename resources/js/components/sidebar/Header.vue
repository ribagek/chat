<script setup>
import useSearch from '../../utils/search'
import HeaderSearch from './HeaderSearch.vue'
import HeaderContent from './HeaderContent.vue'

const { visible: isSearchVisible } = useSearch()
</script>

<template>
  <div class="header relative">
    <Transition>
      <HeaderSearch v-if="isSearchVisible" />
    </Transition>

    <HeaderContent />
  </div>
</template>

<style scoped lang="scss">
  .header {
    width: 100%;
    height: 44px;

    @apply
      flex
      items-center
      border-b
      justify-between
      border-slate-100;
  }

  .v-enter-active,
  .v-leave-active {
    transition: opacity 0.3s ease;
  }

  .v-enter-from,
  .v-leave-to {
    opacity: 0;
  }
</style>
