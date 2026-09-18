<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    document: {
        type: Object,
        required: true,
    },
})

const internName = () => {
    return (
        props.document.stage?.candidature?.stagiaire?.user?.nom_complet
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

const statusLabel = (status) => {
    switch (status) {
        case 'Validé':
            return 'Approved'
        case 'Rejeté':
            return 'Rejected'
        case 'En attente':
            return 'Pending Review'
        default:
            return status
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'Validé':
            return 'bg-green-50 text-green-700 border-green-200'
        case 'Rejeté':
            return 'bg-red-50 text-red-700 border-red-200'
        default:
            return 'bg-amber-50 text-amber-700 border-amber-200'
    }
}

const updateStatus = (status) => {
    router.patch(
        `/encadrant/documents/${props.document.id}/status`,
        {
            statut: status,
        },
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Review Document" />

    <EncadrantLayout>
        <div class="p-6">

            <!-- Back -->
            <Link
                href="/encadrant/documents"
                class="inline-flex items-center gap-2
                       text-sm font-medium text-gray-500
                       hover:text-[#17629b]"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Back to Documents
            </Link>

            <!-- Header -->
            <div
                class="mt-6 flex flex-col gap-4
                       sm:flex-row sm:items-start
                       sm:justify-between"
            >
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Review Document
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Review the document submitted by your intern.
                    </p>
                </div>

                <span
                    class="inline-flex w-fit rounded-full border
                           px-3 py-1 text-xs font-medium"
                    :class="statusClass(document.statut)"
                >
                    {{ statusLabel(document.statut) }}
                </span>
            </div>

            <!-- Main content -->
            <div class="mt-6 grid gap-6 lg:grid-cols-3">

                <!-- Document -->
                <div class="lg:col-span-2">

                    <div
                        class="rounded-xl border border-gray-200
                               bg-white p-6 shadow-sm"
                    >
                        <h2
                            class="text-base font-semibold
                                   text-gray-900"
                        >
                            Document Information
                        </h2>

                        <!-- File -->
                        <div
                            class="mt-5 flex flex-col gap-4
                                   rounded-xl border border-gray-200
                                   bg-gray-50 p-4
                                   sm:flex-row sm:items-center"
                        >
                            <div
                                class="flex h-12 w-12 shrink-0
                                       items-center justify-center
                                       rounded-lg bg-blue-50"
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
                                        d="M14 2H6a2 2 0 00-2 2v16
                                           a2 2 0 002 2h12
                                           a2 2 0 002-2V8z
                                           M14 2v6h6"
                                    />
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p
                                    class="truncate text-sm
                                           font-semibold text-gray-900"
                                >
                                    {{ document.nom }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Version {{ document.version || '—' }}
                                </p>
                            </div>

                            <!-- Download -->
                            <a
                                :href="`/encadrant/documents/${document.id}/download`"
                                class="inline-flex items-center
                                       justify-center gap-2
                                       rounded-lg bg-[#17629b]
                                       px-4 py-2.5
                                       text-sm font-medium text-white
                                       transition
                                       hover:bg-[#124f7e]"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 3v12m0 0l-4-4m4 4l4-4
                                           M5 21h14"
                                    />
                                </svg>

                                Download
                            </a>
                        </div>

                        <!-- Details -->
                        <div
                            class="mt-6 grid gap-5
                                   sm:grid-cols-2"
                        >
                            <div>
                                <p
                                    class="text-xs font-medium
                                           uppercase tracking-wide
                                           text-gray-400"
                                >
                                    Document Name
                                </p>

                                <p class="mt-1 text-sm text-gray-800">
                                    {{ document.nom }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-xs font-medium
                                           uppercase tracking-wide
                                           text-gray-400"
                                >
                                    Version
                                </p>

                                <p class="mt-1 text-sm text-gray-800">
                                    {{ document.version || '—' }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-xs font-medium
                                           uppercase tracking-wide
                                           text-gray-400"
                                >
                                    Submitted
                                </p>

                                <p class="mt-1 text-sm text-gray-800">
                                    {{ formatDate(document.created_at) }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-xs font-medium
                                           uppercase tracking-wide
                                           text-gray-400"
                                >
                                    Internship
                                </p>

                                <p class="mt-1 text-sm text-gray-800">
                                    {{
                                        document.stage?.sujet
                                        ?? '—'
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Review actions -->
                    <div
                        class="mt-6 rounded-xl
                               border border-gray-200
                               bg-white p-6 shadow-sm"
                    >
                        <h2
                            class="text-base font-semibold
                                   text-gray-900"
                        >
                            Review
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Approve or reject this submitted document.
                        </p>

                        <div
                            v-if="document.statut === 'En attente'"
                            class="mt-5 flex flex-wrap gap-3"
                        >
                            <button
                                type="button"
                                @click="updateStatus('Validé')"
                                class="inline-flex items-center gap-2
                                       rounded-lg bg-green-600
                                       px-5 py-2.5
                                       text-sm font-medium text-white
                                       transition hover:bg-green-700"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                Approve
                            </button>

                            <button
                                type="button"
                                @click="updateStatus('Rejeté')"
                                class="inline-flex items-center gap-2
                                       rounded-lg border border-red-200
                                       bg-white px-5 py-2.5
                                       text-sm font-medium text-red-600
                                       transition hover:bg-red-50"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>

                                Reject
                            </button>
                        </div>

                        <div
                            v-else
                            class="mt-5 rounded-lg bg-gray-50
                                   px-4 py-3 text-sm text-gray-600"
                        >
                            This document has already been reviewed.
                            Current status:
                            <strong>
                                {{ statusLabel(document.statut) }}
                            </strong>
                        </div>
                    </div>
                </div>

                <!-- Intern information -->
                <div>
                    <div
                        class="rounded-xl border border-gray-200
                               bg-white p-6 shadow-sm"
                    >
                        <h2
                            class="text-base font-semibold
                                   text-gray-900"
                        >
                            Intern
                        </h2>

                        <div class="mt-5">

                            <div
                                class="flex h-12 w-12
                                       items-center justify-center
                                       rounded-full bg-blue-50
                                       text-lg font-semibold
                                       text-[#17629b]"
                            >
                                {{
                                    internName()
                                        .charAt(0)
                                        .toUpperCase()
                                }}
                            </div>

                            <p
                                class="mt-3 text-sm
                                       font-semibold text-gray-900"
                            >
                                {{ internName() }}
                            </p>

                            <p
                                v-if="
                                    document.stage
                                        ?.candidature
                                        ?.stagiaire
                                        ?.user
                                        ?.email
                                "
                                class="mt-1 break-all
                                       text-xs text-gray-500"
                            >
                                {{
                                    document.stage
                                        .candidature
                                        .stagiaire
                                        .user
                                        .email
                                }}
                            </p>
                        </div>

                        <div
                            class="mt-5 border-t
                                   border-gray-100 pt-5"
                        >
                            <p
                                class="text-xs font-medium
                                       uppercase tracking-wide
                                       text-gray-400"
                            >
                                Internship
                            </p>

                            <p
                                class="mt-1 text-sm
                                       text-gray-700"
                            >
                                {{
                                    document.stage?.sujet
                                    ?? '—'
                                }}
                            </p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </EncadrantLayout>
</template>
