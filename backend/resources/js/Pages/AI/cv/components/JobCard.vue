<script setup>
defineProps({
  job: {
    type: Object,
    required: true
  },
  rank: {
    type: Number,
    required: true
  }
})
</script>

<template>
  <article class="rounded-2xl bg-mist p-5 sm:p-6">

    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

      <div class="flex gap-4">

        <span
          class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy font-display text-base font-bold text-white"
          :aria-label="`Rank ${rank}`"
        >
          {{ rank }}
        </span>

        <div class="min-w-0">

          <h3 class="font-display text-lg font-semibold leading-snug">
            {{ job.title }}
          </h3>

          <p class="mt-0.5 text-sm text-navy/75">
            {{ job.company }},
            {{ job.location }},
            {{ job.type }}
          </p>

        </div>

      </div>


      <!-- Score -->
      <div class="w-full sm:w-40 sm:shrink-0">

        <div class="flex items-baseline justify-between">

          <span class="text-sm font-medium">
            Match
          </span>

          <span class="font-display text-xl font-bold">
            {{ job.score }}%
          </span>

        </div>

        <div
          class="mt-1 h-2 overflow-hidden rounded-full bg-white"
          role="progressbar"
          :aria-valuenow="job.score"
          aria-valuemin="0"
          aria-valuemax="100"
          :aria-label="`${job.score}% match`"
        >

          <div
            class="h-full rounded-full bg-navy transition-all duration-500"
            :style="{ width: `${job.score}%` }"
          ></div>

        </div>

      </div>

    </div>


    <!-- Skills -->
    <div class="mt-5 space-y-4">

      <!-- Matching skills -->
      <div v-if="job.matched?.length">

        <p class="mb-1.5 text-sm font-medium">
          Skills you have
        </p>

        <ul class="flex flex-wrap gap-2">

          <li
            v-for="skill in job.matched"
            :key="skill"
            class="rounded-full bg-sky px-3 py-1 text-xs font-semibold text-navy"
          >
            {{ skill }}
          </li>

        </ul>

      </div>


      <!-- Missing skills -->
      <div v-if="job.missing?.length">

        <p class="mb-1.5 text-sm font-medium">
          Skills to add
        </p>

        <ul class="flex flex-wrap gap-2">

          <li
            v-for="skill in job.missing"
            :key="skill"
            class="rounded-full border border-steel/60 bg-white px-3 py-1 text-xs font-medium text-navy/80"
          >
            {{ skill }}
          </li>

        </ul>

      </div>

    </div>


    <!-- AI reasoning -->
    <div
      v-if="job.reasoning"
      class="mt-5 rounded-xl bg-white p-4"
    >

      <p class="text-xs font-bold uppercase tracking-wide text-navy/60">
        AI analysis
      </p>

      <p class="mt-1 text-sm leading-6 text-navy/75">
        {{ job.reasoning }}
      </p>

    </div>


    <!-- Offer -->
    <a
      v-if="job.url && job.url !== '#'"
      :href="job.url"
      class="mt-5 inline-flex items-center justify-center rounded-lg bg-steel px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy"
    >
      View offer
    </a>

    <span
      v-else
      class="mt-5 inline-flex items-center justify-center rounded-lg bg-steel px-4 py-2 text-sm font-semibold text-white/80"
    >
      View offer
    </span>

  </article>
</template>