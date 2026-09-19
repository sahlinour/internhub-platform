<script setup>
import { ref } from 'vue'
import UploadZone from './components/UploadZone.vue'
import JobCard from './components/JobCard.vue'
import { matchCv } from './services/api'

const status = ref('idle') // idle | loading | done | error
const fileName = ref('')
const skills = ref([])
const results = ref([])
const error = ref('')

async function analyze(file) {
  status.value = 'loading'
  error.value = ''
  try {
    const { skills: found, offers } = await matchCv(file)
    skills.value = found
    results.value = [...offers].sort((a, b) => b.score - a.score).slice(0, 10)
    fileName.value = file.name
    status.value = 'done'
  } catch (e) {
    error.value = e.message || 'Something went wrong while reading your CV.'
    status.value = 'error'
  }
}

function reset() {
  status.value = 'idle'
  fileName.value = ''
  skills.value = []
  results.value = []
  error.value = ''
}
</script>

<template>
  <div class="min-h-screen bg-white">
    <header class="border-b border-mist">
      <div class="mx-auto flex max-w-6xl items-center gap-3 px-4 py-4 sm:px-6">
        <svg class="h-8 w-8" viewBox="0 0 32 32" aria-hidden="true">
          <rect width="32" height="32" rx="8" fill="#16425B" />
          <path d="M9 8h9l5 5v11H9z" fill="none" stroke="#81C3D7" stroke-width="2" stroke-linejoin="round" />
          <path d="m12.5 18 2.5 2.5 5-5.5" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <span class="font-display text-xl font-bold">CVmatch</span>
      </div>
    </header>

    <!-- Upload state -->
    <main v-if="status !== 'done'" class="bg-mist">
      <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-20">
        <h3 class="font-display text-3xl font-bold leading-tight sm:text-5xl">
          Upload your CV. See the offers that fit your skills.
        </h3>
        <p class="mt-4 max-w-xl text-base text-navy/80 sm:text-lg">
          We read your CV, pick out your skills and rank open positions by how well they match.
        </p>

        <div class="mt-8">
          <div v-if="status === 'loading'" class="flex flex-col items-center gap-4 rounded-2xl bg-white px-6 py-16 text-center" role="status" aria-live="polite">
            <svg class="h-10 w-10 animate-spin text-steel" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".25" stroke-width="3" />
              <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
            </svg>
            <p class="font-display text-lg font-semibold">Reading your CV</p>
          </div>

          <UploadZone v-else @file="analyze" />

          <div v-if="status === 'error'" class="mt-4 rounded-xl border border-steel bg-white p-4 text-sm" role="alert">
            <p class="font-semibold">We could not analyze this file</p>
            <p class="mt-1 text-navy/80">{{ error }}</p>
          </div>
        </div>
      </div>
    </main>

    <!-- Results state -->
    <main v-else class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-12">
      <div class="grid gap-8 lg:grid-cols-[320px_1fr]">
        <aside class="h-fit rounded-2xl bg-mist p-5 sm:p-6 lg:sticky lg:top-6">
          <p class="text-sm font-medium text-navy/70">Analyzed file</p>
          <p class="mt-0.5 break-all font-display text-lg font-semibold">{{ fileName }}</p>

          <h2 class="mt-6 font-display text-base font-semibold">
            {{ skills.length }} skills detected
          </h2>
          <ul class="mt-3 flex flex-wrap gap-2">
            <li v-for="s in skills" :key="s" class="rounded-full bg-sky px-3 py-1 text-xs font-semibold text-navy">
              {{ s }}
            </li>
          </ul>

          <button
            type="button"
            class="mt-6 w-full rounded-lg bg-navy px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-steel"
            @click="reset"
          >
            Upload another CV
          </button>
        </aside>

        <section aria-labelledby="results-title">
          <h1 id="results-title" class="font-display text-2xl font-bold sm:text-3xl">
            Your top {{ results.length }} matching offers
          </h1>

          <p v-if="!results.length" class="mt-6 rounded-2xl bg-mist p-6">
            No offer matches your skills yet. Add more skills to your CV and upload it again.
          </p>

          <ol v-else class="mt-6 space-y-4">
            <li v-for="(job, i) in results" :key="job.id">
              <JobCard :job="job" :rank="i + 1" />
            </li>
          </ol>
        </section>
      </div>
    </main>
  </div>
</template>
