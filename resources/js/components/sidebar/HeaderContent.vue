<script setup>
import useSearch from "../../utils/search";
import HeaderTabs from "./HeaderTabs";
import SearchIcon from "./header-icons/SearchIcon.vue";
import AddIcon from "./header-icons/AddIcon.vue";
import { useSidebarTabs } from '@utils'

const { list: tabs, show: showSearch, active, change } = useSidebarTabs()
</script>

<template>
  <!-- Фильтр: Все, Неотвеченные, Важные -->
  <HeaderTabs :tabs="tabs" :active="active" :change="change" />

  <!-- Кнопка поиска и добавления -->
  <div class="flex space-x-4 px-3">
    <button @click="showSearch" class="search-box">
      <SearchIcon />
    </button>

    <!-- <div class="cursor-pointer select-none">
      <AddIcon />
    </div> -->
  </div>
</template>

