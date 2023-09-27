import { ref, watch } from 'vue'
import { createGlobalState } from '@vueuse/core'
import { useDialog, useSidebarTabs } from '@utils'

export default createGlobalState(() => {
  const { chatData: dialog } = useDialog()
  const visible = ref(false)

  const node = ref(null)
  const searchVal = ref(null)


  const show = () => {
    visible.value = true;
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
    change: (e) => {
      searchVal.value = e.target.value
    },
    keydown: (e) => {
      if (e.key == 'Escape' && dialog.chat == null) {
        hide()
      }
      if (e.key == 'Enter') {
        searchVal.value = e.target.value
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
    searchVal,
    show,
    hide,
    events,
  }
})
