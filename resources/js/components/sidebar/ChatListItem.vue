<script setup>
import { ref, watch } from "vue";
import { useDialog, useDateFormatter, useCurrentUser, useEventBus } from "@utils";
import { Avatar } from "@components";
import { TelegramIcon, StarActiveIcon, StarInactiveIcon } from "@icons";
import { useElementHover } from "@vueuse/core";

const format = {
  sameDay: 'LT',
  lastWeek: 'dd[,] LT',
  nextWeek: 'dd[,] LT',
  sameElse: 'L',
}

const props = defineProps({
  data: Object,
});

const starRef = ref(null);

const isHovered = useElementHover(starRef);

const user = useCurrentUser();

const { chatData: dialog } = useDialog();

const { bus } = useEventBus();

// const chat_id = ref()
// const isFav = ref()
// const keyComponent = ref(searchVal + chat_id.value + isFav.value)

watch(()=>bus.value.get('toggleFavouriteEvent'), (params) => {
  if (props.data.id == params[0]) {
    props.data.isFavorite = params[1];
  }
})

let message = props.data.message;
if (props.data.sender_type == 'admin') {
  message = props.data.message;
}
</script>

<template>
  <div
    class="chat-list-item"
    :class="{
      'bg-slate-100/40': dialog.chat?.id == data.id,
    }"
    @click="data.showDialog(data.id)"
  >
    <div class="grid grid-cols-[45px,1fr]">
      <Avatar :name="data.name" :photo="data.photo" />

      <div class="ml-3">
        <div class="flex items-center justify-between w-full">
          <div class="font-bold text-[#4d5461]">{{ data.name }}</div>
          <div class="ml-auto text-[12px]">
            {{ useDateFormatter(data.created_at, format) }}
          </div>
        </div>

        <div class="mt-1 flex items-center justify-between">
          <div class="last-msg mr-2">
            <div
              v-if="user?.id == data.sender_user_id"
              class="truncate w-[150px]"
            >
              Вы: {{ data.message }}
            </div>
            <div v-else class="">
              <div class="hidden truncate md:block w-[160px]">{{ data.message }}</div>
              <div class="hidden sm:block md:hidden">{{ data.message.substring(0,85)+"..." }}</div>
              <div class="sm:hidden">{{ data.message.substring(0,50)+"..." }}</div>
            </div>
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
      <button @click.stop="data.toggleFavorite" ref="starRef" class="btn-star" :class="data.isFavorite ? 'active' : ''">
        <StarActiveIcon class="star-active" size="18" />
        <StarInactiveIcon class="star-inactive" size="18" />
      </button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.chat-list-item {
  @apply p-3 cursor-pointer select-none border-b border-slate-100 hover:bg-slate-100/40;
}
.btn-star {
  .star-active {
    display: none;
  }
  .star-inactive {
    display: block;
  }
  
  &.active, &:hover {
    .star-active {
      display: block;
    }
    .star-inactive {
      display: none;
    }
  }
}
</style>
