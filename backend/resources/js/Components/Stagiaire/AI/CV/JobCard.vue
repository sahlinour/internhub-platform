```vue
<script setup>
defineProps({
    job: {
        type: Object,
        required: true,
    },
    rank: {
        type: Number,
        required: true,
    },
})
</script>

<template>
    <article
        class="group overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-[0_2px_10px_rgba(22,66,91,0.04)] transition-all duration-200 hover:-translate-y-[1px] hover:border-[#81C3D7]/60 hover:shadow-[0_6px_20px_rgba(22,66,91,0.08)]"
    >

        <!-- TOP ACCENT -->
        <div class="h-[3px] bg-gradient-to-r from-[#16425B] via-[#3A7CA5] to-[#81C3D7]"></div>

        <div class="p-5 sm:p-6">

            <!-- HEADER -->
            <div
                class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between"
            >

                <!-- JOB INFO -->
                <div class="flex min-w-0 gap-4">

                    <!-- RANK -->
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E8F1F5] text-[#16425B]"
                        :aria-label="`Rank ${rank}`"
                    >
                        <span class="text-[13px] font-bold">
                            #{{ rank }}
                        </span>
                    </div>

                    <!-- TITLE + META -->
                    <div class="min-w-0">

                        <h3
                            class="text-[16px] font-bold leading-6 text-[#16425B] transition-colors group-hover:text-[#2F6690]"
                        >
                            {{ job.title }}
                        </h3>

                        <div
                            class="mt-1.5 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] text-[#64748B]"
                        >
                            <span
                                v-if="job.company"
                                class="font-semibold text-[#2F6690]"
                            >
                                {{ job.company }}
                            </span>

                            <span
                                v-if="job.company && job.location"
                                class="text-[#CBD5E1]"
                            >
                                •
                            </span>

                            <span v-if="job.location">
                                {{ job.location }}
                            </span>

                            <span
                                v-if="job.location && job.type"
                                class="text-[#CBD5E1]"
                            >
                                •
                            </span>

                            <span
                                v-if="job.type"
                                class="font-medium"
                            >
                                {{ job.type }}
                            </span>
                        </div>

                    </div>
                </div>

                <!-- MATCH SCORE -->
                <div
                    class="w-full rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-3 lg:w-[190px] lg:shrink-0"
                >

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-2">

                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
                            >
                                <svg
                                    class="h-3.5 w-3.5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <path
                                        d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3z"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </span>

                            <span
                                class="text-[10px] font-semibold uppercase tracking-[0.7px] text-[#64748B]"
                            >
                                Match
                            </span>

                        </div>

                        <span
                            class="text-[20px] font-bold leading-none text-[#16425B]"
                        >
                            {{ job.score }}%
                        </span>

                    </div>

                    <!-- PROGRESS -->
                    <div
                        class="mt-3 h-1.5 overflow-hidden rounded-full bg-[#E2E8F0]"
                        role="progressbar"
                        :aria-valuenow="job.score"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        :aria-label="`${job.score}% match`"
                    >
                        <div
                            class="h-full rounded-full bg-gradient-to-r from-[#2F6690] to-[#81C3D7] transition-all duration-700 ease-out"
                            :style="{ width: `${job.score}%` }"
                        ></div>
                    </div>

                </div>

            </div>

            <!-- DIVIDER -->
            <div class="my-5 border-t border-[#EDF2F5]"></div>

            <!-- SKILLS -->
            <div class="space-y-4">

                <!-- MATCHED SKILLS -->
                <div v-if="job.matched?.length">

                    <div class="mb-2 flex items-center gap-2">

                        <span
                            class="flex h-5 w-5 items-center justify-center rounded-md bg-[#E8F1F5] text-[#2F6690]"
                        >
                            <svg
                                class="h-3 w-3"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M5 12l4 4L19 6"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </span>

                        <p
                            class="text-[11px] font-bold text-[#16425B]"
                        >
                            Skills you have
                        </p>

                    </div>

                    <ul class="flex flex-wrap gap-1.5">

                        <li
                            v-for="skill in job.matched"
                            :key="skill"
                            class="rounded-full border border-[#81C3D7]/40 bg-[#E8F1F5] px-2.5 py-1 text-[10px] font-semibold text-[#16425B]"
                        >
                            {{ skill }}
                        </li>

                    </ul>

                </div>

                <!-- MISSING SKILLS -->
                <div v-if="job.missing?.length">

                    <div class="mb-2 flex items-center gap-2">

                        <span
                            class="flex h-5 w-5 items-center justify-center rounded-md bg-[#F4F7F9] text-[#64748B]"
                        >
                            <svg
                                class="h-3 w-3"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M12 8v4"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />
                                <path
                                    d="M12 16h.01"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    stroke-linecap="round"
                                />
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />
                            </svg>
                        </span>

                        <p
                            class="text-[11px] font-bold text-[#16425B]"
                        >
                            Skills to add
                        </p>

                    </div>

                    <ul class="flex flex-wrap gap-1.5">

                        <li
                            v-for="skill in job.missing"
                            :key="skill"
                            class="rounded-full border border-[#CBD5E1] bg-white px-2.5 py-1 text-[10px] font-medium text-[#64748B]"
                        >
                            {{ skill }}
                        </li>

                    </ul>

                </div>

            </div>

            <!-- AI ANALYSIS -->
            <div
                v-if="job.reasoning"
                class="mt-5 rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] p-4"
            >

                <div class="flex items-center gap-2">

                    <span
                        class="flex h-6 w-6 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
                    >
                        <svg
                            class="h-3.5 w-3.5"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M12 3a7 7 0 0 0-4 12.7V19h8v-3.3A7 7 0 0 0 12 3z"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M9 22h6"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                            />
                        </svg>
                    </span>

                    <p
                        class="text-[10px] font-bold uppercase tracking-[0.8px] text-[#2F6690]"
                    >
                        AI analysis
                    </p>

                </div>

                <p
                    class="mt-2 text-[11px] leading-5 text-[#64748B]"
                >
                    {{ job.reasoning }}
                </p>

            </div>

            <!-- ACTION -->
            <div class="mt-5 flex items-center justify-between gap-3">

                <span
                    class="text-[9px] font-medium text-[#94A3B8]"
                >
                    AI-powered recommendation
                </span>

                <a
                    v-if="job.url && job.url !== '#'"
                    :href="job.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-[#16425B] px-4 py-2.5 text-[10px] font-semibold text-white transition-all duration-200 hover:bg-[#2F6690] hover:shadow-[0_4px_12px_rgba(22,66,91,0.18)]"
                >
                    View offer

                    <svg
                        class="h-3.5 w-3.5"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M7 17L17 7"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M9 7h8v8"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>

                <span
                    v-else
                    class="inline-flex shrink-0 items-center rounded-lg bg-[#E2E8F0] px-4 py-2.5 text-[10px] font-semibold text-[#94A3B8]"
                >
                    View offer
                </span>

            </div>

        </div>
    </article>
</template>
```
