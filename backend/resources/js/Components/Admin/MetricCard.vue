<script setup>
defineProps({
  label: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  },
  trend: {
    type: String,
    default: null // e.g. '+12%'
  }
})
</script>

<template>
  <div class="rounded-lg border border-gray-200 bg-white p-5">
    <p class="text-sm text-gray-500">{{ label }}</p>
    <div class="mt-1 flex items-baseline gap-2">
      <p class="text-2xl font-semibold text-gray-900">{{ value }}</p>
      <span v-if="trend" class="text-xs font-medium text-green-600">{{ trend }}</span>
    </div>
  </div>
</template>
