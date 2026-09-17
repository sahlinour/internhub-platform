<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

defineProps({
    documents: {
        type: Object,
        required: true,
    },
})

const updateStatus = (document, status) => {
    router.patch(
        `/encadrant/documents/${document.id}/status`,
        {
            statut: status,
        },
        {
            preserveScroll: true,
        }
    )
}

const statusLabel = (status) => {
    switch (status) {
        case 'Validé':
            return 'Approved'
        case 'Rejeté':
            return 'Rejected'
        case 'En attente':
            return 'Awaiting Review'
        default:
            return status
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'Validé':
            return 'bg-green-50 text-green-700'
        case 'Rejeté':
            return 'bg-red-50 text-red-700'
        default:
            return 'bg-amber-50 text-amber-700'
    }
}

const internName = (document) => {
    return (
        document.stage?.candidature?.stagiaire?.user?.nom_complet
        ?? 'Unknown intern'
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
        <div class="p-6">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    Task Reviews
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Review submitted work from your interns.
                </p>
            </div>

            <!-- Empty state -->
            <div
                v-if="!documents.data || documents.data.length === 0"
                class="rounded-xl border border-gray-200 bg-white
                       px-6 py-16 text-center shadow-sm"
            >
                <div
                    class="mx-auto mb-4 flex h-12 w-12
                           items-center justify-center
                           rounded-full bg-blue-50"
                >
                    <svg
                        class="h-6 w-6 text-[#17629b]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M9 12l2 2 4-4
                               M7 3h10a2 2 0 012 2v14
                               a2 2 0 01-2 2H7
                               a2 2 0 01-2-2V5
                               a2 2 0 012-2z"
                        />
                    </svg>
                </div>

                <h2 class="font-semibold text-gray-900">
                    No submissions to review
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Intern submissions will appear here.
                </p>
            </div>

            <!-- Reviews -->
            <div v-else class="space-y-4">

                <div
                    v-for="document in documents.data"
                    :key="document.id"
                    class="rounded-xl border border-gray-200
                           bg-white p-5 shadow-sm"
                >
                    <!-- Top -->
                    <div
                        class="flex items-start
                               justify-between gap-4"
                    >
                        <div>
                            <h2
                                class="text-base font-semibold
                                       text-gray-900"
                            >
                                {{
                                    document.stage?.sujet
                                    ?? 'Internship submission'
                                }}
                            </h2>

                            <p class="mt-1 text-xs text-gray-500">
                                {{ internName(document) }}
                                · Submitted
                                {{ formatDate(document.created_at) }}
                            </p>
                        </div>

                        <span
                            class="shrink-0 rounded-full
                                   px-3 py-1 text-xs font-medium"
                            :class="statusClass(document.statut)"
                        >
                            {{ statusLabel(document.statut) }}
                        </span>
                    </div>

                    <!-- Related tasks -->
                    <div
                        v-if="document.stage?.taches?.length"
                        class="mt-4"
                    >
                        <p
                            class="mb-2 text-xs font-semibold
                                   uppercase tracking-wide
                                   text-gray-400"
                        >
                            Stage Tasks
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="task in document.stage.taches"
                                :key="task.id"
                                class="rounded-md bg-gray-100
                                       px-2.5 py-1 text-xs
                                       text-gray-700"
                            >
                                {{ task.titre }}
                            </span>
                        </div>
                    </div>

                    <!-- Submitted file -->
                    <div
                        class="mt-4 flex items-center
                               rounded-lg border border-gray-200
                               px-3 py-2.5"
                    >
                        <svg
                            class="mr-2 h-4 w-4 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M14 2H6a2 2 0 00-2 2v16
                                   a2 2 0 002 2h12
                                   a2 2 0 002-2V8z
                                   M14 2v6h6"
                            />
                        </svg>

                     <a
                        v-if="document.fichier_url"
                        :href="`/encadrant/documents/${document.id}/download`"
                        class="text-sm text-[#17629b] hover:underline"
                    >
                        {{ document.nom }}
                    </a>

                        <span
                            v-else
                            class="text-sm text-gray-600"
                        >
                            {{ document.nom }}
                        </span>

                        <span
                            v-if="document.version"
                            class="ml-auto text-xs text-gray-400"
                        >
                            v{{ document.version }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div
                        v-if="document.statut === 'En attente'"
                        class="mt-4 flex items-center gap-2"
                    >
                        <button
                            type="button"
                            class="rounded-lg bg-green-600
                                   px-4 py-2 text-xs font-medium
                                   text-white hover:bg-green-700"
                            @click="updateStatus(document, 'Validé')"
                        >
                            ✓ Approve
                        </button>

                        <button
                            type="button"
                            class="rounded-lg border
                                   border-red-200 bg-white
                                   px-4 py-2 text-xs font-medium
                                   text-red-600 hover:bg-red-50"
                            @click="updateStatus(document, 'Rejeté')"
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
            </div>

            <!-- Pagination -->
            <div
                v-if="documents.links && documents.links.length > 3"
                class="mt-6 flex justify-center gap-1"
            >
                <Link
                    v-for="link in documents.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    v-html="link.label"
                    class="rounded border px-3 py-2 text-sm"
                    :class="[
                        link.active
                            ? 'border-[#17629b] bg-[#17629b] text-white'
                            : 'border-gray-200 bg-white text-gray-600',
                        !link.url
                            ? 'pointer-events-none opacity-50'
                            : 'hover:bg-gray-50',
                    ]"
                />
            </div>

        </div>
    </EncadrantLayout>
</template>
