<script setup>
import { Head, Link } from '@inertiajs/vue3'

import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

defineProps({
    documents: {
        type: Object,
        required: true,
    },
})

const internName = (document) => {
    return (
        document.stage?.candidature?.stagiaire?.user?.nom_complet ??
        'Unknown intern'
    )
}

const statusLabel = (status) => {
    switch (status) {
        case 'valide':
            return 'Approved'

        case 'rejete':
            return 'Rejected'

        case 'en_attente':
            return 'Pending Review'

        default:
            return status ?? 'Unknown'
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'valide':
            return 'border-emerald-200 bg-emerald-50 text-emerald-700'

        case 'rejete':
            return 'border-red-200 bg-red-50 text-red-700'

        case 'en_attente':
            return 'border-amber-200 bg-amber-50 text-amber-700'

        default:
            return 'border-[#A9CEDB] bg-[#F2F8FA] text-[#39719F]'
    }
}
</script>

<template>
    <Head title="Documents" />

    <EncadrantLayout>
        <div class="mx-auto max-w-[1500px] p-6">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-[#072B4E]">
                    Documents
                </h1>

                <p class="mt-1 text-sm text-[#507291]">
                    Review documents submitted by your interns.
                </p>
            </div>

            <!-- Documents table -->
            <div
                class="overflow-hidden rounded-xl border border-[#A9CEDB]/80 bg-white shadow-sm"
            >
                <div
                    class="h-1 bg-gradient-to-r from-[#072B4E] via-[#39719F] to-[#60ADC6]"
                ></div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[720px] text-left">
                        <thead
                            class="border-b border-[#A9CEDB]/70 bg-[#F2F8FA]"
                        >
                            <tr>
                                <th
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-[#39719F]"
                                >
                                    Document
                                </th>

                                <th
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-[#39719F]"
                                >
                                    Intern
                                </th>

                                <th
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-[#39719F]"
                                >
                                    Status
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-[#39719F]"
                                >
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#A9CEDB]/40">
                            <tr
                                v-for="document in documents.data"
                                :key="document.id"
                                class="transition hover:bg-[#F2F8FA]/70"
                            >
                                <!-- Document -->
                                <td class="px-6 py-4">
                                    <p
                                        class="text-sm font-semibold text-[#072B4E]"
                                    >
                                        {{ document.nom }}
                                    </p>

                                    <p
                                        class="mt-1 text-xs text-[#6695AF]"
                                    >
                                        {{
                                            document.version
                                                ? `v${document.version}`
                                                : 'No version'
                                        }}
                                    </p>
                                </td>

                                <!-- Intern -->
                                <td
                                    class="px-6 py-4 text-sm text-[#507291]"
                                >
                                    {{ internName(document) }}
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold"
                                        :class="statusClass(document.statut)"
                                    >
                                        {{ statusLabel(document.statut) }}
                                    </span>
                                </td>

                                <!-- Action -->
                                <td class="px-6 py-4 text-right">
                                    <Link
                                        :href="
                                            route(
                                                'encadrant.documents.show',
                                                {
                                                    id: document.id,
                                                }
                                            )
                                        "
                                        class="inline-flex items-center gap-2 rounded-lg border border-[#A9CEDB] bg-white px-4 py-2 text-sm font-semibold text-[#39719F] transition hover:border-[#39719F] hover:bg-[#39719F] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#60ADC6]/40"
                                    >
                                        Review

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
                                                d="M9 18l6-6-6-6"
                                            />
                                        </svg>
                                    </Link>
                                </td>
                            </tr>

                            <!-- Empty state -->
                            <tr v-if="!documents.data?.length">
                                <td
                                    colspan="4"
                                    class="px-6 py-16 text-center"
                                >
                                    <p
                                        class="text-sm font-semibold text-[#072B4E]"
                                    >
                                        No documents submitted yet
                                    </p>

                                    <p
                                        class="mt-1 text-xs text-[#507291]"
                                    >
                                        Documents submitted by your interns
                                        will appear here.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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