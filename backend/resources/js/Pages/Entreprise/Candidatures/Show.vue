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

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}

const user = computed(() => {
    return props.candidature?.stagiaire?.user ?? {}
})

const stagiaire = computed(() => {
    return props.candidature?.stagiaire ?? {}
})

const offre = computed(() => {
    return props.candidature?.offre_de_stage ?? {}
})

const competences = computed(() => {
    return props.candidature?.stagiaire?.competences ?? []
})

const getName = computed(() => {
    return (
        user.value?.nom_complet ??
        user.value?.name ??
        'Applicant'
    )
})

const getInitials = computed(() => {
    return getName.value
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(word => word.charAt(0).toUpperCase())
        .join('')
})

const formatDate = (date) => {
    if (!date) return '—'

    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}

const statusLabel = (status) => {
    switch (status) {
        case 'en_attente':
            return 'Pending'
        case 'acceptee':
            return 'Accepted'
        case 'refusee':
            return 'Rejected'
        default:
            return status ?? '—'
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'en_attente':
            return 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200'
        case 'acceptee':
            return 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200'
        case 'refusee':
            return 'bg-red-50 text-red-600 ring-1 ring-inset ring-red-200'
        default:
            return 'bg-slate-100 text-slate-600'
    }
}

const updateStatus = (statut) => {
    router.patch(
        appRoute(
            'entreprise.candidatures.updateStatus',
            props.candidature.id
        ),
        { statut },
        {
            preserveScroll: true,
        }
    )
}

const documentUrl = (path) => {
    if (!path) return null

    if (
        path.startsWith('http://') ||
        path.startsWith('https://')
    ) {
        return path
    }

    return `/storage/${path.replace(/^\/+/, '')}`
}
</script>

<template>
    <EntrepriseLayout>
        <Head :title="`Applicant - ${getName}`" />

        <div class="space-y-6">

            <!-- HEADER -->
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-4">
                    <Link
                        :href="appRoute('entreprise.candidatures.index')"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-800"
                    >
                        ←
                    </Link>

                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            Applicant Details
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Review the application and applicant information.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">

                    <span
                        class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold"
                        :class="statusClass(candidature.statut)"
                    >
                        {{ statusLabel(candidature.statut) }}
                    </span>

                    <button
                        v-if="candidature.statut !== 'acceptee'"
                        type="button"
                        @click="updateStatus('acceptee')"
                        class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700"
                    >
                        Accept
                    </button>

                    <button
                        v-if="candidature.statut !== 'refusee'"
                        type="button"
                        @click="updateStatus('refusee')"
                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100"
                    >
                        Reject
                    </button>

                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-[1fr_360px]">

                <!-- LEFT -->
                <div class="space-y-6">

                    <!-- PERSONAL INFORMATION -->
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg font-bold text-slate-700"
                            >
                                {{ getInitials }}
                            </div>

                            <div class="min-w-0">
                                <h2 class="truncate text-xl font-bold text-slate-900">
                                    {{ getName }}
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ user.email ?? '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-slate-100 pt-6">

                            <h3 class="text-sm font-semibold text-slate-900">
                                Personal Information
                            </h3>

                            <div class="mt-4 grid gap-5 sm:grid-cols-2">

                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                        Phone
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ user.telephone ?? '—' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                        City
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ user.ville?.nom ?? '—' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                        University
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ stagiaire.universite ?? '—' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                        Field
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ stagiaire.filiere ?? '—' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                        Level
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ stagiaire.niveau ?? '—' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                        Date of Birth
                                    </p>
                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ formatDate(stagiaire.date_naissance) }}
                                    </p>
                                </div>

                            </div>
                        </div>

                    </section>

                    <!-- COVER LETTER -->
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h2 class="text-base font-semibold text-slate-900">
                            Cover Letter
                        </h2>

                        <div
                            v-if="candidature.lettre_de_motivation"
                            class="mt-4 whitespace-pre-line rounded-xl bg-slate-50 p-5 text-sm leading-7 text-slate-700"
                        >
                            {{ candidature.lettre_de_motivation }}
                        </div>

                        <p
                            v-else
                            class="mt-4 text-sm text-slate-500"
                        >
                            No cover letter was submitted.
                        </p>

                    </section>

                    <!-- SKILLS -->
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h2 class="text-base font-semibold text-slate-900">
                            Skills
                        </h2>

                        <div
                            v-if="competences.length"
                            class="mt-4 flex flex-wrap gap-2"
                        >
                            <span
                                v-for="competence in competences"
                                :key="competence.id"
                                class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700"
                            >
                                {{ competence.nom ?? competence.libelle ?? 'Skill' }}
                            </span>
                        </div>

                        <p
                            v-else
                            class="mt-4 text-sm text-slate-500"
                        >
                            No skills provided.
                        </p>

                    </section>

                </div>

                <!-- RIGHT -->
                <div class="space-y-6">

                    <!-- APPLICATION -->
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h2 class="text-base font-semibold text-slate-900">
                            Application
                        </h2>

                        <div class="mt-5 space-y-5">

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Internship
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                    {{ offre.titre ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Applied On
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ formatDate(candidature.date_postulation) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Status
                                </p>

                                <span
                                    class="mt-2 inline-flex rounded-full px-3 py-1.5 text-xs font-semibold"
                                    :class="statusClass(candidature.statut)"
                                >
                                    {{ statusLabel(candidature.statut) }}
                                </span>
                            </div>

                        </div>

                    </section>

                    <!-- DOCUMENTS -->
                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h2 class="text-base font-semibold text-slate-900">
                            Documents
                        </h2>

                        <div class="mt-4 space-y-3">

                            <a
                                v-if="candidature.cv_url"
                                :href="documentUrl(candidature.cv_url)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 transition hover:bg-slate-50"
                            >
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">
                                        Curriculum Vitae
                                    </p>
                                    <p class="mt-0.5 text-xs text-slate-500">
                                        View submitted CV
                                    </p>
                                </div>

                                <span class="text-sm font-semibold text-slate-500">
                                    Open
                                </span>
                            </a>

                            <div
                                v-else
                                class="rounded-xl border border-dashed border-slate-200 px-4 py-4 text-sm text-slate-500"
                            >
                                No CV submitted.
                            </div>

                            <a
                                v-if="candidature.piece_jointe"
                                :href="documentUrl(candidature.piece_jointe)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3 transition hover:bg-slate-50"
                            >
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">
                                        Additional Document
                                    </p>
                                    <p class="mt-0.5 text-xs text-slate-500">
                                        View attachment
                                    </p>
                                </div>

                                <span class="text-sm font-semibold text-slate-500">
                                    Open
                                </span>
                            </a>

                        </div>

                    </section>

                </div>

            </div>

        </div>
    </EntrepriseLayout>
</template>
