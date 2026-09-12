<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    offre: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <div class="space-y-6 lg:sticky lg:top-6">

        <!-- Apply -->
        <section
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <h2 class="text-lg font-bold text-slate-900">
                Interested in this internship?
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Submit your application for this internship opportunity.
            </p>

            <Link
                :href="route('stagiaire.candidatures.create', offre.id)"
                class="mt-5 flex w-full items-center justify-center rounded-xl bg-[#2F6690] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#16425B]"
            >
                Apply Now
            </Link>
        </section>

        <!-- Offer information -->
        <section
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
        >
            <h2 class="text-base font-bold text-slate-900">
                Informations
            </h2>

            <div class="mt-5 space-y-4">

                <div v-if="offre.duree">
                    <p class="text-xs text-slate-400">
                        Durée
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-700">
                        {{ offre.duree }}
                    </p>
                </div>

                <div v-if="offre.date_debut">
                    <p class="text-xs text-slate-400">
                        Date de début
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-700">
                        {{ offre.date_debut }}
                    </p>
                </div>

                <div v-if="offre.date_fin">
                    <p class="text-xs text-slate-400">
                        Date de fin
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-700">
                        {{ offre.date_fin }}
                    </p>
                </div>

                <div v-if="offre.salaire">
                    <p class="text-xs text-slate-400">
                        Salaire
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-700">
                        {{ offre.salaire }}
                    </p>
                </div>

                <div v-if="offre.type_travail || offre.work_type">
                    <p class="text-xs text-slate-400">
                        Type
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-700">
                        {{ offre.type_travail || offre.work_type }}
                    </p>
                </div>

            </div>
        </section>
    </div>
</template>