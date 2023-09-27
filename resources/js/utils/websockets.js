/**
 * ----------------------------------------
 *
 * Подключение к фильтрам
 *
 * chats.{project}.all
 * chats.{project}.unread
 * chats.{project}.stars
 *
 * Подключение к чату
 *
 * chat.1
 *
 * ----------------------------------------
 */

// import { useStore } from 'vuex'
// console.log(store.getters.currentUser.project.id)

export default () => {
  // ..

  return {
    // ..
  };
};

// Для примера
// ----------------------------------------------------------
// export default {
//   mounted() {
// hide global
// document.querySelector('[dusk="global-search-component"]').style.display =
//   "none";

// json user from vuex
// this.$store.getters.currentUser.project.id;

//     // SOCKET ID
//     setTimeout(() => console.log(window.Echo.socketId()), 2000);

//     // Фильтр чатов (ВСЕ)
//     window.Echo.private(`chats.1.all`).listen("ChatEvent", (data) =>
//       console.log(data)
//     );

//     // Фильтр чатов (НЕПРОЧИТАННЫЕ)
//     window.Echo.private(`chats.1.unread`).listen("ChatEvent", (data) =>
//       console.log(data)
//     );

//     // Фильтр чатов (ВАЖНЫЕ)
//     window.Echo.private(`chats.1.stars`).listen("ChatEvent", (data) =>
//       console.log(data)
//     );

//     //  для сообщений в чате
//     window.Echo.join(`chat.1`)
//       .listen(".MessageUpdated", (data) => console.log(data))
//       .listen(".MessageCreated", (data) => console.log(data))
//.listen("ChatEvent", (data) =>
//       console.log(data);
//   },

//   created() {
//     this.getChats();
//     this.getChat(1);
//     this.getMessages(1);
//     this.setStar(1);
//     this.setDescription(1);
//     this.UnReadMessages(1);
//   },

//   methods: {
//     /** Получить все чаты */
//     async getChats() {
//       await Nova.request().get(`/nova-vendor/chat/chats`);
//     },

//     /** Сделать сообщение важным */
//     async setStar(id) {
//       await Nova.request().post(`/nova-vendor/chat/chats/${id}/set-star`, {
//         star: true,
//       });
//     },

//     /** Сменить описание для клиента  */
//     async setDescription(id) {
//       await Nova.request().post(
//         `/nova-vendor/chat/chats/${id}/set-description`,
//         {
//           description: "test",
//         }
//       );
//     },

//     /** Получить чат */
//     async getChat(id) {
//       await Nova.request().get(`/nova-vendor/chat/chats/${id}`);
//     },

//     /** Прочитать все сообщение из заданного чата */
//     async UnReadMessages(id) {
//       await Nova.request().get(`/nova-vendor/chat/chats/${id}?unread=true`);
//     },

//     /** Получить сообщения из чата  */
//     async getMessages(id) {
//       await Nova.request().get(`/nova-vendor/chat/chats/${id}/messages`);
//     },
//   },
// };
