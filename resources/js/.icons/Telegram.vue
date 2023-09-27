<script setup>
const props = defineProps({
  size: {
    type: [String, Number],
    default: 24,
  }
})

const paint0id = Math.random()
const paint1id = Math.random()
</script>

<template>
  <svg :width="size" :height="size" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M7 14C10.866 14 14 10.866 14 7C14 3.13401 10.866 0 7 0C3.13401 0 0 3.13401 0 7C0 10.866 3.13401 14 7 14Z" :fill="`url(#${paint0id})`"/>
    <path d="M5.71666 10.2084C5.48988 10.2084 5.52842 10.1227 5.4502 9.9068L4.78333 7.71203L9.91666 4.66669" fill="#C8DAEA"/>
    <path d="M5.71667 10.2084C5.89167 10.2084 5.969 10.1283 6.06667 10.0334L7.00001 9.12581L5.83579 8.42377" fill="#A9C9DD"/>
    <path d="M5.83571 8.42391L8.65671 10.5081C8.97862 10.6857 9.21096 10.5938 9.29114 10.2092L10.4394 4.79806C10.557 4.32671 10.2598 4.11293 9.9518 4.25275L3.20905 6.85272C2.7488 7.03733 2.75148 7.29411 3.12516 7.40852L4.8555 7.94859L8.86142 5.4213C9.05054 5.30662 9.2241 5.36827 9.08164 5.4947" :fill="`url(#${paint1id})`"/>
    <defs>
    <linearGradient :id="paint0id" x1="5.2507" y1="0.5838" x2="1.7507" y2="8.75" gradientUnits="userSpaceOnUse">
    <stop stop-color="#37AEE2"/>
    <stop offset="1" stop-color="#1E96C8"/>
    </linearGradient>
    <linearGradient :id="paint1id" x1="6.12376" y1="7.42998" x2="6.8717" y2="9.84934" gradientUnits="userSpaceOnUse">
    <stop stop-color="#EFF7FC"/>
    <stop offset="1" stop-color="white"/>
    </linearGradient>
    </defs>
  </svg>
</template>
