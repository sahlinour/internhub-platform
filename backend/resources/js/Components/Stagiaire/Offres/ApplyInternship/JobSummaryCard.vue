<script setup>
import { computed } from 'vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const companyName = computed(() => {
    return (
        props.offre?.entreprise?.user?.name ||
        props.offre?.entreprise?.nom ||
        props.offre?.entreprise?.raison_sociale ||
        'Entreprise'
    )
})

const location = computed(() => {
    return props.offre?.entreprise?.user?.ville?.nom || 'Non précisé'
})

const duration = computed(() => {
    return props.offre?.duree || 'Non précisée'
})

const workType = computed(() => {
    return props.offre?.type_travail ||
        props.offre?.mode_travail ||
        props.offre?.type ||
        null
})
</script>

<template>
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
            <!-- Icon -->
            <div
                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#2F6690]/10 text-[#2F6690]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-7 w-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 7V5h8v2"
                    />
                </svg>
            </div>

            <!-- Information -->
            <div class="min-w-0 flex-1">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#2F6690]">
                    Internship Application
                </p>

                <h2 class="text-lg font-bold text-slate-900 sm:text-xl">
                    {{ offre.titre }}
                </h2>

                <p class="mt-1 text-sm font-medium text-slate-600">
                    {{ companyName }}
                </p>

                <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-500">
                    <!-- Location -->
                    <span class="inline-flex items-center gap-1.5">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21s7-5.686 7-12A7 7 0 105 9c0 6.314 7 12 7 12z"
                            />
                            <circle cx="12" cy="9" r="2.5" />
                        </svg>

                        {{ location }}
                    </span>

                    <!-- Duration -->
                    <span class="inline-flex items-center gap-1.5">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 8v4l3 2"
                            />
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                            />
                        </svg>

                        {{ duration }}
                    </span>

                    <!-- Work type only if it exists -->
                    <span
                        v-if="workType"
                        class="inline-flex items-center gap-1.5"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 17V7m0 10a2 2 0 104 0V7m-4 10H7a2 2 0 01-2-2V9a2 2 0 012-2h2m4 10h2a2 2 0 002-2V9a2 2 0 00-2-2h-2"
                            />
                        </svg>

                        {{ workType }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>