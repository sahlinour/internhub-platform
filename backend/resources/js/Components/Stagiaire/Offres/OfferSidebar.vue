<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },

    profileMatch: {
        type: Number,
        default: 0,
    },

    profile: {
        type: Object,
        default: () => ({
            has_cv: false,
            university: null,
            field: null,
            level: null,
        }),
    },
})

const matchPercentage = computed(() => {
    const value = Number(props.profileMatch)

    return Math.min(100, Math.max(0, value))
})

const matchLabel = computed(() => {
    if (matchPercentage.value >= 80) {
        return 'Excellent match'
    }

    if (matchPercentage.value >= 60) {
        return 'Good match'
    }

    if (matchPercentage.value >= 40) {
        return 'Partial match'
    }

    return 'Low match'
})

const matchColor = computed(() => {
    if (matchPercentage.value >= 80) {
        return 'text-emerald-600'
    }

    if (matchPercentage.value >= 60) {
        return 'text-[#2F6690]'
    }

    if (matchPercentage.value >= 40) {
        return 'text-amber-600'
    }

    return 'text-slate-500'
})

const matchStroke = computed(() => {
    if (matchPercentage.value >= 80) {
        return 'stroke-emerald-500'
    }

    if (matchPercentage.value >= 60) {
        return 'stroke-[#2F6690]'
    }

    if (matchPercentage.value >= 40) {
        return 'stroke-amber-500'
    }

    return 'stroke-slate-400'
})
</script>

<template>
    <div class="space-y-6 lg:sticky lg:top-6">

        <!-- Profile Match -->
        <section
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-[#16425B]">
                        Profile Match
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        How well your profile matches this opportunity
                    </p>
                </div>

                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#E8F1F5] text-[#2F6690]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                        />
                        <circle
                            cx="9"
                            cy="7"
                            r="4"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 8v6M22 11h-6"
                        />
                    </svg>
                </div>
            </div>

            <!-- Match circle -->
            <div class="mt-6 flex flex-col items-center">
                <div class="relative h-32 w-32">

                    <svg
                        class="h-32 w-32 -rotate-90"
                        viewBox="0 0 120 120"
                    >
                        <circle
                            cx="60"
                            cy="60"
                            r="50"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="9"
                            class="text-slate-100"
                        />

                        <circle
                            cx="60"
                            cy="60"
                            r="50"
                            fill="none"
                            stroke-width="9"
                            stroke-linecap="round"
                            :class="matchStroke"
                            :stroke-dasharray="314"
                            :stroke-dashoffset="
                                314 - (314 * matchPercentage) / 100
                            "
                            class="transition-all duration-700"
                        />
                    </svg>

                    <div
                        class="absolute inset-0 flex flex-col items-center justify-center"
                    >
                        <span
                            class="text-2xl font-bold"
                            :class="matchColor"
                        >
                            {{ matchPercentage }}%
                        </span>

                        <span class="text-[11px] text-slate-400">
                            match
                        </span>
                    </div>
                </div>

                <p
                    class="mt-3 text-sm font-semibold"
                    :class="matchColor"
                >
                    {{ matchLabel }}
                </p>
            </div>

            <!-- Profile information -->
            <div class="mt-6 space-y-3 border-t border-slate-100 pt-5">

                <!-- University -->
                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-slate-400">
                        University
                    </span>

                    <span
                        class="text-right text-xs font-medium text-slate-700"
                    >
                        {{ profile.university || 'Not provided' }}
                    </span>
                </div>

                <!-- Field -->
                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-slate-400">
                        Field of study
                    </span>

                    <span
                        class="text-right text-xs font-medium text-slate-700"
                    >
                        {{ profile.field || 'Not provided' }}
                    </span>
                </div>

                <!-- Education level -->
                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-slate-400">
                        Education level
                    </span>

                    <span
                        class="text-right text-xs font-medium text-slate-700"
                    >
                        {{ profile.level || 'Not provided' }}
                    </span>
                </div>

                <!-- CV -->
                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-slate-400">
                        CV
                    </span>

                    <span
                        class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold"
                        :class="
                            profile.has_cv
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'bg-slate-100 text-slate-500'
                        "
                    >
                        {{ profile.has_cv ? 'Available' : 'Missing' }}
                    </span>
                </div>
            </div>

            <!-- Profile action -->
            <Link
                :href="route('stagiaire.profile.show')"
                class="mt-5 flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-[#16425B] transition hover:border-[#81C3D7] hover:bg-[#E8F1F5]"
            >
                Complete My Profile
            </Link>
        </section>


        <!-- Application -->
        <section
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <h2 class="text-base font-bold text-[#16425B]">
                Interested in this internship?
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Submit your application for this internship opportunity.
            </p>

            <Link
                v-if="offre.statut === 'Ouverte'"
                :href="
                    route(
                        'stagiaire.candidatures.create',
                        offre.id
                    )
                "
                class="mt-5 flex w-full items-center justify-center rounded-xl bg-[#16425B] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#3A7CA5]"
            >
                Apply Now
            </Link>

            <div
                v-else
                class="mt-5 flex w-full items-center justify-center rounded-xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-400"
            >
                Applications Closed
            </div>
        </section>

    </div>
</template>
