<script setup>
defineProps({
  application: {
    type: Object,
    required: true
  }
})

defineEmits(['accept', 'reject'])
</script>

<template>
  <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-4">
    <div>
      <p class="font-medium text-gray-900">{{ application.student_name }}</p>
      <p class="text-sm text-gray-500">{{ application.internship_title }}</p>
    </div>
    <div class="flex gap-2">
      <button
        class="rounded-md bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-500"
        @click="$emit('accept', application.id)"
      >
        Accepter
      </button>
      <button
        class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500"
        @click="$emit('reject', application.id)"
      >
        Refuser
      </button>
    </div>
  </div>
</template>
