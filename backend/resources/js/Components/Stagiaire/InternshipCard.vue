<script setup>
import { statusBadgeClass } from '@/Utils/status'

defineProps({
  internship: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
    <div class="flex items-start justify-between">
      <h3 class="font-semibold text-gray-900">{{ internship.title }}</h3>
      <span
        class="rounded-full px-2 py-0.5 text-xs font-medium"
        :class="statusBadgeClass(internship.status)"
      >
        {{ internship.status }}
      </span>
    </div>
    <p class="mt-2 text-sm text-gray-600">{{ internship.description }}</p>
  </div>
</template>
