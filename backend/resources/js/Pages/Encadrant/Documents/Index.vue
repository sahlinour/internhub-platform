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
        document.stage?.candidature?.stagiaire?.user?.nom_complet
        ?? 'Unknown intern'
    )
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
</script>

<template>
    <Head title="Documents" />

    <EncadrantLayout>
        <div class="p-6">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    Documents
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Review documents submitted by your interns.
                </p>
            </div>

            <!-- Table -->
            <div
                class="overflow-hidden rounded-xl
                       border border-gray-200 bg-white shadow-sm"
            >
                <table class="w-full text-left">

                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500">
                                Document
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500">
                                Intern
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        <tr
                            v-for="document in documents.data"
                            :key="document.id"
                            class="hover:bg-gray-50"
                        >
                            <!-- Document -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 items-center
                                               justify-center rounded-lg
                                               bg-blue-50 text-[#17629b]"
                                    >
                                        📄
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ document.nom }}
                                        </p>

                                        <p class="text-xs text-gray-400">
                                            {{ document.version }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Intern -->
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ internName(document) }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span
                                    class="rounded-full px-3 py-1
                                           text-xs font-medium"
                                    :class="statusClass(document.statut)"
                                >
                                    {{ document.statut }}
                                </span>
                            </td>

                            <!-- Action -->
                            <td class="px-6 py-4">
                               <Link
                                :href="`/encadrant/documents/${document.id}/review`"
                                class="inline-flex items-center gap-2
                                    rounded-lg border border-gray-200
                                    px-4 py-2 text-sm font-medium
                                    text-gray-700 transition
                                    hover:border-[#17629b]
                                    hover:text-[#17629b]"
                            >
                                Review

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
                                        d="M9 18l6-6-6-6"
                                    />
                                </svg>
                            </Link>
                            </td>
                        </tr>

                        <!-- Empty -->
                        <tr v-if="!documents.data?.length">
                            <td
                                colspan="4"
                                class="px-6 py-12 text-center text-sm text-gray-500"
                            >
                                No documents submitted yet.
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </EncadrantLayout>
</template>
