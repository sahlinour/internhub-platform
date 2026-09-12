<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    offres: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <section
        v-if="offres.length"
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
    >
        <h2 class="text-lg font-bold text-slate-900">
            Similar internships
        </h2>

        <div class="mt-5 space-y-3">

            <Link
                v-for="offre in offres"
                :key="offre.id"
                :href="route('offres.show', offre.id)"
                class="block rounded-xl border border-slate-100 p-4 transition hover:border-[#81C3D7] hover:bg-slate-50"
            >
                <h3 class="font-semibold text-slate-900">
                    {{ offre.titre }}
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{
                        offre.entreprise?.user?.nom_complet ||
                        offre.entreprise?.nom ||
                        'Entreprise'
                    }}
                </p>

                <div class="mt-2 flex gap-4 text-xs text-slate-400">
                    <span v-if="offre.duree">
                        {{ offre.duree }}
                    </span>

                    <span v-if="offre.entreprise?.user?.ville?.nom">
                        {{ offre.entreprise.user.ville.nom }}
                    </span>
                </div>
            </Link>

        </div>
    </section>
</template>