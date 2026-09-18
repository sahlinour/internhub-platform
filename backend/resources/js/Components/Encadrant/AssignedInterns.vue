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
            const status = String(
                task.statut ?? ''
            ).toLowerCase()

            return [
                'terminé',
                'termine',
                'completed',
                'done',
            ].includes(status)
        }).length

        const totalTasks = tasks.length

        const progress = totalTasks > 0
            ? Math.round(
                (completedTasks / totalTasks) * 100
            )
            : 0

        let status = 'on_track'

        if (
            String(stage.statut ?? '').toLowerCase() === 'annulé' ||
            String(stage.statut ?? '').toLowerCase() === 'annule'
        ) {
            status = 'at_risk'
        }

        const name =
            user.nom_complet ??
            'Unknown Intern'

        const initials = name
            .split(' ')
            .filter(Boolean)
            .slice(0, 2)
            .map(word => word.charAt(0).toUpperCase())
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

            logbookPending:
                documents.filter(document => {
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
        intern => intern.status === activeFilter.value
    )
})

const counts = computed(() => ({
    all: interns.value.length,

    onTrack: interns.value.filter(
        intern => intern.status === 'on_track'
    ).length,

    atRisk: interns.value.filter(
        intern => intern.status === 'at_risk'
    ).length,
}))

const viewProfile = (intern) => {
    router.get(
        route('encadrant.stagiaires.show', intern.id)
    )
}

const assignTask = (intern) => {
    window.location.href = route(
        'encadrant.taches.create',
        {
            stage: intern.id,
        }
    )
}
</script>

<template>
    <section>

        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4
                   lg:flex-row lg:items-center
                   lg:justify-between"
        >
            <div>
                <h1
                    class="text-2xl font-bold
                           text-slate-900"
                >
                    Assigned Interns
                </h1>

                <p
                    class="mt-1 text-sm
                           text-slate-500"
                >
                    Interns currently under
                    your supervision.
                </p>
            </div>

            <!-- Filters -->
            <div
                class="inline-flex rounded-xl
                       border border-slate-200
                       bg-white p-1 shadow-sm"
            >
                <button
                    type="button"
                    @click="activeFilter = 'all'"
                    :class="[
                        'rounded-lg px-4 py-2 text-sm font-medium transition',
                        activeFilter === 'all'
                            ? 'bg-slate-900 text-white'
                            : 'text-slate-600 hover:bg-slate-50'
                    ]"
                >
                    All ({{ counts.all }})
                </button>

                <button
                    type="button"
                    @click="activeFilter = 'on_track'"
                    :class="[
                        'rounded-lg px-4 py-2 text-sm font-medium transition',
                        activeFilter === 'on_track'
                            ? 'bg-slate-900 text-white'
                            : 'text-slate-600 hover:bg-slate-50'
                    ]"
                >
                    On Track ({{ counts.onTrack }})
                </button>

                <button
                    type="button"
                    @click="activeFilter = 'at_risk'"
                    :class="[
                        'rounded-lg px-4 py-2 text-sm font-medium transition',
                        activeFilter === 'at_risk'
                            ? 'bg-slate-900 text-white'
                            : 'text-slate-600 hover:bg-slate-50'
                    ]"
                >
                    At Risk ({{ counts.atRisk }})
                </button>
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


        <!-- Empty State -->
        <div
            v-else
            class="rounded-2xl border
                   border-dashed border-slate-300
                   bg-white px-6 py-16
                   text-center"
        >
            <div
                class="mx-auto mb-4 flex h-12 w-12
                       items-center justify-center
                       rounded-full bg-slate-100
                       text-xl"
            >
                👤
            </div>

            <h3
                class="text-base font-semibold
                       text-slate-900"
            >
                No assigned interns
            </h3>

            <p
                class="mt-1 text-sm
                       text-slate-500"
            >
                No interns match the selected filter.
            </p>
        </div>

    </section>
</template>
