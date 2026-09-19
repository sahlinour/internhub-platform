<script setup>
import { computed } from 'vue'

const props = defineProps({
  offer: { type: Object, required: true },
  rank: { type: Number, required: true },
})

const tier = computed(() => {
  if (props.offer.matchPercent >= 85) {
    return { ring: 'text-emerald-500', badge: 'bg-emerald-50 text-emerald-700', label: 'Excellent match' }
  }
  if (props.offer.matchPercent >= 65) {
    return { ring: 'text-secondary', badge: 'bg-secondary/10 text-secondary', label: 'Good match' }
  }
  return { ring: 'text-amber-500', badge: 'bg-amber-50 text-amber-700', label: 'Partial match' }
})
</script>

<template>
  <article class="flex flex-col gap-4 rounded-2xl border border-secondary/10 bg-surface p-5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md sm:flex-row sm:items-center">
    <div class="relative h-14 w-14 shrink-0">
      <svg class="h-14 w-14 -rotate-90" viewBox="0 0 36 36">
        <circle class="text-white" stroke="currentColor" stroke-width="3" fill="none" cx="18" cy="18" r="15.9155" />
        <circle
          :class="tier.ring"
          stroke="currentColor"
          stroke-width="3"
          stroke-linecap="round"
          fill="none"
          cx="18"
          cy="18"
          r="15.9155"
          :stroke-dasharray="`${offer.matchPercent}, 100`"
        />
      </svg>
      <span class="absolute inset-0 flex items-center justify-center text-xs font-semibold text-primary">
        {{ offer.matchPercent }}%
      </span>
    </div>

    <div class="min-w-0 flex-1">
      <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-1">
        <h3 class="font-display font-medium text-primary">{{ offer.title }}</h3>
        <span class="rounded-full px-2 py-0.5 text-xs font-medium" :class="tier.badge">
          {{ tier.label }}
        </span>
      </div>

      <p class="mt-0.5 flex flex-wrap items-center gap-x-3 gap-y-0.5 text-sm text-primary/60">
        <span>{{ offer.company }}</span>
        <span class="inline-flex items-center gap-1">
          <svg class="h-3.5 w-3.5 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
          </svg>
          {{ offer.location }}
        </span>
      </p>

      <div class="mt-3 flex flex-wrap gap-1.5">
        <span
          v-for="skill in offer.commonSkills"
          :key="skill"
          class="rounded-full bg-accent/25 px-2.5 py-0.5 text-xs font-medium text-primary"
        >
          {{ skill }}
        </span>
      </div>
    </div>

    <a
      :href="offer.applyUrl"
      target="_blank"
      rel="noopener noreferrer"
      class="inline-flex shrink-0 items-center justify-center gap-1.5 rounded-xl border border-secondary px-4 py-2 text-sm font-medium text-white bg-blue-700 transition-colors hover:bg-blue-800 sm:self-center"
    >
      Apply
      <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
      </svg>
    </a>
  </article>
</template>
