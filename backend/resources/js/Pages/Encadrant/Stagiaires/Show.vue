<script setup>
import { computed } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    stage: {
        type: Object,
        required: true,
    },
})

const candidature = computed(() => props.stage?.candidature ?? {})
const stagiaire = computed(() => candidature.value?.stagiaire ?? {})
const user = computed(() => stagiaire.value?.user ?? {})

const initials = computed(() => {
    const name = user.value?.nom_complet ?? ''

    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(word => word[0]?.toUpperCase())
        .join('')
})

const formatDate = (date) => {
    if (!date) return 'Not specified'

    const value = new Date(date)

    if (Number.isNaN(value.getTime())) {
        return 'Not specified'
    }

    return value.toLocaleDateString('en-GB')
}

const goBack = () => {
    router.visit('/encadrant/stagiaires')
}

const assignTask = () => {
    router.visit(`/encadrant/taches/create?stage=${props.stage.id}`)
}
</script>

<template>
    <Head :title="user.nom_complet || 'Intern Profile'" />

    <EncadrantLayout>
        <div class="mx-auto max-w-6xl">

            <button
                type="button"
                @click="goBack"
                class="mb-5 text-sm font-medium text-slate-500 hover:text-slate-900"
            >
                ← Back to Assigned Interns
            </button>

            <!-- Profile -->
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between gap-5">

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-[#17629b] font-bold text-white"
                        >
                            {{ initials || '?' }}
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold text-slate-900">
                                {{ user.nom_complet || 'Intern' }}
                            </h1>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ user.email || 'No email' }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ stage.sujet || 'Internship' }}
                            </p>
                        </div>

                    </div>

                    <button
                        type="button"
                        @click="assignTask"
                        class="rounded-lg bg-[#17629b] px-5 py-2.5 text-sm font-semibold text-white"
                    >
                        + Assign Task
                    </button>

                </div>
            </div>

            <!-- Information -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                <!-- Academic -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h2 class="mb-5 text-lg font-bold text-slate-900">
                        Academic Information
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <p class="text-xs text-slate-400">
                                University
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ stagiaire.universite || 'Not specified' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">
                                Field
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ stagiaire.filiere || 'Not specified' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">
                                Level
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ stagiaire.niveau || 'Not specified' }}
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Internship -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h2 class="mb-5 text-lg font-bold text-slate-900">
                        Internship Information
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <p class="text-xs text-slate-400">
                                Subject
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ stage.sujet || 'Not specified' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">
                                Start Date
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ formatDate(stage.date_debut) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">
                                End Date
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ formatDate(stage.date_fin) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400">
                                Status
                            </p>

                            <span
                                class="mt-1 inline-block rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600"
                            >
                                {{ stage.statut || 'Not specified' }}
                            </span>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </EncadrantLayout>
</template>
