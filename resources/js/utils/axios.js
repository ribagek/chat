import { useAxios } from '@vueuse/integrations/useAxios'
import { axios } from '@plugins'

export default (url, options) => useAxios(url, options, axios, {
  immediate: true,
  ...options,
})
