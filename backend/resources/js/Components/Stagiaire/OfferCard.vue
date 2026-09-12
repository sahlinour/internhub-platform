<script setup>
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    offer: {
        type: Object,
        required: true,
    },
});

function toggleFavorite() {
    if (!props.offer?.id) return;

    router.post(
        route('stagiaire.favoris.toggle', props.offer.id),
        {},
        {
            preserveScroll: true,
        }
    );
}

function apply() {
    if (!props.offer?.id) return;

    router.post(
        route('stagiaire.candidatures.store', props.offer.id),
        {},
        {
            preserveScroll: true,
        }
    );
}
</script>

<template>
    <article
        class="rounded-xl border border-slate-200 bg-white p-4 transition hover:border-[#81C3D7] hover:shadow-sm"
    >
        <div class="flex items-start justify-between gap-3">
            <div class="flex min-w-0 items-center gap-3">
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF4F8] text-sm font-bold text-[#2F6690]"
                >
                    {{ offer?.entreprise?.name?.charAt(0)?.toUpperCase() || 'E' }}
                </div>

                <div class="min-w-0">
                    <h3 class="truncate font-semibold text-slate-800">
                        {{ offer?.titre || 'Offre de stage' }}
                    </h3>

                    <p class="truncate text-sm text-slate-500">
                        {{ offer?.entreprise?.name || 'Entreprise' }}
                    </p>
                </div>
            </div>

            <button
                type="button"
                @click="toggleFavorite"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-lg transition hover:bg-slate-100"
                :class="
                    offer?.is_favorite
                        ? 'text-amber-500'
                        : 'text-slate-400'
                "
                :title="
                    offer?.is_favorite
                        ? 'Retirer des favoris'
                        : 'Ajouter aux favoris'
                "
            >
                {{ offer?.is_favorite ? '★' : '☆' }}
            </button>
        </div>

        <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500">
            <span
                v-if="offer?.ville?.nom || offer?.ville?.name"
                class="rounded-full bg-slate-100 px-2.5 py-1"
            >
                📍 {{ offer?.ville?.nom || offer?.ville?.name }}
            </span>

            <span
                v-if="offer?.type"
                class="rounded-full bg-slate-100 px-2.5 py-1"
            >
                {{ offer.type }}
            </span>

            <span
                v-if="offer?.duree"
                class="rounded-full bg-slate-100 px-2.5 py-1"
            >
                {{ offer.duree }}
            </span>
        </div>

        <div class="mt-4 flex items-center justify-between gap-3">
            <span
                v-if="offer?.competences_count"
                class="text-xs text-slate-400"
            >
                {{ offer.competences_count }} compétences
            </span>

            <span v-else class="text-xs text-slate-400">
                Nouvelle opportunité
            </span>

            <button
                type="button"
                @click="apply"
                class="rounded-lg bg-[#16425B] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#2F6690]"
            >
                Postuler
            </button>
        </div>
    </article>
</template>