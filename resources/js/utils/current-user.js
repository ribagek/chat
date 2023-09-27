import { useStore } from 'vuex'
import { computed } from 'vue'

export default () => {
  const store = useStore()

  return computed(() => store?.getters?.currentUser)
}
