<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    applications: {
        type: Array,
        default: () => [],
    },
})

function statusClass(status) {
    const value = String(status || '').toLowerCase()

    if (
        value.includes('accept') ||
        value.includes('reten') ||
        value.includes('valid')
    ) {
        return 'bg-emerald-50 text-emerald-700 border border-emerald-100'
    }

    if (
        value.includes('reject') ||
        value.includes('refus')
    ) {
        return 'bg-red-50 text-red-700 border border-red-100'
    }

    if (
        value.includes('interview') ||
        value.includes('entretien')
    ) {
        return 'bg-violet-50 text-violet-700 border border-violet-100'
    }

    return 'bg-amber-50 text-amber-700 border border-amber-100'
}

function formatStatus(status) {
    const value = String(status || '').toLowerCase()

    if (
        value.includes('accept') ||
        value.includes('reten') ||
        value.includes('valid')
    ) {
        return 'Accepted'
    }

    if (
        value.includes('reject') ||
        value.includes('refus')
    ) {
        return 'Rejected'
    }

    if (
        value.includes('interview') ||
        value.includes('entretien')
    ) {
        return 'Interview'
    }

    return 'Pending'
}

function formatDate(date) {
    if (!date) return ''

    return new Intl.DateTimeFormat('en-US', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <!-- Header -->
        <div class="mb-5 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    My Applications
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Track the progress of your applications.
                </p>
            </div>

            <Link
                :href="route('stagiaire.candidatures.index')"
                class="text-sm font-semibold text-[#2F6690] transition hover:text-[#16425B]"
            >
                View all
            </Link>
        </div>

        <!-- Applications -->
        <div
            v-if="applications.length"
            class="space-y-2"
        >
            <div
                v-for="application in applications"
                :key="application.id"
                class="flex flex-col gap-3 rounded-xl border border-slate-200
                       bg-slate-50 px-4 py-3
                       transition duration-200
                       hover:border-[#81C3D7]
                       hover:bg-[#F4F7F9]
                       hover:shadow-sm
                       sm:flex-row
                       sm:items-center
                       sm:justify-between"
            >
                <!-- Offer information -->
                <div class="min-w-0">
                    <h3
                        class="truncate text-sm font-semibold text-[#16425B]"
                    >
                        {{
                            application?.offre_de_stage?.titre ||
                            application?.offreDeStage?.titre ||
                            application?.offre?.titre ||
                            'Application'
                        }}
                    </h3>

                    <p
                        class="mt-1 truncate text-xs font-medium text-[#64748B]"
                    >
                        {{
                            application?.offre_de_stage?.entreprise?.user?.nom_complet ||
                            application?.offreDeStage?.entreprise?.user?.nom_complet ||
                            application?.offre?.entreprise?.user?.nom_complet ||
                            application?.offre?.entreprise?.name ||
                            'Company'
                        }}
                    </p>
                </div>

                <!-- Status + Date -->
                <div class="flex items-center gap-3">
                    <span
                        class="rounded-full px-2.5 py-1 text-xs font-semibold"
                        :class="statusClass(application?.statut)"
                    >
                        {{ formatStatus(application?.statut) }}
                    </span>

                    <span
                        v-if="application?.date_postulation"
                        class="hidden text-xs font-medium text-[#64748B] md:block"
                    >
                        {{ formatDate(application.date_postulation) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Empty state -->
        <div
            v-else
            class="rounded-xl border border-dashed border-slate-200
                   bg-slate-50 px-5 py-10 text-center"
        >
            <div class="text-3xl">📄</div>

            <h3 class="mt-3 font-semibold text-slate-700">
                No applications yet
            </h3>

            <p class="mt-1 text-sm text-slate-400">
                Your applications will appear here.
            </p>
        </div>
    </section>
</template>
