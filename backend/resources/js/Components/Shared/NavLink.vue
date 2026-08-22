<script setup>
defineProps({
  href: {
    type: String,
    required: true
  },
  active: {
    type: Boolean,
    default: false
  }
})
</script>

<template>
  <a
    :href="href"
    class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition duration-150 ease-in-out focus:outline-none"
    :class="
      active
        ? 'border-blue-600 text-gray-900 focus:border-blue-700'
        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700'
    "
  >
    <slot />
  </a>
</template>
