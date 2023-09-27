<script setup>
import { useUnansweredChatsQuery as useQuery } from '@queries'
import ChatListItem from './../ChatListItem.vue'
import { Spinner } from '@components'

const { data: chats, isLoading } = useQuery()
</script>

<template>
  <div v-if="isLoading" class="py-5 flex items-center justify-center">
    <Spinner />
  </div>
  <div v-else class="h-[calc(100dvh-100px)] md:h-[calc(100vh-236px)] overflow-auto hie-scrollbar">
    <ChatListItem
      v-for="(chat, index) in chats"
      :key="index"
      :data="chat"
    />
  </div>
</template>
