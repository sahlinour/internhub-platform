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
        year: 'numeric',
    })
}
const getOffer = (candidature) => candidature?.offre_de_stage
const companyName = (candidature) =>
    getOffer(candidature)?.entreprise?.user?.nom_complet ||
    getOffer(candidature)?.entreprise?.user?.name ||
    getOffer(candidature)?.entreprise?.nom ||
    'Company'
const companyLocation = (candidature) =>
    getOffer(candidature)?.entreprise?.user?.ville?.nom || '-'
const roleName = (candidature) =>
    getOffer(candidature)?.titre || 'Internship'
const duration = (candidature) =>
    getOffer(candidature)?.duree || '-'
const hasCv = (candidature) =>
    Boolean(candidature?.cv_url || candidature?.piece_jointe)
const hasCoverLetter = (candidature) =>
    Boolean(candidature?.lettre_de_motivation)
</script>

<template>
    <div class="w-full">

        <!-- Desktop -->
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-left">
                <thead class="border-b border-slate-100 bg-slate-50/60">
                    <tr class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                        <th class="px-5 py-3">Internship</th>
                        <th class="px-5 py-3">Company</th>
                        <th class="px-5 py-3">Details</th>
                        <th class="px-5 py-3">Applied</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="candidature in candidatures"
                        :key="candidature.id"
                        class="border-b border-slate-100 last:border-0 transition hover:bg-[#F4F7F9]"
                    >
                        <!-- Internship -->
                        <td class="px-5 py-4">
                            <div class="min-w-[180px]">
                                <p class="truncate text-xs font-bold text-[#16425B]">
                                    {{ roleName(candidature) }}
                                </p>

                                <p class="mt-1 text-[10px] text-slate-400">
                                    Deadline:
                                    {{ formatDate(getOffer(candidature)?.date_limite) }}
                                </p>
                            </div>
                        </td>

                        <!-- Company -->
                        <td class="px-5 py-4">
                            <div class="min-w-[130px]">
                                <p class="truncate text-xs font-semibold text-slate-700">
                                    {{ companyName(candidature) }}
                                </p>

                                <div class="mt-1 flex items-center gap-1 text-[10px] text-slate-400">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 21s7-5.5 7-11a7 7 0 10-14 0c0 5.5 7 11 7 11z"
                                        />
                                        <circle
                                            cx="12"
                                            cy="10"
                                            r="2.2"
                                        />
                                    </svg>

                                    {{ companyLocation(candidature) }}
                                </div>
                            </div>
                        </td>

                        <!-- Details -->
                        <td class="px-5 py-4">
                            <div class="space-y-1">
                                <p class="text-[10px] text-slate-500">
                                    <span class="font-semibold text-slate-700">
                                        Duration:
                                    </span>
                                    {{ duration(candidature) }}
                                </p>

                                <div class="flex items-center gap-2 text-[10px]">
                                    <span
                                        class="inline-flex items-center gap-1"
                                        :class="hasCv(candidature)
                                            ? 'text-[#3A7CA5]'
                                            : 'text-slate-400'"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full"
                                            :class="hasCv(candidature)
                                                ? 'bg-[#3A7CA5]'
                                                : 'bg-slate-300'"
                                        ></span>
                                        CV
                                    </span>

                                    <span
                                        class="inline-flex items-center gap-1"
                                        :class="hasCoverLetter(candidature)
                                            ? 'text-[#3A7CA5]'
                                            : 'text-slate-400'"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full"
                                            :class="hasCoverLetter(candidature)
                                                ? 'bg-[#3A7CA5]'
                                                : 'bg-slate-300'"
                                        ></span>
                                        Letter
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- Applied -->
                        <td class="whitespace-nowrap px-5 py-4">
                            <p class="text-xs font-medium text-slate-700">
                                {{ formatDate(candidature.date_postulation) }}
                            </p>
                        </td>

                        <!-- Status -->
                        <td class="px-5 py-4">
                            <ApplicationStatusBadge
                                :status="candidature.statut"
                            />
                        </td>

                        <!-- Action -->
                        <td class="px-5 py-4 text-right">
                            <Link
                                v-if="getOffer(candidature)?.id"
                                :href="route('stagiaire.candidatures.show', candidature.id)"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#16425B] transition hover:text-[#3A7CA5]"
                            >
                                View
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 12h14m-6-6 6 6-6 6"
                                    />
                                </svg>
                            </Link>
                        </td>
                    </tr>

                    <!-- Empty -->
                    <tr v-if="!candidatures.length">
                        <td
                            colspan="6"
                            class="px-5 py-12 text-center"
                        >
                            <div class="flex flex-col items-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F1F5] text-[#3A7CA5]">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12h6m-6 4h4m5-13H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2z"
                                        />
                                    </svg>
                                </div>

                                <p class="mt-3 text-xs font-semibold text-slate-700">
                                    No applications yet
                                </p>

                                <p class="mt-1 text-[11px] text-slate-400">
                                    Your internship applications will appear here.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Mobile -->
        <div class="divide-y divide-slate-100 md:hidden">
            <article
                v-for="candidature in candidatures"
                :key="candidature.id"
                class="p-4"
            >
                <!-- Top -->
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="truncate text-xs font-bold text-[#16425B]">
                            {{ roleName(candidature) }}
                        </h3>

                        <p class="mt-1 truncate text-[11px] font-medium text-slate-600">
                            {{ companyName(candidature) }}
                        </p>

                        <p class="mt-1 text-[10px] text-slate-400">
                            {{ companyLocation(candidature) }}
                        </p>
                    </div>

                    <ApplicationStatusBadge
                        :status="candidature.statut"
                    />
                </div>

                <!-- Information -->
                <div class="mt-4 grid grid-cols-2 gap-2 rounded-xl bg-[#F4F7F9] p-3">
                    <div>
                        <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                            Duration
                        </p>
                        <p class="mt-1 text-[11px] font-medium text-slate-700">
                            {{ duration(candidature) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                            Applied
                        </p>
                        <p class="mt-1 text-[11px] font-medium text-slate-700">
                            {{ formatDate(candidature.date_postulation) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                            Deadline
                        </p>
                        <p class="mt-1 text-[11px] font-medium text-slate-700">
                            {{ formatDate(getOffer(candidature)?.date_limite) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                            Documents
                        </p>

                        <p class="mt-1 text-[11px] font-medium text-slate-700">
                            <span v-if="hasCv(candidature)">CV</span>
                            <span v-if="hasCv(candidature) && hasCoverLetter(candidature)">
                                ·
                            </span>
                            <span v-if="hasCoverLetter(candidature)">
                                Letter
                            </span>
                            <span
                                v-if="!hasCv(candidature) && !hasCoverLetter(candidature)"
                                class="text-slate-400"
                            >
                                None
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Action -->
                <div class="mt-3 flex justify-end">
                    <Link
                        v-if="getOffer(candidature)?.id"
                        :href="route('offres.show', getOffer(candidature).id)"
                        class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#16425B] hover:text-[#3A7CA5]"
                    >
                        View internship

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-3.5 w-3.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 12h14m-6-6 6 6-6 6"
                            />
                        </svg>
                    </Link>
                </div>
            </article>

            <!-- Mobile empty -->
            <div
                v-if="!candidatures.length"
                class="px-5 py-12 text-center"
            >
                <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F1F5] text-[#3A7CA5]">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h4m5-13H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2z"
                        />
                    </svg>
                </div>
                <p class="mt-3 text-xs font-semibold text-slate-700">
                    No applications yet
                </p>

                <p class="mt-1 text-[11px] text-slate-400">
                    Your internship applications will appear here.
                </p>
            </div>
        </div>
    </div>
</template>
