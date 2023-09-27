<script setup>

</script>

<template>
  <div class="chat-dialog">
    <div class="hidden md:block">
      <img class="w-40 m-auto" src="/vendor/nova/chat/images/no-chat-history.jpg" alt="">
      <div class="mt-7 text-lg font-semibold">Для начала диалога выберите чат</div>
    </div>
  </div>
</template>

<style scoped lang="scss">
  .chat-dialog {
    display: none;
    justify-content: center;
    align-items: center;
    height: 100%;

    @apply md:flex;
  }
</style>
