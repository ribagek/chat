<script setup>
import { ref, watch } from "vue";
import { useDialog, useCloak, useAxios, useEventBus, useEcho } from "@utils";
import { Avatar, Dropdown, DropdownItem } from "@components";
import {
  ArrowLeftIcon,
  TelegramIcon,
  StarActiveIcon,
  StarInactiveIcon,
  DotsMenuIcon,
  InfoIcon,
} from "@icons";
import DialogDetails from "./DialogDetails.vue";
import { useElementHover } from "@vueuse/core";

const {emit, bus} = useEventBus()

const { detailsVisible } = useCloak();
const echo = useEcho();

const starRef = ref(null);

const isHovered = useElementHover(starRef);

const { chatData: dialog } = useDialog();

const isFavorite = ref(dialog.chat.star)
const toggleFavorite = () => {
  isFavorite.value  = !isFavorite.value;

  useAxios(`chats/${dialog.chat.id}/set-star`, {
    method: "POST",
    data: {
      star: isFavorite.value,
    },
  });

  emit('toggleFavouriteEvent', dialog.chat.id, isFavorite.value);
}

watch(()=>bus.value.get('toggleFavouriteSidebarEvent'), (params) => {
  if (dialog.chat.id == params[0]) {
    isFavorite.value = params[1];
  }
})

watch(()=>dialog.chat, (chat) => {
  isFavorite.value  = chat.isFavorite;
})

const closeChat = (dialog) => {
  if (dialog.chat) {
    echo.leave(`chat.${dialog.chat.id}`);
    dialog.chat = null;

    window.history.pushState(null,null,"/chat");
  }
}

document.addEventListener('keydown', e => {
  if (e.key == 'Escape') {
    closeChat(dialog);
  }
})
</script>

<template>
  <div
    class="flex items-center px-3 py-3.5 md:p-6 border-b border-slate-100 relative"
  >
    <div class="flex items-center">
      <div class="hidden md:block">
        <Avatar :name="dialog.chat.name" :photo="dialog.chat.photo" width="52" height="52" />
      </div>

      <div class="flex items-center md:hidden">
        <button class="mr-2 circle-hover" @click="closeChat(dialog)"> 
          <ArrowLeftIcon />
        </button>
        <Avatar :name="dialog.chat.name" :photo="dialog.chat.photo" size="40" />
      </div>

      <div class="ml-3 md:text-sm">
        <div class="font-bold text-[16px] text-[#4d5461]">
          {{ dialog.chat.name }}
        </div>
        <div class="text-[14px] mt-1">
          {{ dialog.chat.robot.name }} · {{ dialog.chat.robot.bot.title }}
        </div>
      </div>
    </div>

    <div class="flex items-start space-x-4 ml-auto">
      <!-- <TelegramIcon size="22" /> -->

      <img :src="dialog.chat.robot.bot.photo" width="22" />

      <button @click.stop="toggleFavorite" ref="starRef" class="btn-star" :class="isFavorite ? 'active' : ''">
        <StarActiveIcon class="star-active" size="22" />
        <StarInactiveIcon class="star-inactive" size="22" />
      </button> 

      <Dropdown align="end" class="hidden md:block">
        <template #trigger>
          <button class="menu circle-hover">
            <DotsMenuIcon />
          </button>
        </template>

        <template #content>
          <div
            class="shadow-lg py-1 rounded-xl bg-white border border-slate-100"
          >
            <!-- <DropdownItem
              class="font-semibold py-2.5 px-4 cursor-pointer border-b border-slate-100 hover:bg-slate-100/40"
              >Добавить пользователя</DropdownItem
            > -->
            <DropdownItem
              class="font-semibold py-2.5 px-4 cursor-pointer hover:bg-slate-100/40"
              >Архивировать</DropdownItem
            >
            <DropdownItem
              class="font-semibold py-2.5 px-4 cursor-pointer hover:bg-slate-100/40"
              >Отметить</DropdownItem
            >
          </div>
        </template>
      </Dropdown>

      <button class="block md:hidden" @click="detailsVisible = true">
        <InfoIcon />
      </button>
    </div>

    <button
      class="z-[11] hidden md:flex absolute items-center justify-center bottom-[-22px] right-6 w-11 h-11 rounded-full bg-[#F1F5F9] transition-all"
      :class="{
        'right-[263px] rotate-180': detailsVisible,
      }"
      @click="detailsVisible = !detailsVisible"
    >
      <svg
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M11 17L6 12M6 12L11 7M6 12L18 12"
          stroke="#94A3B8"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </button>
  </div>

  <div
    v-if="detailsVisible"
    class="z-10 absolute top-0 left-0 w-full h-full bg-black opacity-30"
    @click="detailsVisible = false"
  ></div>

  <DialogDetails
    v-if="detailsVisible"
    class="hidden md:block"
    @close="detailsVisible = false"
  />

  <Teleport to="#app">
    <div
      v-if="detailsVisible"
      class="block md:hidden z-[50] absolute top-0 left-0 w-full h-full bg-black opacity-30"
      @click="detailsVisible = false"
    ></div>

    <DialogDetails
      v-if="detailsVisible"
      class="block md:hidden"
      @close="detailsVisible = false"
    />
  </Teleport>
</template>

<style scoped lang="scss">
.circle-hover {
  z-index: 10;
  position: relative;

  &:before {
    z-index: -1;
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 35px;
    height: 35px;
    background: #f1f5f9;
    transform: translate(-50%, -50%) scale(0.7);
    border-radius: 50%;
    opacity: 0;
    transition: all 0.3s;
  }

  &:hover {
    &:before {
      transform: translate(-50%, -50%) scale(1);
      opacity: 100;
    }
  }
}

.transition-all {
  transition-duration: 300ms;
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
