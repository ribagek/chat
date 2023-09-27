<script setup>
import { useSidebarTabs } from '@utils'

const { component, active, searchVal } = useSidebarTabs()
</script>

<template>
  <div>
    <component :is="component" :key="active+searchVal" />
  </div>
</template>
