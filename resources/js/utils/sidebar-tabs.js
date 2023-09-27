import { createGlobalState } from '@vueuse/core'
import { ref } from 'vue'
import componentResolver from './sidebar-tabs/component-resolver'

export default createGlobalState(() => {
  const list = [
    { label: 'Все', value: 'all' },
    { label: 'Неотвеченные', value: 'unanswered' },
    { label: 'Важные', value: 'favorites' },
  ]

  const active = ref('all')

  const component = componentResolver(active)

  const change = (tab) => {
    active.value = tab
  }

  return {
    list,
    active,
    component,
    change,
  }
})
