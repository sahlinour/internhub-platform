<script setup>
import { router, Link } from '@inertiajs/vue3'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const removeFavorite = () => {
    router.delete(
        route('stagiaire.favoris.destroy', props.offre.id),
        {
            preserveScroll: true,
        }
    )
}

const companyName = () => {
    return (
        props.offre?.entreprise?.user?.nom_complet ||
        props.offre?.entreprise?.user?.name ||
        'Company'
    )
}

const cityName = () => {
    return props.offre?.entreprise?.user?.ville?.nom || ''
}

const formatDeadline = () => {
    if (!props.offre?.date_limite) {
        return 'No deadline'
    }

    return new Date(props.offre.date_limite).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    })
}
</script>

<template>
    <article
        class="group relative rounded-2xl border border-slate-200
               bg-white p-5 shadow-sm transition duration-200
               hover:-translate-y-0.5 hover:shadow-md"
    >
        <!-- Remove -->
        <button
            type="button"
            title="Remove from saved opportunities"
            class="absolute right-4 top-4 flex h-8 w-8 items-center
                   justify-center rounded-lg text-slate-400
                   transition hover:bg-red-50 hover:text-[#D80536]"
            @click="removeFavorite"
        >
            <svg
                width="17"
                height="17"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M18 6L6 18" />
                <path d="M6 6l12 12" />
            </svg>
        </button>

        <!-- Main content -->
        <div class="pr-10">
            <div class="mb-3 flex items-start gap-3">
                <div
                    class="flex h-11 w-11 shrink-0 items-center
                           justify-center rounded-xl bg-[#E8F3F8]
                           text-[#2F6690]"
                >
                    <svg
                        width="21"
                        height="21"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="7" width="18" height="13" rx="2" />
                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        <path d="M3 12h18" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <h2
                        class="line-clamp-2 text-[14px] font-bold
                               text-[#16425B]"
                    >
                        {{ offre.titre }}
                    </h2>

                    <p class="mt-1 text-[11px] font-medium text-[#2F6690]">
                        {{ companyName() }}
                    </p>
                </div>
            </div>

            <!-- Information -->
            <div class="mt-4 flex flex-wrap gap-x-5 gap-y-2 text-[10px] text-slate-500">

                <!-- Duration -->
                <div
                    v-if="offre.duree"
                    class="flex items-center gap-1.5"
                >
                    <svg
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 2" />
                    </svg>

                    <span>{{ offre.duree }}</span>
                </div>

                <!-- City -->
                <div
                    v-if="cityName()"
                    class="flex items-center gap-1.5"
                >
                    <svg
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" />
                        <circle cx="12" cy="10" r="2.5" />
                    </svg>

                    <span>{{ cityName() }}</span>
                </div>

                <!-- Deadline -->
                <div class="flex items-center gap-1.5">
                    <svg
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M16 2v4" />
                        <path d="M8 2v4" />
                        <path d="M3 10h18" />
                    </svg>

                    <span>
                        Deadline: {{ formatDeadline() }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            <p
                v-if="offre.description"
                class="mt-4 line-clamp-2 text-[11px] leading-5 text-slate-500"
            >
                {{ offre.description }}
            </p>

            <!-- Actions -->
            <div
                class="mt-5 flex items-center justify-between
                       border-t border-slate-100 pt-4"
            >
                <span
                    class="rounded-full px-2.5 py-1 text-[9px] font-semibold"
                    :class="
                        offre.statut === 'Ouverte'
                            ? 'bg-emerald-50 text-emerald-600'
                            : offre.statut === 'En attente'
                              ? 'bg-amber-50 text-[#E8A33D]'
                              : 'bg-slate-100 text-slate-500'
                    "
                >
                    {{ offre.statut }}
                </span>

                <Link
                    :href="route('offres.show', offre.id)"
                    class="rounded-lg bg-[#2F6690] px-4 py-2
                           text-[10px] font-semibold text-white
                           transition hover:bg-[#16425B]"
                >
                    View opportunity
                </Link>
            </div>
        </div>
    </article>
</template>