import { reactive } from "vue";
import { useAxios, useDialog, useEventBus, useEcho } from "@utils";

export default (item) => {
  const dialog = useDialog();
  const {emit} = useEventBus()
  const echo = useEcho();

  const chat = item.chat;

  const details = item.details;
  
  return reactive({
    id: item.id,
    name: details.title,
    photo: details.photo,
    message: chat.message.sender.type === 'admin' ? chat.message.options.text : chat.message.text,
    unique: details.unique,
    members: { ...chat.members },
    robot: { ...details.robot },
    description: details.description,
    isFavorite: chat.star,
    unread_messages_count: chat.unread,
    sender_user_id: chat.message.sender.id,
    sender_type: chat.message.sender.type,
    sender_created_at: details.created_at,
    sender_updated_at: details.updated_at,
    created_at: chat.message.created_at,
    isNew: false,

    toggleFavorite() {
      const isFavorite = !this.isFavorite;

      useAxios(`chats/${this.id}/set-star`, {
        method: "POST",
        data: {
          star: isFavorite,
        },
      });

      this.isFavorite = isFavorite;

      emit('toggleFavouriteSidebarEvent', this.id, isFavorite);
    },

    showDialog() {
      if (dialog.chatData && dialog.chatData.chat) {
        const chat_id_leaving = dialog.chatData.chat.id;

        echo.leave(`chat.${chat_id_leaving}`);
      }
      
      this.unread_messages_count = 0;
      dialog.show(this);

      emit('dialogShowSidebarEvent', this.id);
    },
  });
};
