<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'

import AssignedInternCard from '@/Components/Encadrant/AssignedInternCard.vue'

const props = defineProps({
    stages: {
        type: Object,
        required: true,
    },

    filters: {
        type: Object,
        default: () => ({}),
    },
})

const activeFilter = ref('all')

const interns = computed(() => {
    return (props.stages?.data ?? []).map((stage) => {
        const candidature = stage.candidature ?? {}
        const stagiaire = candidature.stagiaire ?? {}
        const user = stagiaire.user ?? {}

        const offre =
            candidature.offre_de_stage ??
            candidature.offreDeStage ??
            {}

        const entreprise = offre.entreprise ?? {}
        const entrepriseUser = entreprise.user ?? {}

        const tasks = stage.taches ?? []
        const documents = stage.documents ?? []

        const completedTasks = tasks.filter((task) => {
            const status = String(task.statut ?? '').toLowerCase()

            return [
                'terminé',
                'termine',
                'completed',
                'done',
            ].includes(status)
        }).length

        const totalTasks = tasks.length

        const progress =
            totalTasks > 0
                ? Math.round((completedTasks / totalTasks) * 100)
                : 0

        const stageStatus = String(
            stage.statut ?? ''
        ).toLowerCase()

        const status = [
            'annulé',
            'annule',
            'cancelled',
        ].includes(stageStatus)
            ? 'at_risk'
            : 'on_track'

        const name =
            user.nom_complet ??
            user.name ??
            'Unknown Intern'

        const initials = name
            .split(' ')
            .filter(Boolean)
            .slice(0, 2)
            .map((word) => word.charAt(0).toUpperCase())
            .join('')

        return {
            id: stage.id,

            stagiaireId:
                stagiaire.user_id ??
                stagiaire.id ??
                null,

            name,
            initials,

            position:
                stage.sujet ??
                offre.titre ??
                'Internship',

            company:
                entrepriseUser.nom_complet ??
                entrepriseUser.name ??
                'Company not specified',

            university:
                stagiaire.universite ??
                null,

            field:
                stagiaire.filiere ??
                null,

            level:
                stagiaire.niveau ??
                null,

            status,

            stageStatus:
                stage.statut ??
                'Unknown',

            progress,
            completedTasks,
            totalTasks,

            logbookPending: documents.filter((document) => {
                const status = String(
                    document.statut ?? ''
                ).toLowerCase()

                return [
                    'pending',
                    'en attente',
                ].includes(status)
            }).length,

            evaluation: null,
            skills: [],

            startDate:
                stage.date_debut ??
                null,

            endDate:
                stage.date_fin ??
                null,

            originalStage: stage,
        }
    })
})

const filteredInterns = computed(() => {
    if (activeFilter.value === 'all') {
        return interns.value
    }

    return interns.value.filter(
        (intern) => intern.status === activeFilter.value
    )
})

const counts = computed(() => ({
    all: interns.value.length,

    onTrack: interns.value.filter(
        (intern) => intern.status === 'on_track'
    ).length,

    atRisk: interns.value.filter(
        (intern) => intern.status === 'at_risk'
    ).length,
}))

const filterButtonClass = (filter) => [
    'whitespace-nowrap rounded-lg px-4 py-2 text-sm font-semibold',
    'transition duration-200 focus:outline-none',
    'focus:ring-2 focus:ring-[#17629b]/30',

    activeFilter.value === filter
        ? 'bg-[#17629b] text-white shadow-sm'
        : 'text-slate-600 hover:bg-[#eaf4fb] hover:text-[#17629b]',
]

const viewProfile = (intern) => {
    if (!intern.stagiaireId) return

    router.get(
        route(
            'encadrant.stagiaires.show',
            { id: intern.stagiaireId }
        )
    )
}

const assignTask = (intern) => {
    if (!intern.id) return

    router.get(
        route(
            'encadrant.taches.create',
            { stage: intern.id }
        )
    )
}
</script>

<template>
    <section>
        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
        >
            <div>
                <h1 class="text-2xl font-bold text-[#17629b]">
                    Assigned Interns
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Interns currently under your supervision.
                </p>
            </div>

            <!-- Filters -->
            <div
                class="max-w-full overflow-x-auto rounded-xl border border-[#d8e8f3] bg-white p-1 shadow-sm"
            >
                <div class="inline-flex min-w-max">
                    <button
                        type="button"
                        :class="filterButtonClass('all')"
                        @click="activeFilter = 'all'"
                    >
                        All ({{ counts.all }})
                    </button>

                    <button
                        type="button"
                        :class="filterButtonClass('on_track')"
                        @click="activeFilter = 'on_track'"
                    >
                        On Track ({{ counts.onTrack }})
                    </button>

                    <button
                        type="button"
                        :class="filterButtonClass('at_risk')"
                        @click="activeFilter = 'at_risk'"
                    >
                        At Risk ({{ counts.atRisk }})
                    </button>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div
            v-if="filteredInterns.length"
            class="grid grid-cols-1 gap-5 xl:grid-cols-2"
        >
            <AssignedInternCard
                v-for="(intern, index) in filteredInterns"
                :key="intern.id"
                :intern="intern"
                :index="index"
                @view-profile="viewProfile"
                @assign-task="assignTask"
            />
        </div>

        <!-- Empty state -->
        <div
            v-else
            class="rounded-2xl border border-dashed border-[#a8cde5] bg-white px-6 py-16 text-center"
        >
            <div
                class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#eaf4fb] text-[#17629b]"
            >
                <svg
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                    />

                    <circle cx="9" cy="7" r="4" />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 8v6M22 11h-6"
                    />
                </svg>
            </div>

            <h3 class="text-base font-semibold text-[#17629b]">
                No assigned interns
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                No interns match the selected filter.
            </p>

            <button
                v-if="activeFilter !== 'all'"
                type="button"
                class="mt-5 inline-flex items-center justify-center rounded-lg bg-[#17629b] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#124f7d] focus:outline-none focus:ring-2 focus:ring-[#17629b]/30"
                @click="activeFilter = 'all'"
            >
                Clear filter
            </button>
        </div>
    </section>
</template>
