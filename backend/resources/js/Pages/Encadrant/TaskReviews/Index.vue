<script setup>
import { onBeforeUnmount, ref, watch } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    documents: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            meta: {},
        }),
    },

    filters: {
        type: Object,
        default: () => ({
            search: '',
            statut: '',
        }),
    },
})

const search = ref(props.filters?.search ?? '')
const status = ref(props.filters?.statut ?? '')

let searchTimeout = null

const applyFilters = () => {
    router.get(
        route('encadrant.task-reviews.index'),
        {
            search: search.value || undefined,
            statut: status.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

const clearFilters = () => {
    search.value = ''
    status.value = ''

    applyFilters()
}

watch(search, () => {
    clearTimeout(searchTimeout)

    searchTimeout = setTimeout(() => {
        applyFilters()
    }, 400)
})

watch(status, () => {
    applyFilters()
})

onBeforeUnmount(() => {
    clearTimeout(searchTimeout)
})

const updateStatus = (document, newStatus) => {
    router.patch(
        route('encadrant.documents.updateStatus', document.id),
        {
            statut: newStatus,
        },
        {
            preserveScroll: true,
        }
    )
}

const statusLabel = (status) => {
    switch (status) {
        case 'valide':
            return 'Approved'

        case 'rejete':
            return 'Rejected'

        case 'en_attente':
            return 'Awaiting Review'

        default:
            return status ?? 'Unknown'
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'valide':
            return 'border border-emerald-200 bg-emerald-50 text-emerald-700'

        case 'rejete':
            return 'border border-red-200 bg-red-50 text-red-700'

        case 'en_attente':
            return 'border border-amber-200 bg-amber-50 text-amber-700'

        default:
            return 'border border-[#A9CEDB] bg-[#F2F8FA] text-[#39719F]'
    }
}

const internName = (document) => {
    return (
        document?.stage?.candidature?.stagiaire?.nom_complet ??
        document?.stage?.candidature?.user?.nom_complet ??
        document?.stagiaire?.nom_complet ??
        'Unknown intern'
    )
}

const formatDate = (date) => {
    if (!date) {
        return '—'
    }

    return new Intl.DateTimeFormat('en-US', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}
</script>

<template>
    <Head title="Task Reviews" />

    <EncadrantLayout>
        <div class="min-h-screen bg-[#F4F8FA] px-6 py-8 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="mb-2 text-sm font-medium text-[#39719F]">
                                Encadrant Workspace
                            </p>

                            <h1 class="text-3xl font-bold tracking-tight text-[#163E59]">
                                Task Reviews
                            </h1>

                            <p class="mt-2 text-sm text-[#648096]">
                                Review and validate documents submitted by your interns.
                            </p>
                        </div>

                        <div
                            class="inline-flex items-center gap-2 rounded-xl border border-[#CFE3EA] bg-white px-4 py-3 shadow-sm"
                        >
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAF5F8] text-[#39719F]"
                            >
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 5h6m-8 4h10M7 13h10m-10 4h6"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"
                                    />
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-[#7890A1]">
                                    Documents
                                </p>

                                <p class="text-lg font-bold text-[#163E59]">
                                    {{ documents?.total ?? documents?.data?.length ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div
                    class="mb-6 rounded-2xl border border-[#D6E7ED] bg-white p-5 shadow-sm"
                >
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-[1fr_220px_auto]">
                        <!-- Search -->
                        <div>
                            <label
                                for="search"
                                class="mb-2 block text-sm font-semibold text-[#35566E]"
                            >
                                Search
                            </label>

                            <div class="relative">
                                <svg
                                    class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-[#8AA5B5]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="11" cy="11" r="7" />
                                    <path
                                        stroke-linecap="round"
                                        d="m20 20-4-4"
                                    />
                                </svg>

                                <input
                                    id="search"
                                    v-model="search"
                                    type="text"
                                    placeholder="Search by intern or document..."
                                    class="w-full rounded-xl border border-[#CFE3EA] bg-white py-2.5 pl-10 pr-4 text-sm text-[#294A61] outline-none transition placeholder:text-[#9BB0BD] focus:border-[#39719F] focus:ring-2 focus:ring-[#39719F]/10"
                                />
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label
                                for="status"
                                class="mb-2 block text-sm font-semibold text-[#35566E]"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                v-model="status"
                                class="w-full rounded-xl border border-[#CFE3EA] bg-white px-3 py-2.5 text-sm text-[#294A61] outline-none transition focus:border-[#39719F] focus:ring-2 focus:ring-[#39719F]/10"
                            >
                                <option value="">
                                    All statuses
                                </option>

                                <option value="en_attente">
                                    Awaiting Review
                                </option>

                                <option value="valide">
                                    Approved
                                </option>

                                <option value="rejete">
                                    Rejected
                                </option>
                            </select>
                        </div>

                        <!-- Clear -->
                        <div class="flex items-end">
                            <button
                                type="button"
                                class="w-full rounded-xl border border-[#CFE3EA] bg-white px-5 py-2.5 text-sm font-semibold text-[#507291] transition hover:border-[#39719F] hover:bg-[#F4F9FB] hover:text-[#39719F] md:w-auto"
                                @click="clearFilters"
                            >
                                Clear filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Empty state -->
                <div
                    v-if="!documents?.data?.length"
                    class="rounded-2xl border border-[#D6E7ED] bg-white px-6 py-16 text-center shadow-sm"
                >
                    <div
                        class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF5F8] text-[#39719F]"
                    >
                        <svg
                            class="h-8 w-8"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 5h6m-8 4h10M7 13h10m-10 4h6"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"
                            />
                        </svg>
                    </div>

                    <h2 class="text-lg font-bold text-[#24465D]">
                        No documents found
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm text-[#7890A1]">
                        There are no documents matching your current filters.
                    </p>

                    <button
                        v-if="search || status"
                        type="button"
                        class="mt-5 rounded-xl bg-[#39719F] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2F638C]"
                        @click="clearFilters"
                    >
                        Clear filters
                    </button>
                </div>

                <!-- Reviews -->
                <div v-else class="space-y-5">
                    <article
                        v-for="document in documents.data"
                        :key="document.id"
                        class="overflow-hidden rounded-2xl border border-[#D6E7ED] bg-white shadow-sm transition hover:shadow-md"
                    >
                        <!-- Card header -->
                        <div class="border-b border-[#E4EEF2] px-6 py-5">
                            <div
                                class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between"
                            >
                                <div class="flex min-w-0 items-start gap-4">
                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF5F8] text-[#39719F]"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M7 3h7l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M14 3v5h5M9 13h6M9 17h6"
                                            />
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <div
                                            class="flex flex-wrap items-center gap-3"
                                        >
                                            <h2
                                                class="truncate text-base font-bold text-[#24465D]"
                                            >
                                                {{ document.nom ?? document.name ?? document.titre ?? 'Document' }}
                                            </h2>

                                            <span
                                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"
                                                :class="statusClass(document.statut)"
                                            >
                                                {{ statusLabel(document.statut) }}
                                            </span>
                                        </div>

                                        <p class="mt-1 text-sm text-[#7890A1]">
                                            Submitted by
                                            <span class="font-semibold text-[#507291]">
                                                {{ internName(document) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="text-sm text-[#7890A1] lg:text-right">
                                    <p class="font-medium text-[#507291]">
                                        Submitted
                                    </p>

                                    <p class="mt-1">
                                        {{ formatDate(document.created_at) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card body -->
                        <div class="px-6 py-5">
                            <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
                                <!-- Document information -->
                                <div
                                    class="rounded-xl border border-[#E2EDF1] bg-[#F8FBFC] p-4"
                                >
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wide text-[#7890A1]"
                                    >
                                        Document
                                    </p>

                                    <p
                                        class="mt-2 break-words text-sm font-semibold text-[#35566E]"
                                    >
                                        {{ document.nom ?? document.name ?? document.titre ?? 'Document' }}
                                    </p>
                                </div>

                                <!-- Intern -->
                                <div
                                    class="rounded-xl border border-[#E2EDF1] bg-[#F8FBFC] p-4"
                                >
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wide text-[#7890A1]"
                                    >
                                        Intern
                                    </p>

                                    <p
                                        class="mt-2 text-sm font-semibold text-[#35566E]"
                                    >
                                        {{ internName(document) }}
                                    </p>
                                </div>

                                <!-- Submission date -->
                                <div
                                    class="rounded-xl border border-[#E2EDF1] bg-[#F8FBFC] p-4"
                                >
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wide text-[#7890A1]"
                                    >
                                        Submitted on
                                    </p>

                                    <p
                                        class="mt-2 text-sm font-semibold text-[#35566E]"
                                    >
                                        {{ formatDate(document.created_at) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Description -->
                            <div
                                v-if="document.description"
                                class="mt-5 rounded-xl border border-[#E2EDF1] bg-white p-4"
                            >
                                <p
                                    class="text-xs font-semibold uppercase tracking-wide text-[#7890A1]"
                                >
                                    Description
                                </p>

                                <p
                                    class="mt-2 whitespace-pre-line text-sm leading-6 text-[#507291]"
                                >
                                    {{ document.description }}
                                </p>
                            </div>

                            <!-- Review actions -->
                            <div
                                v-if="document.statut === 'en_attente'"
                                class="mt-5 flex flex-col gap-3 border-t border-[#E7EFF2] pt-5 sm:flex-row sm:items-center sm:justify-between"
                            >
                                <p class="text-sm text-[#7890A1]">
                                    This document is waiting for your review.
                                </p>

                                <div class="flex flex-col gap-2 sm:flex-row">
                                    <button
                                        type="button"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                        @click="updateStatus(document, 'valide')"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m5 12 4 4L19 6"
                                            />
                                        </svg>

                                        Approve
                                    </button>

                                    <button
                                        type="button"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:border-red-600 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-200"
                                        @click="updateStatus(document, 'rejete')"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 6l12 12M18 6L6 18"
                                            />
                                        </svg>

                                        Reject
                                    </button>
                                </div>
                            </div>

                            <!-- Already reviewed -->
                            <div
                                v-else
                                class="mt-5 border-t border-[#E7EFF2] pt-5"
                            >
                                <div
                                    class="flex items-start gap-3 rounded-xl border p-4"
                                    :class="
                                        document.statut === 'valide'
                                            ? 'border-emerald-200 bg-emerald-50'
                                            : 'border-red-200 bg-red-50'
                                    "
                                >
                                    <svg
                                        class="mt-0.5 h-5 w-5 shrink-0"
                                        :class="
                                            document.statut === 'valide'
                                                ? 'text-emerald-600'
                                                : 'text-red-600'
                                        "
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            v-if="document.statut === 'valide'"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m5 12 4 4L19 6"
                                        />

                                        <path
                                            v-else
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 6l12 12M18 6L6 18"
                                        />
                                    </svg>

                                    <div>
                                        <p
                                            class="text-sm font-semibold"
                                            :class="
                                                document.statut === 'valide'
                                                    ? 'text-emerald-700'
                                                    : 'text-red-700'
                                            "
                                        >
                                            {{
                                                document.statut === 'valide'
                                                    ? 'Document approved'
                                                    : 'Document rejected'
                                            }}
                                        </p>

                                        <p
                                            class="mt-1 text-sm"
                                            :class="
                                                document.statut === 'valide'
                                                    ? 'text-emerald-700/80'
                                                    : 'text-red-700/80'
                                            "
                                        >
                                            This document has already been reviewed.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Pagination -->
                <div
                    v-if="documents?.links?.length > 3"
                    class="mt-7 flex flex-wrap items-center justify-center gap-2"
                >
                    <template
                        v-for="(link, index) in documents.links"
                        :key="index"
                    >
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            preserve-scroll
                            preserve-state
                            class="rounded-lg border px-3 py-2 text-sm font-medium transition"
                            :class="
                                link.active
                                    ? 'border-[#39719F] bg-[#39719F] text-white'
                                    : 'border-[#D6E7ED] bg-white text-[#507291] hover:border-[#39719F] hover:text-[#39719F]'
                            "
                            v-html="link.label"
                        />

                        <span
                            v-else
                            class="rounded-lg border border-[#E3EDF1] bg-[#F8FBFC] px-3 py-2 text-sm text-[#A0B2BD]"
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>
    </EncadrantLayout>
</template>