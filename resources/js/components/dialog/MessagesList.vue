<script setup>
import { ref, nextTick, watch } from "vue";
import { useDialog, useCurrentUser, useEventBus, useDateFormatter } from "@utils";
import { Avatar, Spinner } from "@components";

const props = defineProps({
  mess: Array,
  meta: Array
});

const { bus, emit } = useEventBus();

const format = {
  sameElse: 'LLL',
}

const el = ref(null);
const isLoading = ref(true);
const messages = ref(props.mess);
const isFinished = ref(false);

// const meta = ref(null);

const { chatData: dialog } = useDialog();

const chat = dialog.chat;

const user = useCurrentUser();

const onScroll = async ({ target }) => {
  if (target.scrollTop == 0) {
    setTimeout(() => {console.log('props.meta', props.meta);
      if (props.meta.next_cursor) {
        emit('scrolledChatEvent', dialog.chat.id, props.meta.next_cursor);
      }
    }, 300);
  }
};

watch(()=>bus.value.get('messagesLoadedEvent'), (params) => {
  messages.value = params[0];
  isLoading.value = false;
  
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
})

watch(
  () => props.mess?.length,
  (v) => {
    const lastMessage = props.mess[v - 1];

    if (lastMessage && lastMessage.isNew) {
      nextTick(() => {
        el.value.scrollTo(0, el.value.scrollHeight);
      });
    }
  }
);

watch(
  () => dialog.chat.id,
  () => {
    isLoading.value = true;
    isFinished.value = false;

    messages.value = [];
  }
);

const msgClass = (message) => {
  return message.sender.type == 'admin' ? 'admin-notification justify-center' : ''
}
const dateClass = (message) => {
  return message.sender.type == 'admin' ? 'justify-center' : ''
}
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
        <div class="mr-3 space-y-1.5 max-w-[60%]">
          <div
            class="p-3 bg-[#60A1DD] text-[15px] rounded-tl-xl rounded-tr-xl rounded-bl-xl text-white"
          >
            <div style="white-space: pre;">{{ message.text }}</div>

            <div class="mt-1.5 flex items-center space-x-1 text-xs opacity-70">
              <span>{{ useDateFormatter(message.created_at, format) }}</span>
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
            :photo="message.sender.photo"
            size="32"
            font-size="13"
          />
          <div v-else class="pl-8"></div>
        </div>
      </div>

      <div v-else class="flex items-end" :class="msgClass(message)">
        <div class="w-[32px] h-[32px]" v-if="message.sender.type !== 'admin'">
          <Avatar
            v-if="
              !messages[index + 1] ||
              messages[index + 1]?.sender.id != message.sender.id
            "
            :name="message.sender.name ?? chat.name"
            :photo="message.sender.photo"
            size="32"
            font-size="13"
          />
          <div v-else class="pl-8"></div>
        </div>

        <div class="ml-3 space-y-1.5 max-w-[60%] z-2">
          <div
            class="p-3 text-[15px] rounded-tl-xl rounded-tr-xl rounded-br-xl text-black"
            :class="message.sender.type === 'admin' ? 'bg-white' : 'bg-[#F9FBFD]'"
          >
            <div v-if="message.sender.type == 'admin'" class="text-xs">{{ message.options.text }}</div>
            <div v-else>{{ message.text }}</div>

            <div v-if="message.sender.type !== 'admin'" class="mt-1.5 flex items-center space-x-1 text-xs opacity-70" :class="dateClass(message)">
              <span>{{ useDateFormatter(message.created_at, format) }}</span>
<!--              <svg
                v-if="message.sender.type == 'admin'"
                width="2"
                height="2"
                viewBox="0 0 2 2"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle cx="1" cy="1" r="1" fill="black" fill-opacity="0.6" />
              </svg>-->
<!--              <span v-if="message.sender.type == 'admin'">Admin</span>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.admin-notification {
  position: relative;

  &:before {
    content: '';
    position: absolute;
    width: 100%;
    border: 1px solid #ccc;
    top: 50%;
  }
}

.z-2 {
  z-index: 2;
}
</style>
