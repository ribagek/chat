import { useQuery } from '@utils'
import request from '../api/fetch-chats-list'
import mapper from './chats-query/mapper'

export default () => {
  const query = useQuery('unanswered-chats', request, {
    map: mapper,
    params: {
      filter: 'unread',
    },
  })

  return query
}
