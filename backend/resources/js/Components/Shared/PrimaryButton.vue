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
    class="inline-flex items-center rounded-md border border-transparent bg-[#16425B] px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-[#12384D] focus:outline-none focus:ring-2 focus:ring-[#16425B] focus:ring-offset-2"
    :class="{ 'opacity-25': disabled }"
  >
    <slot />
  </button>
</template>
