<script setup>
import {
    onBeforeUnmount,
    ref,
    watch,
} from 'vue'
import {
    Head,
    Link,
    router,
} from '@inertiajs/vue3'

import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    documents: {
        type: Object,
        required: true,
    },

    filters: {
        type: Object,
        default: () => ({
            search: '',
            status: 'all',
        }),
    },
})

const search = ref(props.filters.search ?? '')
const status = ref(props.filters.status ?? 'all')

let searchTimer = null

const applyFilters = () => {
    router.get(
        route('encadrant.task-reviews.index'),
        {
            search: search.value || undefined,

            status:
                status.value !== 'all'
                    ? status.value
                    : undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

watch(search, () => {
    window.clearTimeout(searchTimer)

    searchTimer = window.setTimeout(() => {
        applyFilters()
    }, 400)
})

watch(status, () => {
    applyFilters()
})

onBeforeUnmount(() => {
    window.clearTimeout(searchTimer)
})

const clearFilters = () => {
    search.value = ''
    status.value = 'all'

    router.get(
        route('encadrant.task-reviews.index'),
        {},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

const updateStatus = (document, newStatus) => {
    if (!document?.id) return

    router.patch(
        route('encadrant.documents.updateStatus', {
            id: document.id,
        }),
        {
            statut: newStatus,
        },
        {
            preserveScroll: true,
        }
    )
}

<<<<<<< HEAD
const statusLabel = (status) => {
    switch (status) {
        case 'valide':
            return 'Approved'
        case 'rejete':
            return 'Rejected'
        case 'en_attente':
            return 'Awaiting Review'
        default:
            return status
=======
const statusLabel = (documentStatus) => {
    const labels = {
        Validé: 'Approved',
        Rejeté: 'Rejected',
        'En attente': 'Awaiting Review',
>>>>>>> 3b91466 (Add task  supervisor palette)
    }

    return (
        labels[documentStatus] ??
        documentStatus ??
        'Unknown'
    )
}

<<<<<<< HEAD
const statusClass = (status) => {
    switch (status) {
        case 'valide':
            return 'bg-green-50 text-green-700'
        case 'rejete':
            return 'bg-red-50 text-red-700'
=======
const statusClass = (documentStatus) => {
    switch (documentStatus) {
        case 'Validé':
            return 'border border-emerald-200 bg-emerald-50 text-emerald-700'

        case 'Rejeté':
            return 'border border-red-200 bg-red-50 text-red-700'

        case 'En attente':
            return 'border border-amber-200 bg-amber-50 text-amber-700'

>>>>>>> 3b91466 (Add task  supervisor palette)
        default:
            return 'border border-[#A9CEDB] bg-[#F2F8FA] text-[#39719F]'
    }
}

const internName = (document) => {
    return (
        document.stage?.candidature?.stagiaire?.user
            ?.nom_complet ??
        'Unknown intern'
    )
}

const formatDate = (date) => {
    if (!date) return '—'

    return new Intl.DateTimeFormat('en', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}
</script>

<template>
    <Head title="Task Reviews" />

    <EncadrantLayout>
        <div class="w-full p-6 lg:p-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-[#072B4E]">
                    Task Reviews
                </h1>

                <p class="mt-1 text-sm text-[#507291]">
                    Review submitted work from your interns.
                </p>
            </div>

            <!-- Filters -->
            <section
                class="mb-6 rounded-xl border border-[#A9CEDB]/80 bg-white p-4 shadow-sm"
            >
                <div
                    class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
                >
                    <!-- Search -->
                    <div class="relative w-full lg:max-w-xl">
                        <svg
                            class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#6695AF]"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true"
                        >
                            <circle
                                cx="11"
                                cy="11"
                                r="7"
                            />

                            <path
                                stroke-linecap="round"
                                d="M20 20l-4-4"
                            />
                        </svg>

                        <input
                            v-model="search"
                            type="search"
                            placeholder="Search by intern, document or internship..."
                            class="w-full rounded-xl border border-[#A9CEDB] bg-[#F2F8FA]/50 py-2.5 pl-10 pr-4 text-sm text-[#072B4E] outline-none transition placeholder:text-[#90BACA] focus:border-[#39719F] focus:bg-white focus:ring-2 focus:ring-[#60ADC6]/30"
                        />
                    </div>

                    <div
                        class="flex flex-col gap-3 sm:flex-row"
                    >
                        <!-- Status filter -->
                        <select
                            v-model="status"
                            class="rounded-xl border border-[#A9CEDB] bg-white px-4 py-2.5 text-sm font-medium text-[#072B4E] outline-none transition focus:border-[#39719F] focus:ring-2 focus:ring-[#60ADC6]/30"
                        >
                            <option value="all">
                                All statuses
                            </option>

                            <option value="En attente">
                                Awaiting Review
                            </option>

                            <option value="Validé">
                                Approved
                            </option>

                            <option value="Rejeté">
                                Rejected
                            </option>
                        </select>

                        <!-- Clear filters -->
                        <button
                            v-if="
                                search ||
                                status !== 'all'
                            "
                            type="button"
                            class="rounded-xl border border-[#A9CEDB] bg-white px-4 py-2.5 text-sm font-semibold text-[#39719F] transition hover:border-[#39719F] hover:bg-[#F2F8FA] hover:text-[#072B4E]"
                            @click="clearFilters"
                        >
                            Clear filters
                        </button>
                    </div>
                </div>

                <div
                    class="mt-3 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between"
                >
                    <p class="text-xs text-[#6695AF]">
                        {{
                            documents.total ??
                            documents.data?.length ??
                            0
                        }}
                        results
                    </p>

                    <p
                        v-if="search"
                        class="text-xs text-[#507291]"
                    >
                        Results for

                        <span
                            class="font-semibold text-[#072B4E]"
                        >
                            “{{ search }}”
                        </span>
                    </p>
                </div>
            </section>

            <!-- Empty state -->
            <div
                v-if="!documents.data?.length"
                class="rounded-xl border border-[#A9CEDB] bg-white px-6 py-16 text-center shadow-sm"
            >
                <div
                    class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#F2F8FA] text-[#39719F]"
                >
                    <svg
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12l2 2 4-4M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                        />
                    </svg>
                </div>

                <h2 class="font-semibold text-[#072B4E]">
                    {{
                        search || status !== 'all'
                            ? 'No matching submissions'
                            : 'No submissions to review'
                    }}
                </h2>

                <p class="mt-1 text-sm text-[#507291]">
                    {{
                        search || status !== 'all'
                            ? 'Try changing or clearing your filters.'
                            : 'Intern submissions will appear here.'
                    }}
                </p>

                <button
                    v-if="
                        search ||
                        status !== 'all'
                    "
                    type="button"
                    class="mt-5 rounded-lg bg-[#39719F] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#072B4E]"
                    @click="clearFilters"
                >
                    Clear filters
                </button>
            </div>

            <!-- Reviews -->
            <div v-else class="space-y-4">
                <article
                    v-for="document in documents.data"
                    :key="document.id"
                    class="overflow-hidden rounded-xl border border-[#A9CEDB]/80 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#60ADC6] hover:shadow-md"
                >
                    <div
                        class="h-1 bg-gradient-to-r from-[#072B4E] via-[#39719F] to-[#60ADC6]"
                    ></div>

                    <div class="p-5">
                        <!-- Review header -->
                        <div
                            class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"
                        >
                            <div class="min-w-0">
                                <h2
                                    class="text-base font-semibold text-[#072B4E]"
                                >
                                    {{
                                        document.stage?.sujet ??
                                        'Internship submission'
                                    }}
                                </h2>

                                <p
                                    class="mt-1 text-xs text-[#507291]"
                                >
                                    {{ internName(document) }}

                                    <span
                                        class="mx-1 text-[#A9CEDB]"
                                    >
                                        •
                                    </span>

                                    Submitted
                                    {{
                                        formatDate(
                                            document.created_at
                                        )
                                    }}
                                </p>
                            </div>

                            <span
                                class="w-fit shrink-0 rounded-full px-3 py-1 text-xs font-semibold"
                                :class="
                                    statusClass(
                                        document.statut
                                    )
                                "
                            >
                                {{
                                    statusLabel(
                                        document.statut
                                    )
                                }}
                            </span>
                        </div>

                        <!-- Related tasks -->
                        <div
                            v-if="
                                document.stage?.taches
                                    ?.length
                            "
                            class="mt-4"
                        >
                            <p
                                class="mb-2 text-xs font-semibold uppercase tracking-wide text-[#39719F]"
                            >
                                Internship Tasks
                            </p>

                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="task in document
                                        .stage.taches"
                                    :key="task.id"
                                    class="rounded-md border border-[#A9CEDB]/70 bg-[#F2F8FA] px-2.5 py-1 text-xs font-medium text-[#072B4E]"
                                >
                                    {{ task.titre }}
                                </span>
                            </div>
                        </div>

                        <!-- Submitted file -->
                        <div
                            class="mt-4 flex items-center rounded-lg border border-[#A9CEDB]/80 bg-[#F2F8FA] px-3 py-2.5"
                        >
                            <a
                                v-if="document.fichier_url"
                                :href="
                                    route(
                                        'encadrant.documents.download',
                                        {
                                            id: document.id,
                                        }
                                    )
                                "
                                class="min-w-0 truncate text-sm font-semibold text-[#39719F] transition hover:text-[#072B4E] hover:underline"
                            >
                                {{ document.nom }}
                            </a>

                            <span
                                v-else
                                class="min-w-0 truncate text-sm text-[#507291]"
                            >
                                {{ document.nom }}
                            </span>

                            <span
                                v-if="document.version"
                                class="ml-auto shrink-0 pl-3 text-xs text-[#6695AF]"
                            >
                                v{{ document.version }}
                            </span>
                        </div>

                        <!-- Review actions -->
                        <div
                            v-if="
                                document.statut ===
                                'En attente'
                            "
                            class="mt-4 flex flex-wrap items-center gap-2"
                        >
                            <button
                                type="button"
                                class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                @click="
                                    updateStatus(
                                        document,
                                        'Validé'
                                    )
                                "
                            >
                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                Approve
                            </button>

                            <button
                                type="button"
                                class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-red-200 bg-white px-4 py-2 text-xs font-semibold text-red-600 transition hover:border-red-600 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-200"
                                @click="
                                    updateStatus(
                                        document,
                                        'Rejeté'
                                    )
                                "
                            >
                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>

                                Reject
                            </button>
                        </div>

                        <!-- Reviewed state -->
                        <div
                            v-else
                            class="mt-4 flex items-center gap-2 rounded-lg bg-[#F2F8FA] px-3 py-2 text-xs text-[#507291]"
                        >
                            <svg
                                class="h-4 w-4 shrink-0"
                                :class="
                                    document.statut ===
                                    'Validé'
                                        ? 'text-emerald-600'
                                        : 'text-red-600'
                                "
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 22a10 10 0 100-20 10 10 0 000 20zM8 12l2.5 2.5L16 9"
                                />
                            </svg>

                            This submission has already been reviewed.
                        </div>
                    </div>
<<<<<<< HEAD

                    <!-- Actions -->
                    <div
                        v-if="document.statut === 'en_attente'"
                        class="mt-4 flex items-center gap-2"
                    >
                        <button
                            type="button"
                            class="rounded-lg bg-green-600
                                   px-4 py-2 text-xs font-medium
                                   text-white hover:bg-green-700"
                            @click="updateStatus(document, 'valide')"
                        >
                            ✓ Approve
                        </button>

                        <button
                            type="button"
                            class="rounded-lg border
                                   border-red-200 bg-white
                                   px-4 py-2 text-xs font-medium
                                   text-red-600 hover:bg-red-50"
                            @click="updateStatus(document, 'rejete')"
                        >
                            × Reject
                        </button>
                    </div>

                    <!-- Already reviewed -->
                    <div
                        v-else
                        class="mt-4 text-xs text-gray-500"
                    >
                        This submission has already been reviewed.
                    </div>
                </div>
=======
                </article>
>>>>>>> 3b91466 (Add task  supervisor palette)
            </div>

            <!-- Pagination -->
            <div
                v-if="documents.links?.length > 3"
                class="mt-6 flex flex-wrap justify-center gap-1.5"
            >
                <Link
                    v-for="(link, index) in documents.links"
                    :key="`${link.label}-${index}`"
                    :href="link.url || '#'"
                    preserve-scroll
                    class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border px-3 py-2 text-sm font-medium transition"
                    :class="[
                        link.active
                            ? 'border-[#39719F] bg-[#39719F] text-white'
                            : 'border-[#A9CEDB] bg-white text-[#39719F] hover:border-[#60ADC6] hover:bg-[#F2F8FA] hover:text-[#072B4E]',

                        !link.url
                            ? 'pointer-events-none opacity-40'
                            : '',
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </EncadrantLayout>
</template>
