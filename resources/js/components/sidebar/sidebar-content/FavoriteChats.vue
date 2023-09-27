<script setup>
import { onMounted, onUnmounted, computed, watch } from "vue";
import { useFavoriteChatsQuery as useQuery } from '@queries'
import ChatListItem from './../ChatListItem.vue'
import { Spinner } from '@components'
import { useEcho, useEventBus } from "@utils";
import { useStore } from "vuex";

const echo = useEcho();
const {emit, bus} = useEventBus();

const store = useStore();

const projectID = computed(() => store.getters.currentUser?.project.id);

const { data: chats, isLoading, isEmpty, fetchMore } = useQuery()

const onScroll = ({ target }) => {
  if (target.scrollTop + target.clientHeight >= target.scrollHeight) {
    fetchMore();
  }
};

onMounted(() => {console.log('onMounted 3', );
  // watch(projectID, (id) => {console.log('watch 3', );
  setTimeout(function () {
    echo.private(`chats.${projectID.value}.favorite`).listen(".chatEvent", (data) => {
      data.chat = data.chat.chat;

      const messagePostedIndex = chats.value.findIndex(chat => {
        return chat.id === data.chat.id;
      });
      
      if (chats.value[messagePostedIndex].isFavorite !== data.chat.star) {
        chats.value[messagePostedIndex].isFavorite = data.chat.star;
        emit('toggleFavouriteSidebarEvent', data.chat.id, data.chat.star);
      }
    });
  }, 300)
  // });
});

onUnmounted(() => {
  echo.leave(`chats.${projectID.value}.favorite`);
});
</script>

<template>
  <div
    v-if="isLoading && isEmpty"
    class="py-5 flex items-center justify-center"
  >
    <Spinner />
  </div>
  <div v-else 
       class="h-[calc(100dvh-100px)] md:h-[calc(100vh-242px)] overflow-auto hie-scrollbar"
       @scroll="onScroll"
  >
    <ChatListItem
      v-for="(chat, index) in chats"
      :key="index"
      :data="chat"
    />
  </div>
</template>
