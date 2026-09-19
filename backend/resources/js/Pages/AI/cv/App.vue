<script setup>
import { computed, ref } from 'vue'
import CvUploadZone from '../../../Components/Ai/CvUploadZone.vue'
import AnalyzingProgress from '../../../Components/Ai/AnalyzingProgress.vue'
import SkillsChips from '../../../Components/Ai/SkillsChips.vue'
import JobOfferList from '../../../Components/Ai/JobOfferList.vue'
import { mockOffers, mockExtractedSkills } from './data/mockOffers.js'

// status : 'idle' | 'analyzing' | 'results'
const status = ref('idle')
const extractedSkills = ref([])
const offers = ref([])

const topMatch = computed(() =>
  offers.value.length ? Math.max(...offers.value.map((o) => o.matchPercent)) : 0
)

const topMatchBadge = computed(() =>
  topMatch.value >= 85 ? 'bg-emerald-50 text-emerald-700' : 'bg-accent/25 text-primary'
)

function handleAnalyze(file) {
  status.value = 'analyzing'
  // TODO: replace with the real call to your matching API, sending `file`.
  // Example:
  // const formData = new FormData()
  // formData.append('cv', file)
  // const res = await fetch('/api/match', { method: 'POST', body: formData })
  // const data = await res.json()
  // extractedSkills.value = data.skills
  // offers.value = data.offers
}

function handleComplete() {
  extractedSkills.value = mockExtractedSkills
  offers.value = mockOffers
  status.value = 'results'
}

// Jumps straight to the 10 offers (skips upload) — handy for testing the layout.
function showOffers() {
  extractedSkills.value = mockExtractedSkills
  offers.value = mockOffers
  status.value = 'results'
}

function reset() {
  status.value = 'idle'
  extractedSkills.value = []
  offers.value = []
}
</script>

<template>
  <div class="min-h-screen bg-surface font-sans">
    <header class="border-b border-secondary/10 bg-white">
      <div class="mx-auto flex max-w-3xl items-center gap-2.5 px-4 py-5 sm:px-6">
        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary">
          <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
        </span>
        <p class="font-display text-lg font-semibold text-primary">CV Match</p>
      </div>
    </header>

    <main class="mx-auto max-w-3xl px-4 py-10 sm:px-6 sm:py-16">
      <div v-if="status === 'idle'" class="rounded-3xl border border-secondary/10 bg-white px-6 py-12 shadow-sm sm:px-12 sm:py-16">
        <div class="text-center">
          <span class="inline-flex items-center gap-1.5 rounded-full bg-accent/25 px-3 py-1 text-xs font-medium text-primary">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
            </svg>
            Skill-based matching
          </span>
          <h1 class="mt-4 font-display text-3xl font-semibold text-primary sm:text-4xl">
            Your CV, your top 10 matches
          </h1>
          <p class="mt-3 text-primary/60">
            Upload your CV to find the offers that best match your skills.
          </p>
        </div>
        <div class="mt-10">
          <CvUploadZone @analyze="handleAnalyze" />
        </div>
        <div class="mt-4 text-center">
          <button
             type="button"
               class="text-sm font-medium text-white bg-blue-600 px-4 py-2 rounded-md hover:bg-blue-700"
             @click="showOffers"
              >
               View the matching offers
             </button>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-4 border-t border-secondary/10 pt-8 sm:grid-cols-3">
          <div class="flex items-center gap-3">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-secondary/10">
              <svg class="h-4 w-4 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </span>
            <span class="text-sm text-primary">Instant analysis</span>
          </div>
          <div class="flex items-center gap-3">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-50">
              <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </span>
            <span class="text-sm text-primary">Ranked by fit</span>
          </div>
          <div class="flex items-center gap-3">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-50">
              <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
              </svg>
            </span>
            <span class="text-sm text-primary">One-click apply</span>
          </div>
        </div>
      </div>

      <div v-else-if="status === 'analyzing'">
        <AnalyzingProgress @complete="handleComplete" />
      </div>

      <div v-else class="space-y-6">
        <div class="flex items-start justify-between gap-4 rounded-2xl border border-secondary/10 bg-white p-6 shadow-sm">
          <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-secondary">Analysis</p>
            <h2 class="mt-1 font-display text-xl font-semibold text-primary">Skills detected</h2>
            <div class="mt-3">
              <SkillsChips :skills="extractedSkills" />
            </div>
          </div>
          <button
            type="button"
            class="shrink-0 whitespace-nowrap rounded-xl border border-secondary/30 px-3 py-2 text-sm font-medium text-white bg-blue-700 hover:bg-secondary hover:text-white"
            @click="reset"
          >
            New CV
          </button>
        </div>

        <div class="rounded-2xl border border-secondary/10 bg-white p-6 shadow-sm">
          <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2">
            <div>
              <p class="text-xs font-semibold uppercase tracking-wide text-secondary">Results</p>
              <h2 class="mt-1 font-display text-xl font-semibold text-primary">Top 10 matching offers</h2>
            </div>
            <div class="flex items-center gap-2 text-xs font-medium text-primary/60">
              <span class="rounded-full border border-secondary/15 px-2.5 py-1">{{ offers.length }} offers</span>
              <span class="rounded-full px-2.5 py-1" :class="topMatchBadge">Top match {{ topMatch }}%</span>
            </div>
          </div>
          <div class="mt-5">
            <JobOfferList :offers="offers" />
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
