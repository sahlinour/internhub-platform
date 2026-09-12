<script setup>
import { Link } from '@inertiajs/vue3';
import OfferCard from './OfferCard.vue';

defineProps({
    offers: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-5 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Offres recommandées
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Des opportunités qui peuvent correspondre à votre profil.
                </p>
            </div>

            <Link
                :href="route('offres.index')"
                class="hidden text-sm font-semibold text-[#2F6690] hover:text-[#16425B] sm:block"
            >
                Voir tout
            </Link>
        </div>

        <div
            v-if="offers.length"
            class="grid gap-4 md:grid-cols-2"
        >
            <OfferCard
                v-for="offer in offers"
                :key="offer.id"
                :offer="offer"
            />
        </div>

        <div
            v-else
            class="rounded-xl border border-dashed border-slate-200 px-5 py-10 text-center"
        >
            <div class="text-3xl">💼</div>

            <h3 class="mt-3 font-semibold text-slate-700">
                Aucune offre recommandée
            </h3>

            <p class="mt-1 text-sm text-slate-400">
                Les offres correspondant à votre profil apparaîtront ici.
            </p>
        </div>

        <Link
            :href="route('offres.index')"
            class="mt-4 block text-center text-sm font-semibold text-[#2F6690] sm:hidden"
        >
            Voir toutes les offres
        </Link>
    </section>
</template>