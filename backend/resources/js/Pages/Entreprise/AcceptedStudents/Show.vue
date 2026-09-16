<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

const props = defineProps({
    candidature: {
        type: Object,
        required: true,
    },
    encadrants: {
        type: Array,
        default: () => [],
    },
})

const appRoute = (name, params = undefined) => route(name, params, false)

const student = computed(() => props.candidature?.stagiaire?.user ?? {})
const stagiaire = computed(() => props.candidature?.stagiaire ?? {})
const offer = computed(() => props.candidature?.offre_de_stage ?? {})
const stage = computed(() => props.candidature?.stage ?? null)
const hasStage = computed(() => !!stage.value)

const formatDate = (date) => {
    if (!date) return '—'
    const value = String(date).slice(0, 10)
    const [year, month, day] = value.split('-')
    return year && month && day ? `${day}/${month}/${year}` : date
}

const stageForm = useForm({
    sujet: offer.value.titre ?? '',
    date_debut: '',
    date_fin: '',
    id_Candidature: props.candidature.id,
    idUtilisateur_Encadrant: '',
})

const supervisorForm = useForm({
    idUtilisateur_Encadrant: stage.value?.idUtilisateur_Encadrant ?? '',
})

const createStage = () => {
    stageForm.post(appRoute('entreprise.stages.store'), {
        preserveScroll: true,
    })
}

const assignSupervisor = () => {
    if (!stage.value) return

    supervisorForm.patch(
        appRoute('entreprise.stages.assignEncadrant', stage.value.id),
        { preserveScroll: true }
    )
}
</script>

<template>
    <EntrepriseLayout>
        <Head title="Accepted Student" />

        <div class="min-h-screen bg-[#F4F7F9] p-6 sm:p-8">
            <div class="mb-6">
                <Link
                    :href="appRoute('entreprise.acceptedStudents.index')"
                    class="mb-3 inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#16425B]"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Accepted Students
                </Link>

                <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E8F1F5] text-sm font-bold text-[#16425B]">
                            {{ student.nom_complet?.charAt(0)?.toUpperCase() || '?' }}
                        </div>

                        <div>
                            <h1 class="text-base font-bold text-[#16425B]">
                                {{ student.nom_complet || 'Student' }}
                            </h1>
                            <p class="text-xs text-slate-400">
                                {{ student.email || '—' }}
                            </p>
                        </div>
                    </div>

                    <span
                        class="inline-flex w-fit items-center gap-1.5 rounded-full px-3 py-1.5 text-[10px] font-semibold"
                        :class="hasStage ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-current" />
                        {{ hasStage ? 'Internship started' : 'Pending setup' }}
                    </span>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-3">
                <div class="space-y-6 xl:col-span-2">
                    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <h2 class="text-sm font-bold text-[#16425B]">
                            Student Information
                        </h2>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div>
                                <p class="text-xs text-slate-400">Full name</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ student.nom_complet || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Email</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ student.email || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Phone</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ student.telephone || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Internship offer</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ offer.titre || '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 border-t border-slate-100 pt-5">
                            <p class="mb-2 text-xs text-slate-400">Skills</p>

                            <div v-if="stagiaire.competences?.length" class="flex flex-wrap gap-2">
                                <span
                                    v-for="skill in stagiaire.competences"
                                    :key="skill.id"
                                    class="rounded-full bg-[#E8F1F5] px-2.5 py-1 text-[11px] font-semibold text-[#16425B]"
                                >
                                    {{ skill.nom }}
                                </span>
                            </div>

                            <p v-else class="text-xs text-slate-400">
                                No skills added.
                            </p>
                        </div>
                    </section>

                    <section
                        v-if="!hasStage"
                        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
                    >
                        <div>
                            <h2 class="text-sm font-bold text-[#16425B]">
                                Internship Setup
                            </h2>
                            <p class="mt-1 text-xs text-slate-400">
                                Configure the internship before starting it.
                            </p>
                        </div>

                        <form class="mt-5 space-y-4" @submit.prevent="createStage">
                            <div>
                                <label class="text-xs font-semibold text-slate-600">
                                    Internship subject
                                </label>
                                <input
                                    v-model="stageForm.sujet"
                                    type="text"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#3A7CA5]/10"
                                />
                                <p v-if="stageForm.errors.sujet" class="mt-1 text-xs text-red-500">
                                    {{ stageForm.errors.sujet }}
                                </p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="text-xs font-semibold text-slate-600">
                                        Start date
                                    </label>
                                    <input
                                        v-model="stageForm.date_debut"
                                        type="date"
                                        class="mt-1.5 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#3A7CA5]/10"
                                    />
                                    <p v-if="stageForm.errors.date_debut" class="mt-1 text-xs text-red-500">
                                        {{ stageForm.errors.date_debut }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-slate-600">
                                        End date
                                    </label>
                                    <input
                                        v-model="stageForm.date_fin"
                                        type="date"
                                        class="mt-1.5 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#3A7CA5]/10"
                                    />
                                    <p v-if="stageForm.errors.date_fin" class="mt-1 text-xs text-red-500">
                                        {{ stageForm.errors.date_fin }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-slate-600">
                                    Company Supervisor
                                </label>
                                <select
                                    v-model="stageForm.idUtilisateur_Encadrant"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#3A7CA5]/10"
                                >
                                    <option value="">No supervisor yet</option>
                                    <option
                                        v-for="encadrant in encadrants"
                                        :key="encadrant.user_id"
                                        :value="encadrant.user_id"
                                    >
                                        {{ encadrant.user?.nom_complet ?? `Supervisor #${encadrant.user_id}` }}
                                    </option>
                                </select>
                                <p v-if="stageForm.errors.idUtilisateur_Encadrant" class="mt-1 text-xs text-red-500">
                                    {{ stageForm.errors.idUtilisateur_Encadrant }}
                                </p>
                            </div>

                            <div class="flex justify-end pt-1">
                                <button
                                    type="submit"
                                    :disabled="stageForm.processing"
                                    class="rounded-xl bg-[#16425B] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#12364B] disabled:opacity-50"
                                >
                                    {{ stageForm.processing ? 'Starting...' : 'Start Internship' }}
                                </button>
                            </div>
                        </form>
                    </section>

                    <section
                        v-else
                        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
                    >
                        <h2 class="text-sm font-bold text-[#16425B]">
                            Internship
                        </h2>

                        <div class="mt-5 grid gap-5 sm:grid-cols-3">
                            <div>
                                <p class="text-xs text-slate-400">Subject</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ stage.sujet || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Start date</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ formatDate(stage.date_debut) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">End date</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ formatDate(stage.date_fin) }}
                                </p>
                            </div>
                        </div>

                        <form class="mt-6 border-t border-slate-100 pt-5" @submit.prevent="assignSupervisor">
                            <label class="text-xs font-semibold text-slate-600">
                                Assigned Supervisor
                            </label>

                            <div class="mt-1.5 flex flex-col gap-2 sm:flex-row">
                                <select
                                    v-model="supervisorForm.idUtilisateur_Encadrant"
                                    class="flex-1 rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#3A7CA5]/10"
                                >
                                    <option value="" disabled>
                                        Select a supervisor
                                    </option>
                                    <option
                                        v-for="encadrant in encadrants"
                                        :key="encadrant.user_id"
                                        :value="encadrant.user_id"
                                    >
                                        {{ encadrant.user?.nom_complet ?? `Supervisor #${encadrant.user_id}` }}
                                    </option>
                                </select>

                                <button
                                    type="submit"
                                    :disabled="supervisorForm.processing"
                                    class="rounded-xl bg-[#16425B] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#12364B] disabled:opacity-50"
                                >
                                    {{ supervisorForm.processing ? 'Updating...' : 'Update Supervisor' }}
                                </button>
                            </div>

                            <p v-if="supervisorForm.errors.idUtilisateur_Encadrant" class="mt-1 text-xs text-red-500">
                                {{ supervisorForm.errors.idUtilisateur_Encadrant }}
                            </p>
                        </form>
                    </section>
                </div>

                <aside>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <h3 class="text-sm font-bold text-[#16425B]">
                            Application
                        </h3>

                        <div class="mt-5 space-y-4">
                            <div>
                                <p class="text-xs text-slate-400">Status</p>
                                <p class="mt-1 text-sm font-semibold text-emerald-600">
                                    Accepted
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">Applied on</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ formatDate(candidature.date_postulation) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </EntrepriseLayout>
</template>