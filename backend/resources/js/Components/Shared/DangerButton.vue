<script setup>
defineProps({
  disabled: {
    type: Boolean,
    default: false
  }
})
</script>

<template>
  <button
    :disabled="disabled"
    type="button"
    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25"
    :class="{ 'cursor-not-allowed opacity-25': disabled }"
  >
    <slot />
  </button>
</template>
