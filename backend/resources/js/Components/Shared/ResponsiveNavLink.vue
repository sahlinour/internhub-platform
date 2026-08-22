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
    class="block w-full border-l-4 py-2 pe-4 ps-3 text-start text-base font-medium transition duration-150 ease-in-out focus:outline-none"
    :class="
      active
        ? 'border-blue-600 bg-blue-50 text-blue-800 focus:border-blue-700 focus:bg-blue-100 focus:text-blue-800'
        : 'border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800 focus:border-gray-300 focus:bg-gray-50 focus:text-gray-800'
    "
  >
    <slot />
  </a>
</template>
