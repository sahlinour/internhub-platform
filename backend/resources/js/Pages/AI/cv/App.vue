<script setup>
import { ref } from 'vue'
import UploadZone from './components/UploadZone.vue'
import JobCard from './components/JobCard.vue'
import { matchCv } from './services/api'

const status = ref('idle')
const fileName = ref('')
const selectedFile = ref(null)
const skills = ref([])
const results = ref([])
const error = ref('')

async function analyze(file) {
  if (!file) {
    return
  }

  selectedFile.value = file
  fileName.value = file.name

  status.value = 'loading'
  error.value = ''
  results.value = []
  skills.value = []

  try {
    const data = await matchCv(file)

    skills.value = data.skills ?? []

    results.value = [...(data.offers ?? [])]
      .sort((a, b) => Number(b.score || 0) - Number(a.score || 0))
      .slice(0, 10)

    status.value = 'done'
  } catch (e) {
    console.error('CV matching error:', e)

    error.value =
      e?.message ||
      'Something went wrong while analyzing your CV.'

    status.value = 'error'
  }
}

function reset() {
  status.value = 'idle'
  fileName.value = ''
  selectedFile.value = null
  skills.value = []
  results.value = []
  error.value = ''
}
</script>

<template>
  <main class="min-h-screen bg-white px-4 py-10">
    <div class="mx-auto max-w-6xl">

      <!-- Header -->
      <div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-wide text-steel">
          AI Matching
        </p>

        <h1 class="mt-2 font-display text-3xl font-bold text-navy sm:text-4xl">
          Find your internship match
        </h1>

        <p class="mt-3 max-w-2xl text-navy/70">
          Upload your CV and our matching engine will compare your profile
          with available internship offers.
        </p>
      </div>

      <!-- Upload -->
      <section
        v-if="status === 'idle' || status === 'error'"
        class="max-w-3xl"
      >
        <UploadZone @file="analyze" />

        <!-- Error from API -->
        <div
          v-if="status === 'error' && error"
          class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4"
        >
          <p class="font-semibold text-red-700">
            Analysis failed
          </p>

          <p class="mt-1 text-sm text-red-600">
            {{ error }}
          </p>
        </div>
      </section>

      <!-- Loading -->
      <section
        v-if="status === 'loading'"
        class="rounded-2xl bg-mist p-10 text-center"
      >
        <div
          class="mx-auto h-10 w-10 animate-spin rounded-full border-4 border-steel/20 border-t-steel"
        ></div>

        <h2 class="mt-5 font-display text-xl font-bold text-navy">
          Analyzing your CV...
        </h2>

        <p class="mt-2 text-sm text-navy/65">
          We're comparing your skills with available internship offers.
        </p>

        <p class="mt-4 text-xs text-navy/50">
          {{ fileName }}
        </p>
      </section>

      <!-- Results -->
      <section v-if="status === 'done'">

        <!-- Top information -->
        <div class="mb-6 rounded-2xl bg-mist p-6">
          <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
          >
            <div>
              <p class="text-xs font-semibold uppercase tracking-wide text-steel">
                CV analyzed
              </p>

              <h2 class="mt-1 font-display text-xl font-bold text-navy">
                {{ fileName }}
              </h2>

              <p class="mt-1 text-sm text-navy/60">
                {{ results.length }} internship offer(s) found
              </p>
            </div>

            <button
              type="button"
              class="rounded-lg bg-navy px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-steel"
              @click="reset"
            >
              Upload another CV
            </button>
          </div>

          <!-- Skills -->
          <div v-if="skills.length" class="mt-6">
            <p class="mb-2 text-sm font-semibold text-navy">
              Detected skills
            </p>

            <div class="flex flex-wrap gap-2">
              <span
                v-for="skill in skills"
                :key="skill"
                class="rounded-full bg-sky px-3 py-1 text-xs font-semibold text-navy"
              >
                {{ skill }}
              </span>
            </div>
          </div>
        </div>

        <!-- Offers -->
        <div v-if="results.length" class="space-y-4">
          <JobCard
            v-for="(job, index) in results"
            :key="job.id ?? index"
            :job="job"
            :rank="index + 1"
          />
        </div>

        <!-- No offers -->
        <div
          v-else
          class="rounded-2xl bg-mist p-10 text-center"
        >
          <h3 class="font-display text-lg font-bold text-navy">
            No matching offers found
          </h3>

          <p class="mt-2 text-sm text-navy/65">
            There are currently no internship offers matching your CV.
          </p>
        </div>

      </section>
    </div>
  </main>
</template>