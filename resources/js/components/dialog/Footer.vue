<script setup>
import { ref, watch } from "vue";
import { Dropdown, DropdownItem } from "@components";
import { useCurrentUser, useDialog, useAxios, useEventBus } from "@utils";

const {emit} = useEventBus()

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

const { chatData: dialog } = useDialog();

const active = ref('text');
const text = ref(null);
const description = ref(dialog.chat.description);
const inputField = ref();
const focusInput = () => {
  inputField.value.focus()
}

watch(dialog.chat.id, async (newDialog, oldDialog) => {console.log('newDialog', newDialog);
  active.value = 'text'
  text.value = ''
  description.value = newDialog.chat.description
  focusInput()
})

const calcRows = (text) => {
  let numberOfLineBreaks = 1;
    
  if (text) {
    numberOfLineBreaks = (text.match(/\n/g) || []).length;
  }
  
  return numberOfLineBreaks < 1 ? 1 : numberOfLineBreaks;
}

const isDisabled = (active, text, description) => {
  return (active == 'text' && !text)/* || (active == 'description' && !description)*/;
}

const buttonSendClass = (active, text, description) => {
  return isDisabled(active, text, description) ? '' : 'active';
}

const change = (tab) => {
  active.value = tab;
}
const submit = () => {
  if (active.value == 'text') {
    const textValue = text.value.trim();
    if (textValue.length === 0) {
      return;
    }
    
    dialog.chat.message = textValue;
    dialog.chat.sender_user_id = currentUser.value.id;
    const date = new Date();
    const uniq = date.getTime();
    console.log('props.mess', props.mess);
    props.mess.push({
      id: null,
      created_at: date,
      uniq: uniq,
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
        text: textValue,
        created_at: uniq,
        // added params for test. Can be used to update msg
        // is_update: true,//test
        // message_id: props.mess.value.at(-1).id,//test
        // message_text: props.mess.value.at(-1).text,//test
      },
      // onSuccess: ({ data }) => {
      //   console.log('data onSuccess', data);
      //   props.mess.value.push(data);
      // },
    });
  
    text.value = null;
  } else if (active.value == 'description'/* && description.value*/) {
    const descriptionValue = description.value.trim();
    
    useAxios(`chats/${dialog.chat.id}/set-description`, {
      method: "POST",
      data: {
        description: descriptionValue,
      },
      onSuccess: (data) => {
        dialog.chat.description = descriptionValue;
      },
    });
  }
};

const keydown = (e) => {
  if (e.keyCode == 13 && !e.shiftKey) {
    e.preventDefault();
    submit();
  }
};
</script>

<template>
  <div>
    <div class="px-7">
      <div class="flex items-center space-x-2.5">
        <button class="btn-tab py-3"
                :class="{ 'active': 'text' == active }"
                @click="change('text')">
          Ответить
        </button>
        <!-- <button class="py-3">Заметки</button> -->
        <button class="btn-tab py-3"
                :class="{ 'active': 'description' == active }"
                @click="change('description')">Описание</button>
      </div>
    </div>

    <form
      class="flex items-end px-7 border-t border-slate-100 gap-2"
      @submit.prevent="submit"
    >
      <!-- <button>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M8.29292 1.63604L8.29291 14.364M14.6569 8L1.92896 8.00001" stroke="#818C99" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button> -->

      <textarea
        v-model="text"
        v-show="active == 'text'"
        @keydown="keydown"
        autofocus
        ref="inputField"
        type="text"
        class="py-3 w-full resize-none max-h-[200px] text-[16px]"
        :rows="calcRows(text)"
        placeholder="Напишите сообщение..."
      />
      <textarea
        v-model="description"
        v-show="active == 'description'"
        @keydown="keydown"
        autofocus
        type="text"
        class="py-3 w-full resize-none max-h-[200px] text-[16px]"
        :rows="calcRows(description)"
        placeholder="Напишите описание..."
      />

      <div class="ml-auto flex items-center space-x-4 mb-2">
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

        <button type="submit" class="button-send" 
                :class="buttonSendClass(active, text, description)" 
                :disabled="isDisabled(active, text, description)">
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

<style scoped lang="scss"> 
.button-send {
  &[disabled] {
    circle {
      fill: #60A1DD80;
    }
  }
  &.active:hover {
    circle {
      fill: #1E96C8;
    }
  }
}

.btn-tab {
  position: relative;
  &:hover {
    color: #60A1DD;
  }
  &.active {
    color: #60A1DD;

    &:after {
      content: '';
      position: absolute;
      bottom: 0px;
      left: 0;
      width: 100%;
      height: 2px;
      background: #60A1DD;
    }
  }
}
</style>
