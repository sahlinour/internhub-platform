<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const getCompanyName = (offre) => {
    return (
        offre?.entreprise?.user?.nom_complet ||
        offre?.entreprise?.nom ||
        offre?.entreprise?.raison_sociale ||
        'Entreprise'
    )
}

const getLocation = (offre) => {
    return (
        offre?.entreprise?.user?.ville?.nom ||
        offre?.ville?.nom ||
        offre?.ville_nom ||
        null
    )
}
</script>

<template>
    <div>
        <!-- Back -->
        <Link
            :href="route('offres.index')"
            class="mb-5 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#2F6690]"
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

            Retour aux offres
        </Link>

        <section
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
        >
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                <div class="flex gap-4">

                    <!-- Company avatar -->
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#EAF3F8] text-xl font-bold text-[#2F6690]"
                    >
                        {{
                            getCompanyName(offre)
                                .charAt(0)
                                .toUpperCase()
                        }}
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                            {{ offre.titre }}
                        </h1>

                        <p class="mt-1 font-medium text-slate-600">
                            {{ getCompanyName(offre) }}
                        </p>

                        <div
                            v-if="getLocation(offre)"
                            class="mt-3 flex items-center gap-2 text-sm text-slate-500"
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
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                            </svg>

                            {{ getLocation(offre) }}
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <span
                    v-if="offre.statut"
                    class="w-fit rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700"
                >
                    {{ offre.statut }}
                </span>
            </div>

            <!-- Meta -->
            <div
                class="mt-7 grid grid-cols-1 gap-4 border-t border-slate-100 pt-6 sm:grid-cols-3"
            >
                <div
                    v-if="offre.duree"
                    class="flex items-center gap-3"
                >
                    <div class="rounded-lg bg-slate-100 p-2 text-[#2F6690]">
                        ◷
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">
                            Durée
                        </p>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ offre.duree }}
                        </p>
                    </div>
                </div>

                <div
                    v-if="offre.salaire"
                    class="flex items-center gap-3"
                >
                    <div class="rounded-lg bg-slate-100 p-2 text-[#2F6690]">
                        💰
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">
                            Salaire
                        </p>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ offre.salaire }}
                        </p>
                    </div>
                </div>

                <div
                    v-if="offre.type_travail || offre.work_type"
                    class="flex items-center gap-3"
                >
                    <div class="rounded-lg bg-slate-100 p-2 text-[#2F6690]">
                        ◉
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">
                            Type de travail
                        </p>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ offre.type_travail || offre.work_type }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>