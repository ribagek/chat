<script setup>
import { ref } from "vue";
import { Dropdown, DropdownItem } from "@components";
import { useCurrentUser, useDialog, useAxios } from "@utils";

const props = defineProps({
  mess: Array,
});

const makeid = (length) => {
  let result = "";
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  const charactersLength = characters.length;
  let counter = 0;
  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    counter += 1;
  }
  return result;
};

const currentUser = useCurrentUser();

const { data: dialog } = useDialog();

const text = ref(null);

const submit = () => {
  //console.log(currentUser.value);

  dialog.chat.message = text.value;
  dialog.chat.sender_user_id = currentUser.value.id;

  props.mess.value.push({
    id: null,
    created_at: new Date(),
    isNew: true,
    send: "wait",
    text: text.value,
    sender: {
      id: currentUser.value.id,
      name: currentUser.value.name,
      photo: null,
      type: "user",
    },
    options: null,
  });

  useAxios(`chats/${dialog.chat.id}/messages`, {
    method: "POST",
    data: {
      text: text.value,
      // messageId,
    },
  });

  text.value = null;
};
</script>

<template>
  <div>
    <div class="px-7">
      <div class="flex items-center space-x-2.5">
        <button class="py-3 font-bold border-b border-[#60A1DD]">
          Ответить
        </button>
        <!-- <button class="py-3">Заметки</button> -->
        <button class="py-3">Описание</button>
      </div>
    </div>

    <form
      class="flex items-center px-7 border-t border-slate-100"
      @submit.prevent="submit"
    >
      <!-- <button>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.29292 1.63604L8.29291 14.364M14.6569 8L1.92896 8.00001" stroke="#818C99" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button> -->

      <textarea
        v-model="text"
        autofocus
        type="text"
        class="py-3 w-full resize-none max-h-[200px] text-[16px]"
        rows="1"
        placeholder="Напишите сообщение..."
      />

      <div class="ml-auto flex items-center space-x-4">
        <!-- <Dropdown align="top">
          <template #trigger>
            <button class="py-1">
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle cx="7" cy="17" r="3" fill="#818C99" />
                <circle cx="7" cy="7" r="3" fill="#818C99" />
                <circle cx="17" cy="17" r="3" fill="#818C99" />
                <circle cx="17" cy="7" r="3" fill="#818C99" />
              </svg>
            </button>
          </template>

          <template #content>
            <div
              class="w-[180px] shadow-lg py-1 rounded-xl bg-white border border-slate-100"
            >
              <DropdownItem
                class="font-semibold py-2.5 px-4 cursor-pointer border-b border-slate-100 hover:bg-slate-100/40"
                >Шаблоны</DropdownItem
              >
              <DropdownItem
                class="font-semibold py-2.5 px-4 cursor-pointer hover:bg-slate-100/40"
                >Быстрый ответ</DropdownItem
              >
              <DropdownItem
                class="font-semibold py-2.5 px-4 cursor-pointer hover:bg-slate-100/40"
                >Редактировать</DropdownItem
              >
            </div>
          </template>
        </Dropdown> -->

        <button type="submit">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g clip-path="url(#clip0_93_4733)">
              <circle cx="12" cy="12" r="12" fill="#60A1DD" />
              <path
                d="M12.2578 19.8438C11.5859 19.8438 11.125 19.375 11.125 18.6719V10L11.2031 8.30469L9.63281 10.1172L7.875 11.8672C7.67188 12.0781 7.40625 12.2188 7.0625 12.2188C6.45312 12.2188 5.99219 11.7656 5.99219 11.125C5.99219 10.8281 6.10938 10.5547 6.34375 10.3125L11.4219 5.22656C11.6328 5.00781 11.9531 4.88281 12.2578 4.88281C12.5703 4.88281 12.8828 5.00781 13.0938 5.22656L18.1797 10.3125C18.4141 10.5547 18.5312 10.8281 18.5312 11.125C18.5312 11.7656 18.0703 12.2188 17.4609 12.2188C17.125 12.2188 16.8594 12.0781 16.6484 11.8672L14.8906 10.1172L13.3203 8.30469L13.3906 10V18.6719C13.3906 19.375 12.9375 19.8438 12.2578 19.8438Z"
                fill="white"
              />
            </g>
            <defs>
              <clipPath id="clip0_93_4733">
                <rect width="24" height="24" fill="white" />
              </clipPath>
            </defs>
          </svg>
        </button>
      </div>
    </form>
  </div>
</template>
