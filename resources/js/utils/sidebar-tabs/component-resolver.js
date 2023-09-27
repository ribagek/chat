import { computed } from 'vue'
import AllChats from '../../components/sidebar/sidebar-content/AllChats.vue'
import UnansweredChats from '../../components/sidebar/sidebar-content/UnansweredChats.vue'
import FavoriteChats from '../../components/sidebar/sidebar-content/FavoriteChats.vue'

export default (active) => computed(() => {
  if (active.value == 'all') {
    return AllChats
  }

  if (active.value == 'unanswered') {
    return UnansweredChats
  }

  if (active.value == 'favorites') {
    return FavoriteChats
  }
})
