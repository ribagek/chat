<script setup>
import { onMounted, onUnmounted, computed, watch } from "vue";
import { useAllChatsQuery } from "@queries";
import ChatListItem from "./../ChatListItem.vue";
import { Spinner } from "@components";
import { useEcho } from "@utils";
import { useStore } from "vuex";

const echo = useEcho();

const store = useStore();

const projectID = computed(() => store.getters.currentUser?.project.id);

const { data: chats, isLoading, isEmpty, fetchMore } = useAllChatsQuery();

const onScroll = ({ target }) => {
  if (target.scrollTop + target.clientHeight >= target.scrollHeight) {
    fetchMore();
  }
};

onMounted(() => {
  watch(projectID, (id) => {
    echo.private(`chats.${id}.all`).listen("ChatEvent", (data) => {
      console.log(data);
    });
  });
});

onUnmounted(() => {
  echo.leave(`chats.${projectID.value}.all`);
});
</script>

<template>
  <div
    v-if="isLoading && isEmpty"
    class="py-5 flex items-center justify-center"
  >
    <Spinner />
  </div>
  <div
    v-else
    class="h-[calc(100dvh-100px)] md:h-[calc(100vh-236px)] overflow-auto hie-scrollbar"
    @scroll="onScroll"
  >
    <ChatListItem v-for="(chat, index) in chats" :key="index" :data="chat" />

    <!-- <div v-if="isLoading" class="py-5 flex items-center justify-center">
      <Spinner />
    </div> -->
  </div>
</template>
