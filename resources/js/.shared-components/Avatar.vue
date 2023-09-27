<script setup>
import { computed } from 'vue'
import {
  AvatarRoot as Root,
  AvatarImage as Image,
  AvatarFallback as Fallback
} from "radix-vue"

const props = defineProps({
  name: String,
  size: {
    type: [String, Number],
    default: 45,
  },
  fontSize: {
    type: [String,Number],
    default: 15,
  }
})

const acronym = computed(() => {
  const data = props.name.split(/\s/)

  return [
    data[0].charAt(0),
    data[data.length-1].charAt(0),
  ];
})
</script>

<template>
  <Root class="avatar-root" :style="{ width: `${size}px`, height: `${size}px`, fontSize: `${fontSize}px` }">
    <Fallback class="avatar-fallback">{{ acronym.join('') }}</Fallback>
  </Root>
</template>

<style scoped lang="scss">
.avatar-root {
  width: 45px;
  height: 45px;

  @apply
    inline-flex
    select-none
    items-center
    justify-center
    overflow-hidden
    rounded-full
    text-blue-600
    align-middle;

  .avatar-fallback {
    @apply
      flex
      h-full
      w-full
      items-center
      justify-center
      bg-blue-100
      font-semibold;
  }
}
</style>
