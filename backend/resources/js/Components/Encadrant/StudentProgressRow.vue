<script setup>
defineProps({
  student: {
    type: Object,
    required: true
  },
  progress: {
    type: Number,
    default: 0
  }
})
</script>

<template>
  <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-4">
    <div>
      <p class="font-medium text-gray-900">{{ student.name }}</p>
      <p class="text-sm text-gray-500">{{ student.email }}</p>
    </div>
    <div class="w-32">
      <div class="h-2 rounded-full bg-gray-100">
        <div class="h-2 rounded-full bg-blue-600" :style="{ width: `${progress}%` }" />
      </div>
      <p class="mt-1 text-right text-xs text-gray-500">{{ progress }}%</p>
    </div>
  </div>
</template>
