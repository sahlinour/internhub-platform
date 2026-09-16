<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { computed } from 'vue'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

const props = defineProps({
    candidature: {
        type: Object,
        required: true,
    },
})

const appRoute = (name, params = undefined) => route(name, params, false)

const user = computed(() => props.candidature?.stagiaire?.user ?? {})
const stagiaire = computed(() => props.candidature?.stagiaire ?? {})
const offre = computed(() => props.candidature?.offre_de_stage ?? {})
const competences = computed(() => props.candidature?.stagiaire?.competences ?? [])
const getName = computed(() => user.value.nom_complet ?? user.value.name ?? 'Applicant')

const getInitials = computed(() =>
    getName.value.split(' ').filter(Boolean).slice(0, 2)
        .map(word => word.charAt(0).toUpperCase()).join('')
)

const formatDate = (date) => {
    if (!date) return '—'
    const [year, month, day] = String(date).slice(0, 10).split('-')
    return year && month && day ? `${day}/${month}/${year}` : date
}

const statusLabel = (status) => ({
    en_attente: 'Pending',
    acceptee: 'Accepted',
    refusee: 'Rejected',
}[status] ?? status ?? '—')

const statusClass = (status) => ({
    en_attente: 'bg-amber-50 text-amber-700',
    acceptee: 'bg-emerald-50 text-emerald-600',
    refusee: 'bg-red-50 text-red-600',
}[status] ?? 'bg-slate-100 text-slate-600')

const updateStatus = (statut) => {
    router.patch(
        appRoute('entreprise.candidatures.updateStatus', props.candidature.id),
        { statut },
        { preserveScroll: true }
    )
}

const documentUrl = (path) => {
    if (!path) return null
    if (/^https?:\/\//.test(path)) return path
    return `/storage/${path.replace(/^\/+/, '')}`
}
</script>

<template>
    <EntrepriseLayout>
        <Head :title="`Applicant - ${getName}`" />

        <div class="min-h-screen bg-[#F4F7F9] p-6 sm:p-8">
            <div class="mb-6">
                <Link
                    :href="appRoute('entreprise.candidatures.index')"
                    class="mb-3 inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#16425B]"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                    Back to Applicants
                </Link>

                <div
                    class="flex flex-col gap-4 rounded-2xl border border-slate-200
                           bg-white px-5 py-5 shadow-sm sm:flex-row
                           sm:items-center sm:justify-between"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center
                                   rounded-xl bg-[#E8F1F5] text-sm font-bold text-[#16425B]"
                        >
                            {{ getInitials }}
                        </div>

                        <div class="min-w-0">
                            <h1 class="truncate text-base font-bold text-[#16425B]">
                                {{ getName }}
                            </h1>
                            <p class="mt-0.5 text-xs text-slate-400">
                                {{ user.email || '—' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full
                                   px-3 py-1.5 text-[10px] font-semibold"
                            :class="statusClass(candidature.statut)"
                        >
                            <span class="h-1.5 w-1.5 rounded-full bg-current" />
                            {{ statusLabel(candidature.statut) }}
                        </span>

                        <button
                            v-if="candidature.statut !== 'acceptee'"
                            type="button"
                            class="rounded-xl bg-emerald-600 px-3.5 py-2
                                   text-xs font-semibold text-white transition
                                   hover:bg-emerald-700"
                            @click="updateStatus('acceptee')"
                        >
                            Accept
                        </button>

                        <button
                            v-if="candidature.statut !== 'refusee'"
                            type="button"
                            class="rounded-xl border border-red-200 bg-red-50
                                   px-3.5 py-2 text-xs font-semibold text-red-600
                                   transition hover:bg-red-100"
                            @click="updateStatus('refusee')"
                        >
                            Reject
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-3">
                <div class="space-y-6 xl:col-span-2">
                    <section
                        class="rounded-2xl border border-slate-200
                               bg-white p-5 shadow-sm"
                    >
                        <h2 class="text-sm font-bold text-[#16425B]">
                            Personal Information
                        </h2>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Phone
                                </p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ user.telephone || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    City
                                </p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ user.ville?.nom || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    University
                                </p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ stagiaire.universite || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Field
                                </p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ stagiaire.filiere || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Level
                                </p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ stagiaire.niveau || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Date of Birth
                                </p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ formatDate(stagiaire.date_naissance) }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-2xl border border-slate-200
                               bg-white p-5 shadow-sm"
                    >
                        <h2 class="text-sm font-bold text-[#16425B]">
                            Cover Letter
                        </h2>

                        <div
                            v-if="candidature.lettre_de_motivation"
                            class="mt-4 whitespace-pre-line rounded-xl
                                   bg-[#F4F7F9] p-4 text-sm leading-6 text-slate-600"
                        >
                            {{ candidature.lettre_de_motivation }}
                        </div>

                        <p v-else class="mt-3 text-xs text-slate-400">
                            No cover letter was submitted.
                        </p>
                    </section>

                    <section
                        class="rounded-2xl border border-slate-200
                               bg-white p-5 shadow-sm"
                    >
                        <h2 class="text-sm font-bold text-[#16425B]">
                            Skills
                        </h2>

                        <div
                            v-if="competences.length"
                            class="mt-4 flex flex-wrap gap-2"
                        >
                            <span
                                v-for="competence in competences"
                                :key="competence.id"
                                class="rounded-full bg-[#E8F1F5] px-2.5 py-1
                                       text-[11px] font-semibold text-[#16425B]"
                            >
                                {{ competence.nom ?? competence.libelle ?? 'Skill' }}
                            </span>
                        </div>

                        <p v-else class="mt-3 text-xs text-slate-400">
                            No skills provided.
                        </p>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section
                        class="rounded-2xl border border-slate-200
                               bg-white p-5 shadow-sm"
                    >
                        <h2 class="text-sm font-bold text-[#16425B]">
                            Application
                        </h2>

                        <div class="mt-5 space-y-4">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Internship
                                </p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ offre.titre || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Applied On
                                </p>
                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ formatDate(candidature.date_postulation) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                                    Status
                                </p>
                                <span
                                    class="mt-1.5 inline-flex rounded-full px-2.5 py-1
                                           text-[10px] font-semibold"
                                    :class="statusClass(candidature.statut)"
                                >
                                    {{ statusLabel(candidature.statut) }}
                                </span>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-2xl border border-slate-200
                               bg-white p-5 shadow-sm"
                    >
                        <h2 class="text-sm font-bold text-[#16425B]">
                            Documents
                        </h2>

                        <div class="mt-4 space-y-2">
                            <a
                                v-if="candidature.cv_url"
                                :href="documentUrl(candidature.cv_url)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-between rounded-xl
                                       border border-slate-200 px-3.5 py-3
                                       transition hover:border-[#81C3D7]
                                       hover:bg-[#F4F7F9]"
                            >
                                <div>
                                    <p class="text-xs font-semibold text-slate-800">
                                        Curriculum Vitae
                                    </p>
                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        View submitted CV
                                    </p>
                                </div>

                                <span class="text-xs font-semibold text-[#3A7CA5]">
                                    Open
                                </span>
                            </a>

                            <div
                                v-else
                                class="rounded-xl border border-dashed
                                       border-slate-200 px-3.5 py-3
                                       text-xs text-slate-400"
                            >
                                No CV submitted.
                            </div>

                            <a
                                v-if="candidature.piece_jointe"
                                :href="documentUrl(candidature.piece_jointe)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-between rounded-xl
                                       border border-slate-200 px-3.5 py-3
                                       transition hover:border-[#81C3D7]
                                       hover:bg-[#F4F7F9]"
                            >
                                <div>
                                    <p class="text-xs font-semibold text-slate-800">
                                        Additional Document
                                    </p>
                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        View attachment
                                    </p>
                                </div>

                                <span class="text-xs font-semibold text-[#3A7CA5]">
                                    Open
                                </span>
                            </a>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </EntrepriseLayout>
</template>