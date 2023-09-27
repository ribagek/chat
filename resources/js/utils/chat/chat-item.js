import { reactive } from 'vue'
import { useDialog } from '@utils'

export default (chat) => reactive({
  ...chat,

  isFavorite: false,
  isRead: true,

  toggleFavorite() {
    this.isFavorite = !this.isFavorite
  },
  showDialog() {
    const dialog = useDialog()

    dialog.show(this)
  },
})
