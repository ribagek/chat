import { createGlobalState } from '@vueuse/core'
import { reactive, ref } from 'vue'
import { useAxios, useEcho } from "@utils";

export default createGlobalState(() => {
  const chatData = reactive({
    chat: null,
    messages: [
      // ..
    ]
  })
  
  const echo = useEcho();

  if (window.location.pathname.lastIndexOf('chat/') !== -1) {
    const chat_id = window.location.pathname.substring(window.location.pathname.lastIndexOf('chat/') + 5);

    if (chat_id) { 
      const { isLoading, execute } = useAxios(`chats/${chat_id}`, {
        onSuccess: ({ data }) => {
          data.chat.id = data.id;
          data.chat.robot = data.details.robot;
          data.chat.name = data.details.title ? data.details.title : '';
          data.chat.photo = data.details.photo;
          data.chat.description = data.details.description;
          chatData.chat = data.chat;
          chatData.id = data.id;
        },
      });
    }
  }

  const show = (chat) => {
    chatData.chat = chat;

    const query = location.search.substring(1);

    const searchParams = new URLSearchParams(query);
    let queryString = '';
    if (searchParams.toString()) {
      queryString = '?'+searchParams.toString()
    }
    
    window.history.pushState(null,null,"/chat/"+chat.id+queryString);
  }
  
  return {
    chatData,
    show,
  }
})
