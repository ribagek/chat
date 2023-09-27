import { ref, watch } from 'vue'
import { createGlobalState } from '@vueuse/core'
import { useDialog } from '@utils'

export default createGlobalState(() => {
  const { data: dialog } = useDialog()
  const visible = ref(false)

  const node = ref(null)

  const show = () => {
    visible.value = true
  }

  const hide = () => {
    visible.value = false
  }

  const events = {
    blur: () => {
      if (node.value) {
        node.value.focus()
      }
    },
    keydown: (e) => {
      if (e.key == 'Escape' && dialog.chat == null) {
        hide()
      }
    }
  }

  watch(node, node => {
    if (node) {
      node.focus()
    }
  })

  return {
    visible,
    node,
    show,
    hide,
    events,
  }
})
