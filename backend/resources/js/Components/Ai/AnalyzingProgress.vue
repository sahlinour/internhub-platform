<script setup>
import { onMounted, ref } from 'vue'

const emit = defineEmits(['complete'])

const steps = [
  'Reading file',
  'Extracting skills',
  'Searching for matching offers',
]

const activeStep = ref(0)

onMounted(() => {
  const interval = setInterval(() => {
    activeStep.value += 1
    if (activeStep.value >= steps.length) {
      clearInterval(interval)
      setTimeout(() => emit('complete'), 500)
    }
  }, 900)
})
</script>

<template>
  <div class="mx-auto flex max-w-md flex-col items-center gap-6 rounded-3xl border border-secondary/10 bg-white px-6 py-16 shadow-sm">
    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-accent/25">
      <svg class="h-8 w-8 animate-spin text-secondary" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" />
        <path class="opacity-90" fill="currentColor" d="M12 2a10 10 0 0 1 10 10h-3a7 7 0 0 0-7-7V2Z" />
      </svg>
    </span>

    <ul class="w-full max-w-xs space-y-3">
      <li
        v-for="(step, i) in steps"
        :key="step"
        class="flex items-center gap-3 text-sm transition-colors"
        :class="i < activeStep ? 'text-primary' : i === activeStep ? 'font-medium text-secondary' : 'text-primary/40'"
      >
        <span
          class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border bg-surface text-xs"
          :class="i < activeStep ? 'border-secondary bg-secondary text-white' : i === activeStep ? 'border-secondary text-secondary' : 'border-secondary/20'"
        >
          <svg v-if="i < activeStep" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
          </svg>
          <span v-else>{{ i + 1 }}</span>
        </span>
        {{ step }}
      </li>
    </ul>
  </div>
</template>
