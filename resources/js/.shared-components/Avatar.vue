<script setup>
import { computed } from 'vue'
import {
  AvatarRoot as Root,
  AvatarImage as Image,
  AvatarFallback as Fallback
} from "radix-vue"

const props = defineProps({
  name: String,
  photo: String,
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
const avatarStyle = computed(() => {
  return 'background-image: url('+props.photo+')';
})
</script>

<template>
  <Root class="avatar-root" :style="{ width: `${size}px`, height: `${size}px`, fontSize: `${fontSize}px` }">
    <div class="avatar-bg" :style="avatarStyle" v-if="photo"></div>
    <Fallback v-else class="avatar-fallback">{{ acronym.join('') }}</Fallback>
  </Root>
</template>

<style scoped lang="scss">
.avatar-root {
  width: 45px;
  height: 45px;
  
  .avatar-bg {
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 100%;
  }

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
