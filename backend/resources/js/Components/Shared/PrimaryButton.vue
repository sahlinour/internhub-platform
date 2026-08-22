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
    type="submit"
    class="inline-flex items-center rounded-md border border-transparent bg-blue-700 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
    :class="{ 'opacity-25': disabled }"
  >
    <slot />
  </button>
</template>
