<script setup>
import { computed } from 'vue'
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

import JourneyHeader from '@/Components/Stagiaire/InternshipJourney/JourneyHeader.vue'
import JourneyTimeline from '@/Components/Stagiaire/InternshipJourney/JourneyTimeline.vue'
import JourneyCompany from '@/Components/Stagiaire/InternshipJourney/JourneyCompany.vue'
import JourneySupervisor from '@/Components/Stagiaire/InternshipJourney/JourneySupervisor.vue'
import JourneyQuickLinks from '@/Components/Stagiaire/InternshipJourney/JourneyQuickLinks.vue'

const props = defineProps({
    stage: {
        type: Object,
        default: null,
    },
    tasks: {
        type: Array,
        default: () => [],
    },
    documents: {
        type: Array,
        default: () => [],
    },
    evaluation: {
        type: Object,
        default: null,
    },
})

const stage = computed(() => props.stage)

const company = computed(() => {
    return stage.value?.candidature?.offre_de_stage?.entreprise ?? null
})
const supervisor = computed(() => {
    return stage.value?.encadrant ?? null
})

const totalWeeks = computed(() => {
    if (!stage.value?.date_debut || !stage.value?.date_fin) {
        return 0
    }

    const start = new Date(stage.value.date_debut)
    const end = new Date(stage.value.date_fin)

    const diff = end.getTime() - start.getTime()

    const weeks = Math.ceil(
        diff / (1000 * 60 * 60 * 24 * 7)
    )

    return Math.max(weeks, 1)
})

const currentWeek = computed(() => {
    if (!stage.value?.date_debut) {
        return 0
    }

    const start = new Date(stage.value.date_debut)
    const today = new Date()

    const diff = today.getTime() - start.getTime()

    const weeks = Math.floor(
        diff / (1000 * 60 * 60 * 24 * 7)
    ) + 1

    return Math.min(
        Math.max(weeks, 1),
        totalWeeks.value
    )
})

const progress = computed(() => {
    if (!stage.value?.date_debut || !stage.value?.date_fin) {
        return 0
    }

    const start = new Date(stage.value.date_debut)
    const end = new Date(stage.value.date_fin)
    const today = new Date()

    const total = end.getTime() - start.getTime()
    const elapsed = today.getTime() - start.getTime()

    if (total <= 0) {
        return 100
    }

    return Math.min(
        Math.max(
            Math.round((elapsed / total) * 100),
            0
        ),
        100
    )
})

const isOnTrack = computed(() => {
    return stage.value?.statut === 'En cours'
})
</script>

<template>
    <StagiaireLayout>

        <div class="min-h-screen bg-[#F4F7F9]">

            <main class="mx-auto max-w-[1400px] px-6 py-6">

                <JourneyHeader
                    :stage="stage"
                    :current-week="currentWeek"
                    :total-weeks="totalWeeks"
                    :progress="progress"
                    :is-on-track="isOnTrack"
                />

                <div
                    v-if="stage"
                    class="grid grid-cols-1 gap-6
                           lg:grid-cols-[minmax(0,1fr)_320px]"
                >

                    <JourneyTimeline
                        :stage="stage"
                        :tasks="tasks"
                        :documents="documents"
                        :evaluation="evaluation"
                    />

                    <aside class="space-y-5">

                        <JourneyCompany
                            :company="company"
                        />

                        <JourneySupervisor
                            :supervisor="supervisor"
                        />

                        <JourneyQuickLinks />

                    </aside>

                </div>

                <section
                    v-else
                    class="rounded-xl border border-slate-100
                           bg-white p-10 text-center"
                >
                    <h2
                        class="text-[17px] font-bold text-[#16425B]"
                    >
                        No active internship
                    </h2>

                    <p
                        class="mt-2 text-[11px] text-[#64748B]"
                    >
                        You do not have an active internship at the moment.
                    </p>
                </section>

            </main>

        </div>

    </StagiaireLayout>
</template>