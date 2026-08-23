<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: {
    type: String,
    required: true
  },
  as: {
    type: String,
    default: 'a'
  }
})
</script>

<template>
  <Link
    v-if="as === 'a'"
    :href="href"
    class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
  >
    <slot />
  </Link>

  <Link
    v-else
    :href="href"
    method="post"
    as="button"
    class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
  >
    <slot />
  </Link>
</template>
