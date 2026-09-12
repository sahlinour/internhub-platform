<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    applications: {
        type: Array,
        default: () => [],
    },
});

function statusClass(status) {
    const value = String(status || '').toLowerCase();

    if (
        value.includes('accept') ||
        value.includes('reten') ||
        value.includes('valid')
    ) {
        return 'bg-emerald-50 text-emerald-700';
    }

    if (
        value.includes('reject') ||
        value.includes('refus')
    ) {
        return 'bg-red-50 text-red-700';
    }

    if (
        value.includes('interview') ||
        value.includes('entretien')
    ) {
        return 'bg-violet-50 text-violet-700';
    }

    return 'bg-amber-50 text-amber-700';
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-5 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Suivi des candidatures
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Suivez l'évolution de vos candidatures.
                </p>
            </div>

            <Link
                :href="route('stagiaire.candidatures.index')"
                class="text-sm font-semibold text-[#2F6690] hover:text-[#16425B]"
            >
                Voir tout
            </Link>
        </div>

        <div
            v-if="applications.length"
            class="divide-y divide-slate-100"
        >
            <div
                v-for="application in applications"
                :key="application.id"
                class="flex flex-col gap-3 py-4 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between"
            >
                <div class="min-w-0">
                    <h3 class="truncate text-sm font-semibold text-slate-700">
                        {{
                            application?.offre?.titre ||
                            application?.offre?.title ||
                            'Candidature'
                        }}
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        {{
                            application?.offre?.entreprise?.name ||
                            'Entreprise'
                        }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <span
                        class="rounded-full px-2.5 py-1 text-xs font-semibold"
                        :class="statusClass(application?.statut)"
                    >
                        {{ application?.statut || 'En attente' }}
                    </span>

                    <span
                        v-if="application?.created_at"
                        class="hidden text-xs text-slate-400 md:block"
                    >
                        {{ application.created_at }}
                    </span>
                </div>
            </div>
        </div>

        <div
            v-else
            class="rounded-xl border border-dashed border-slate-200 px-5 py-10 text-center"
        >
            <div class="text-3xl">📄</div>

            <h3 class="mt-3 font-semibold text-slate-700">
                Aucune candidature
            </h3>

            <p class="mt-1 text-sm text-slate-400">
                Vos candidatures apparaîtront ici.
            </p>
        </div>
    </section>
</template>