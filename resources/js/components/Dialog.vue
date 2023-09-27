<script setup>
import { computed } from 'vue'
import { useDialog } from '@utils'
import DialogWelcome from './dialog/DialogWelcome.vue'
import DialogContent from './dialog/DialogContent.vue'

const { data: dialog } = useDialog()

const component = computed(() => dialog.chat ? DialogContent : DialogWelcome)
</script>

<template>
  <div class="hidden md:block">
    <component :is="component" />
  </div>
  <Teleport to="#app">
    <div class="max-md:block hidden">
      <component :is="component" />
    </div>
  </Teleport>
</template>
