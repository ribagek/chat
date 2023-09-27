<script setup>
import { ref, nextTick, watch } from "vue";
import { useDialog, useCurrentUser, useAxios, useDateFormatter } from "@utils";
import { Avatar, Spinner } from "@components";

const props = defineProps({
  mess: Array,
});

const el = ref(null);

const messages = ref([]);

const isFinished = ref(false);

const meta = ref(null);

const { data: dialog } = useDialog();

const chat = dialog.chat;

const user = useCurrentUser();

const { isLoading, execute } = useAxios(`chats/${dialog.chat.id}/messages`, {
  onSuccess: ({ data, meta: m }) => {
    meta.value = m;

    messages.value.unshift(...data.reverse());

    props.mess.value = messages.value;

    if (!isFinished.value) {
      nextTick(() => {
        el.value.scrollTo(0, el.value.scrollHeight);

        isFinished.value = true;
      });
    } else {
      const h = el.value.scrollHeight;

      nextTick(() => {
        el.value.scrollTo(0, el.value.scrollHeight - h);
      });
    }
  },
});

const onScroll = async ({ target }) => {
  if (target.scrollTop == 0) {
    setTimeout(() => {
      if (meta.value.next_cursor) {
        execute(
          `chats/${dialog.chat.id}/messages?cursor=${meta.value.next_cursor}`
        );
      }
    }, 300);
  }
};

watch(
  () => props.mess.value?.length,
  (v) => {
    const lastMessage = props.mess.value[v - 1];

    if (lastMessage.isNew) {
      nextTick(() => {
        el.value.scrollTo(0, el.value.scrollHeight);
      });
    }
  }
);

watch(
  () => dialog.chat.id,
  () => {
    isFinished.value = false;

    messages.value = [];

    execute(`chats/${dialog.chat.id}/messages`);
  }
);
</script>

<template>
  <div
    v-if="isLoading && !messages.length"
    class="flex justify-center items-center w-full h-full"
  >
    <Spinner />
  </div>
  <div
    v-else
    ref="el"
    class="pt-5 pb-5 h-full px-3 md:px-7 overflow-y-scroll"
    @scroll="onScroll"
  >
    <div
      v-for="(message, index) in messages"
      :key="index"
      class="mb-5 flex flex-col justify-end"
    >
      <div
        v-if="message.sender.id == user.id"
        class="flex items-end justify-end"
      >
        <div class="mr-3 space-y-1.5">
          <div
            class="p-3 bg-[#60A1DD] text-[15px] rounded-tl-xl rounded-tr-xl rounded-bl-xl text-white"
          >
            <div>{{ message.text }}</div>

            <div class="mt-1.5 flex items-center space-x-1 text-xs opacity-70">
              <span>{{ useDateFormatter(message.created_at) }}</span>
              <svg
                v-if="message.sender.type == 'admin'"
                width="2"
                height="2"
                viewBox="0 0 2 2"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle cx="1" cy="1" r="1" fill="white" fill-opacity="0.6" />
              </svg>
              <span v-if="message.sender.type == 'admin'">Admin</span>
            </div>
          </div>
        </div>

        <div class="w-[32px] h-[32px]">
          <Avatar
            v-if="
              !messages[index + 1] ||
              (messages[index + 1] &&
                messages[index + 1].sender.id != message.sender.id)
            "
            :name="message.sender.name ?? chat.name"
            size="32"
            font-size="13"
          />
          <div v-else class="pl-8"></div>
        </div>
      </div>

      <div v-else class="flex items-end">
        <div class="w-[32px] h-[32px]">
          <Avatar
            v-if="
              !messages[index + 1] ||
              messages[index + 1]?.sender.id != message.sender.id
            "
            :name="message.sender.name ?? chat.name"
            size="32"
            font-size="13"
          />
          <div v-else class="pl-8"></div>
        </div>

        <div class="ml-3 space-y-1.5">
          <div
            class="p-3 bg-[#F9FBFD] text-[15px] rounded-tl-xl rounded-tr-xl rounded-br-xl text-black"
          >
            <div>{{ message.text }}</div>

            <div class="mt-1.5 flex items-center space-x-1 text-xs opacity-70">
              <span>{{ useDateFormatter(message.created_at) }}</span>
              <svg
                v-if="message.sender.type == 'admin'"
                width="2"
                height="2"
                viewBox="0 0 2 2"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle cx="1" cy="1" r="1" fill="black" fill-opacity="0.6" />
              </svg>
              <span v-if="message.sender.type == 'admin'">Admin</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
