<script setup>
import { useDialog, useDateFormatter } from "@utils";
import { Avatar, Dropdown, DropdownItem } from "@components";
import { DotsMenuIcon, CloseIcon, TelegramIcon } from "@icons";

const emit = defineEmits(["close"]);

const { data: dialog } = useDialog();

const members = dialog.chat.members;
</script>

<template>
  <div
    class="z-[55] md:z-20 fixed md:absolute top-0 right-0 w-[80%] md:w-[284px] h-full border-l border-slate-100 bg-white overflow-auto"
  >
    <div class="p-3 flex items-center justify-between">
      <Dropdown align="end">
        <template #trigger>
          <button class="flex w-8 h-8 menu">
            <DotsMenuIcon class="m-auto" />
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

      <button @click="emit('close')">
        <CloseIcon />
      </button>
    </div>

    <div
      class="flex items-center justify-center pb-4 w-full border-b border-slate-100"
    >
      <div class="text-center">
        <Avatar :name="dialog.chat.name" size="64" font-size="22" />

        <div class="mt-4 text-[#4d5461] text-lg font-bold">
          {{ dialog.chat.name }}
        </div>
        <div class="mt-1 text-[15px]">UID: {{ dialog.chat.unique }}</div>
      </div>
    </div>

    <!-- <div class="py-6 px-4 border-b border-slate-100">
      <div class="mb-6 font-extrabold uppercase">Настройки</div>

      <button class="flex items-center">
        <svg
          width="39"
          height="24"
          viewBox="0 0 39 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <rect
            x="0.75"
            y="0.75"
            width="37.5"
            height="22.5"
            rx="11.25"
            fill="white"
            stroke="#A1B0C6"
            stroke-width="1.5"
          />
          <rect x="6" y="6" width="12" height="12" rx="6" fill="#A1B0C6" />
        </svg>

        <div class="ml-3 font-bold">Заблокировать клиента</div>
      </button>
    </div> -->

    <div class="px-4 mt-6">
      <div class="mb-3 font-extrabold uppercase text-[#4d5461]">Система</div>

      <div class="flex items-center">
        <!-- <TelegramIcon /> -->
        <img :src="dialog.chat.robot.bot.photo" width="35" />

        <div class="flex flex-col">
          <span class="ml-2 font-bold text-[16px]">{{
            dialog.chat.robot.name
          }}</span>
          <span class="ml-2 text-[14px]">{{
            dialog.chat.robot.bot.title
          }}</span>
        </div>
      </div>
    </div>

    <div class="px-4 mt-6">
      <div class="mb-3 font-extrabold uppercase text-[#4d5461]">Описание</div>

      <span class="text-[16px]">{{
        dialog.chat.description ?? "не указано"
      }}</span>
    </div>

    <div class="px-4 mt-6">
      <div class="mb-3 font-extrabold uppercase text-[#4d5461]">Информация</div>
      <div class="text-[16px]">
        Добавлен: {{ useDateFormatter(dialog.chat.sender_created_at) }}
      </div>
      <div class="text-[16px]">
        Обновлен: {{ useDateFormatter(dialog.chat.sender_updated_at) }}
      </div>
    </div>

    <div class="px-4 mt-6">
      <div class="mb-3 font-extrabold uppercase text-[#4d5461]">
        Участники диалога
      </div>

      <div v-for="(member, index) in members" :key="index">
        <Avatar
          :name="member.name"
          size="32"
          font-size="12"
          :title="member.name"
        />
      </div>
    </div>
  </div>
</template>
