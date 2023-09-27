import { ref, computed } from 'vue'

// параметр key установлен под расширение системы
export default (key, useAxios, options) => {
  const data = ref([])

  const page = ref(1)

  const isFetchingMore = ref(false)

  const { isLoading, execute } = useAxios({
    ...options,
    params: {
      ...options?.params,
      page: page.value,
    },
    onSuccess: (response) => {
      if (options.map) {
        if (isFetchingMore.value) {
          data.value.push(
            ...response.data.map(options.map)
          )
        } else {
          data.value = response.data.map(options.map)
        }
        
      } else {
        if (isFetchingMore.value) {
          data.value.push(
            ...response.data
          )
        } else {
          data.value = response.data
        }
      }

      options.onFetched({
        data: data.value,
      })
    }
  })

  const fetchMore = () => {
    isFetchingMore.value = true

    page.value = page.value+1

    execute({
      params: {
        page: page.value
      },
    })
  }

  return {
    isLoading,
    isEmpty: computed(() => !data.value.length),
    data,
    fetchMore,
  }
}
