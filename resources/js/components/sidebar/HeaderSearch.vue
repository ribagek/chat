<script setup>
import { useSidebarTabs } from '@utils'

// moved search logic to useSidebarTabs
// const { node, searchVal, hide, events } = useSearch()

const { list: tabs, events, node, active, searchVal, searchValDefault, change, hide } = useSidebarTabs()
</script>

<template>
  <div class="z-10 absolute top-0 left-0 w-full h-[51px] flex px-3 items-center justify-between border-b border-slate-100 bg-white rounded-tl-lg">
    <div class="w-6">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M19 19L13 13M15 8C15 11.866 11.866 15 8 15C4.13401 15 1 11.866 1 8C1 4.13401 4.13401 1 8 1C11.866 1 15 4.13401 15 8Z" stroke="#60A1DD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <div class="bg-white w-full h-full pe-2">
      <input
        v-on="events"
        :value="searchValDefault"
        ref="node"
        type="text"
        placeholder="Введите запрос"
        class="pl-3 w-full h-full outline-none text-[16px]"
      >
    </div>

    <button @click="hide" class="w-5 h-w-5 hover:text-[#4d5461]">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20ZM14.4142 7.24275C14.8048 6.85223 14.8048 6.21906 14.4142 5.82854C14.0237 5.43801 13.3905 5.43801 13 5.82854L10 8.82856L6.99998 5.82854C6.60945 5.43801 5.97629 5.43801 5.58576 5.82854C5.19524 6.21906 5.19524 6.85223 5.58576 7.24275L8.58578 10.2428L5.58576 13.2428C5.19524 13.6333 5.19524 14.2665 5.58576 14.657C5.97629 15.0475 6.60945 15.0475 6.99998 14.657L10 11.657L13 14.657C13.3905 15.0475 14.0237 15.0475 14.4142 14.657C14.8048 14.2665 14.8048 13.6333 14.4142 13.2428L11.4142 10.2428L14.4142 7.24275Z" fill="currentColor" />
      </svg>
    </button>
  </div>
</template>
