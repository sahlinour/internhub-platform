<script setup>
defineProps({
  className: {
    type: String,
    default: 'h-9 w-auto'
  }
})
</script>

<template>
  <svg :class="className" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect width="40" height="40" rx="8" fill="#2F6690" />
    <path
      d="M11 27V13h4.2l4.8 8.4L24.8 13H29v14h-3.4V18.3l-4.6 8h-2l-4.6-8V27H11Z"
      fill="#fff"
    />
  </svg>
</template>
