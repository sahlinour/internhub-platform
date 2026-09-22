<script setup>
defineProps({
  skills: { type: Array, required: true },
})
</script>

<template>
  <div class="flex flex-wrap gap-2">
    <span
      v-for="skill in skills"
      :key="skill"
      class="rounded-full bg-accent/25 px-3 py-1 text-xs font-medium text-primary"
    >
      {{ skill }}
    </span>
  </div>
</template>
