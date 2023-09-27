<script setup>
import { ref } from "vue";
import { useDialog, useDateFormatter, useCurrentUser } from "@utils";
import { Avatar } from "@components";
import { TelegramIcon, StarActiveIcon, StarInactiveIcon } from "@icons";
import { useElementHover } from "@vueuse/core";

const props = defineProps({
  data: Object,
});

const starRef = ref(null);

const isHovered = useElementHover(starRef);

const user = useCurrentUser();

const { data: dialog } = useDialog();
</script>

<template>
  <div
    class="chat-list-item"
    :class="{
      'bg-slate-100/40': dialog.chat?.id == data.id,
    }"
    @click="data.showDialog"
  >
    <div class="grid grid-cols-[45px,1fr]">
      <Avatar :name="data.name" />

      <div class="ml-3">
        <div class="flex items-center justify-between w-full">
          <div class="font-bold text-[#4d5461]">{{ data.name }}</div>
          <div class="ml-auto text-[12px]">
            {{ useDateFormatter(data.created_at) }}
          </div>
        </div>

        <div class="mt-1 flex items-center">
          <div class="last-msg mr-2">
            <div
              v-if="user?.id == data.sender_user_id"
              class="truncate w-[150px]"
            >
              Вы: {{ data.message }}
            </div>
            <div v-else class="truncate w-[160px]">{{ data.message }}</div>
          </div>
          <div
            v-if="data.unread_messages_count"
            class="text-[10px] font-semibold p-1 w-5 h-5 flex items-center justify-center bg-[#60A1DD] rounded-full text-white"
          >
            {{ data.unread_messages_count }}
          </div>
        </div>
      </div>
    </div>

    <div class="flex items-center justify-between pl-[57px] mt-1">
      <img :src="data.robot.bot.photo" width="15" />
      <!-- <TelegramIcon size="15" /> -->

      <!-- Кнопка добавления чата в избранное -->
      <button @click.stop="data.toggleFavorite" ref="starRef">
        <StarActiveIcon v-if="data.isFavorite || isHovered" size="18" />
        <StarInactiveIcon v-else size="18" />
      </button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.chat-list-item {
  @apply p-3 cursor-pointer select-none border-b border-slate-100 hover:bg-slate-100/40;
}
</style>
