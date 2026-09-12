<script setup>
import { Link } from '@inertiajs/vue3'
import ApplicationStatusBadge from './ApplicationStatusBadge.vue'

defineProps({
    candidatures: {
        type: Array,
        default: () => [],
    },
})

const formatDate = (date) => {
    if (!date) return '-'

    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
    })
}

const companyName = (candidature) => {
    return (
        candidature?.offre_de_stage?.entreprise?.user?.nom_complet ||
        candidature?.offre_de_stage?.entreprise?.user?.name ||
        candidature?.offre_de_stage?.entreprise?.nom ||
        'Company'
    )
}

const roleName = (candidature) => {
    return candidature?.offre_de_stage?.titre || 'Internship'
}
</script>

<template>
    <div class="w-full">
        <!-- Desktop -->
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full border-collapse text-left">
                <!-- Header -->
                <thead>
                    <tr class="border-b border-slate-100">
                        <th
                            class="w-[15%] px-4 py-2.5
                                   text-[10px] font-medium text-slate-500
                                   sm:px-5"
                        >
                            Company
                        </th>

                        <th
                            class="w-[40%] px-4 py-2.5
                                   text-[10px] font-medium text-slate-500
                                   sm:px-5"
                        >
                            Role
                        </th>

                        <th
                            class="w-[13%] px-4 py-2.5
                                   text-[10px] font-medium text-slate-500
                                   sm:px-5"
                        >
                            Applied
                        </th>

                        <th
                            class="w-[17%] px-4 py-2.5
                                   text-[10px] font-medium text-slate-500
                                   sm:px-5"
                        >
                            Status
                        </th>

                        <th
                            class="w-[15%] px-4 py-2.5
                                   text-right text-[10px] font-medium text-slate-500
                                   sm:px-5"
                        >
                            Action
                        </th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody>
                    <tr
                        v-for="candidature in candidatures"
                        :key="candidature.id"
                        class="border-b border-slate-100 last:border-b-0
                               transition hover:bg-slate-50/60"
                    >
                        <!-- Company -->
                        <td class="px-4 py-3 sm:px-5">
                            <div
                                class="text-[11px] font-semibold text-slate-800"
                            >
                                {{ companyName(candidature) }}
                            </div>
                        </td>

                        <!-- Role -->
                        <td class="px-4 py-3 sm:px-5">
                            <div
                                class="truncate text-[11px] text-slate-600"
                            >
                                {{ roleName(candidature) }}
                            </div>
                        </td>

                        <!-- Applied -->
                        <td
                            class="whitespace-nowrap px-4 py-3
                                   text-[11px] text-slate-500 sm:px-5"
                        >
                            {{ formatDate(candidature.date_postulation) }}
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-3 sm:px-5">
                            <ApplicationStatusBadge
                                :status="candidature.statut"
                            />
                        </td>

                        <!-- Action -->
                        <td class="px-4 py-3 text-right sm:px-5">
                            <Link
                                :href="route(
                                    'stagiaire.candidatures.index'
                                )"
                                class="text-[11px] font-semibold
                                       text-[#16425B]
                                       transition hover:text-[#2F6690]"
                            >
                                View
                            </Link>
                        </td>
                    </tr>

                    <!-- Empty state -->
                    <tr v-if="!candidatures.length">
                        <td
                            colspan="5"
                            class="px-5 py-10 text-center
                                   text-xs text-slate-400"
                        >
                            No applications found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile -->
        <div class="divide-y divide-slate-100 md:hidden">
            <div
                v-for="candidature in candidatures"
                :key="candidature.id"
                class="px-4 py-4"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p
                            class="truncate text-xs font-semibold
                                   text-slate-800"
                        >
                            {{ companyName(candidature) }}
                        </p>

                        <p
                            class="mt-1 truncate text-[11px]
                                   text-slate-500"
                        >
                            {{ roleName(candidature) }}
                        </p>
                    </div>

                    <ApplicationStatusBadge
                        :status="candidature.statut"
                    />
                </div>

                <div class="mt-3 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400">
                        Applied {{ formatDate(candidature.date_postulation) }}
                    </span>

                    <Link
                        :href="route(
                            'stagiaire.candidatures.index'
                        )"
                        class="text-[11px] font-semibold text-[#16425B]
                               transition hover:text-[#2F6690]"
                    >
                        View
                    </Link>
                </div>
            </div>

            <!-- Mobile empty -->
            <div
                v-if="!candidatures.length"
                class="px-5 py-10 text-center
                       text-xs text-slate-400"
            >
                No applications found.
            </div>
        </div>
    </div>
</template>