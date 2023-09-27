import { useQuery, useSidebarTabs } from '@utils'
import { watch } from 'vue'
import request from '../api/fetch-chats-list'
import mapper from './chats-query/mapper'

export default () => {
  const { searchVal } = useSidebarTabs()
  
  const query = useQuery('all-chats', request, {
    map: mapper,
    params: {
      search: searchVal.value,
    },
  })
  
  return query
}
