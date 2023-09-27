import { createGlobalState } from '@vueuse/core'
import { reactive, ref } from 'vue'

export default createGlobalState(() => {
  const data = reactive({
    chat: null,
    messages: [
      // ..
    ]
  })

  const show = (chat) => {
    data.chat = chat
  }

  document.addEventListener('keydown', e => {
    if (e.key == 'Escape') {
      data.chat = null
    }
  })

  return {
    data,
    show,
  }
})
