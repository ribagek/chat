<script setup>
import { computed, ref, watch } from 'vue'
import { useDialog, useAxios, useEventBus } from '@utils'
import DialogWelcome from './dialog/DialogWelcome.vue'
import DialogContent from './dialog/DialogContent.vue'

const { chatData: dialog } = useDialog();
const { bus, emit } = useEventBus();

const component = computed(() => dialog.chat ? DialogContent : DialogWelcome)

const messages = ref([])

const meta = ref(null);

let chat_id = window.location.pathname.substring(window.location.pathname.lastIndexOf('chat/') + 5);

if (dialog.chat) {
  chat_id = dialog.chat.id;
}

let execute = null;
let isLoading = null;
const isFinished = ref(false);

const loadMessages = function (url) {
  if (!url) {
    url = `chats/${chat_id}/messages`;
  }
  
  emit('messagesBeforeLoadingEvent');
  
  const { isLoading, execute } = useAxios(url, {
    onSuccess: ({data, meta: m}) => {
      meta.value = m;
      
      messages.value.unshift(...data.reverse());
      
      emit('messagesLoadedEvent', messages.value);

      subscribeEcho();
    },
  })
  
  return { isLoading: isLoading, execute: execute };
};

watch(
  () => dialog.chat,
  () => {
    messages.value = [];

    if (dialog.chat) {
      isLoading = loadMessages(`chats/${dialog.chat.id}/messages`).isLoading;
    }
  }
);

const subscribeEcho = () => {
  Echo.private('chat.'+dialog.chat.id)
    .listen('.messagePosted', (resp) => {
      const messagePostedIndex = messages.value.findIndex(element => {
        return element.id === resp.message.id ||
          (element.isNew &&
            element.uniq == resp.message.uniq &&
            element.text === resp.message.text &&
            element.sender.id === resp.message.sender.id
          );
      });

      if (messagePostedIndex !== -1 && messages.value[messagePostedIndex] !== 'undefined') {
        messages.value[messagePostedIndex].send = 'success';
      } else {
        messages.value.push(resp.message);

        setTimeout(function () {
          el.value.scrollTo(0, el.value.scrollHeight);
        }, 50);
      }
    })
    .listen('.messageUpdated', (resp) => {
      const isMessagePresentAlready = messages.value.some(element => {
        return element.id === resp.message.id;
      });

      if (isMessagePresentAlready) {
        messages.value = messages.value.map(m => m.id !== resp.message.id ? m : resp.message);
      }
    })
  ;
}

watch(()=>bus.value.get('scrolledChatEvent'), (params) => {
  const chat_id = params[0];
  const next_cursor = params[1];

  isLoading = loadMessages(
    `chats/${chat_id}/messages?cursor=${next_cursor}`
  ).isLoading;
})
</script>

<template>
  <div class="hidden md:block">
    <component :is="component" :messages="messages" :meta="meta" />
  </div>
  <Teleport to="#app">
    <div class="max-md:block hidden">
      <component :is="component" :messages="messages" :meta="meta" />
    </div>
  </Teleport>
</template>
