import { reactive } from "vue";
import { useAxios, useDialog } from "@utils";

export default (item) => {
  const dialog = useDialog();

  const chat = item.chat;

  const details = item.details;

  return reactive({
    id: item.id,
    name: details.title,
    photo: details.photo,
    message: chat.message.text,
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
    },

    showDialog() {
      this.unread_messages_count = 0;
      dialog.show(this);
    },
  });
};
