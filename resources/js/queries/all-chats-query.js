import { useQuery } from '@utils'
import request from '../api/fetch-chats-list'
import mapper from './chats-query/mapper'

export default () => {
  const query = useQuery('all-chats', request, {
    map: mapper,
  })

  return query
}
