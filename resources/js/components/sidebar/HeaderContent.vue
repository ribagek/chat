<script setup>
import useSearch from "../../utils/search";
import HeaderTabs from "./HeaderTabs";
import SearchIcon from "./header-icons/SearchIcon.vue";
import AddIcon from "./header-icons/AddIcon.vue";

const { show: showSearch } = useSearch();
</script>

<template>
  <!-- Фильтр: Все, Неотвеченные, Важные -->
  <HeaderTabs />

  <!-- Кнопка поиска и добавления -->
  <div class="flex space-x-4 px-3">
    <button @click="showSearch">
      <SearchIcon />
    </button>

    <!-- <div class="cursor-pointer select-none">
      <AddIcon />
    </div> -->
  </div>
</template>
