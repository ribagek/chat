<script setup>
import { ref } from 'vue'
import {
  DropdownMenuRoot,
  DropdownMenuTrigger,
  DropdownMenuPortal,
  DropdownMenuContent,
} from 'radix-vue'

const props = defineProps({
  side: {
    type: String,
    default: 'bottom'
  },
  align: {
    type: String,
    default: 'center'
  },
  sedeOffset: {
    type: Number,
    default: 0,
  },
  alignOffset: {
    type: Number,
    default: 0,
  },
})

const isVisible = ref(false)
</script>

<template>
<div>
  <DropdownMenuRoot v-model:open="isVisible" >
    <DropdownMenuTrigger>
      <slot name="trigger" />
    </DropdownMenuTrigger>

    <DropdownMenuPortal class="z-[1000]" style="z-index: 1000;">
      <DropdownMenuContent :side="side" :align="align" :side-offset="sedeOffset" :align-offset="alignOffset">
        <slot name="content" />
      </DropdownMenuContent>
    </DropdownMenuPortal>
  </DropdownMenuRoot>
</div>
</template>

<style>
[data-radix-popper-content-wrapper] {
  z-index: 1000;
}
</style>
