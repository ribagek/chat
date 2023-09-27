<script setup>
import { useSidebarTabs } from '@utils'

const { component } = useSidebarTabs()
</script>

<template>
  <div>
    <component :is="component" />
  </div>
</template>
