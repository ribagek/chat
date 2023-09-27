import { createGlobalState } from '@vueuse/core'
import { ref } from "vue";

export default createGlobalState(() => {
  const detailsVisible = ref(false);

  return {
    detailsVisible
  }
})
