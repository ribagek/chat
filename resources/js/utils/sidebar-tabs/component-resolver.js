import { computed } from 'vue'
import AllChats from '../../components/sidebar/sidebar-content/AllChats.vue'
import UnansweredChats from '../../components/sidebar/sidebar-content/UnansweredChats.vue'
import FavoriteChats from '../../components/sidebar/sidebar-content/FavoriteChats.vue'

export default (active, searchVal) => computed(() => {
    let component;
    
    if (active.value === 'all' || searchVal.value) {
      component = AllChats
    } else if (active.value === 'unanswered') {
      component = UnansweredChats
    } else if (active.value === 'favorites') {
      component = FavoriteChats
    }
    
    return component
})
