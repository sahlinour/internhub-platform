<script setup>
import { router, Link } from '@inertiajs/vue3'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },

    isSaved: {
        type: Boolean,
        default: false,
    },
})

const saveOffer = () => {
    if (!props.offre?.id) return

    router.post(
        route('stagiaire.favoris.toggle', props.offre.id),
        {},
        {
            preserveScroll: true,
            preserveState: true,
        }
    )
}

const formatDate = (date) => {
    if (!date) return ''

    return new Intl.DateTimeFormat('en-US', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}

const formatStatus = (status) => {
    const statuses = {
        ouverte: 'Open',
        en_attente: 'Pending',
        fermee: 'Closed',
    }

    return statuses[status] ?? status
}
</script>

<template>
    <article
        class="relative rounded-2xl border border-slate-200 bg-white p-5
               shadow-sm transition duration-200
               hover:-translate-y-0.5 hover:shadow-md"
    >
        <!-- SAVED BUTTON -->
        <button
            type="button"
            :title="
                isSaved
                    ? 'Remove from saved opportunities'
                    : 'Save opportunity'
            "
            class="absolute right-4 top-4 flex h-9 w-9 items-center
                   justify-center rounded-lg transition"
            :class="
                isSaved
                    ? 'bg-[#E8F1F5] text-[#2F6690]'
                    : 'text-slate-400 hover:bg-[#E8F1F5] hover:text-[#2F6690]'
            "
            @click="saveOffer"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5"
                :class="isSaved ? 'fill-[#2F6690]' : ''"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 3.75A2.25 2.25 0 0 1 8.25 1.5h7.5A2.25 2.25 0 0 1 18 3.75V21l-6-3.75L6 21V3.75Z"
                />
            </svg>
        </button>

        <!-- HEADER -->
        <div class="flex items-start gap-3 pr-10">

            <!-- COMPANY AVATAR -->
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center
                       rounded-full bg-[#3A7CA5]
                       text-sm font-bold text-white"
            >
                {{
                    (
                        offre.entreprise?.user?.nom_complet
                        ?? offre.titre
                        ?? 'E'
                    )
                        .charAt(0)
                        .toUpperCase()
                }}
            </div>

            <!-- TITLE + COMPANY -->
            <div class="min-w-0 flex-1">
                <h3
                    class="truncate text-sm font-bold text-[#16425B]"
                >
                    {{ offre.titre }}
                </h3>

                <p class="mt-0.5 truncate text-xs text-slate-500">
                    {{
                        offre.entreprise?.user?.nom_complet
                        ?? 'Company'
                    }}
                </p>
            </div>
        </div>

        <!-- DESCRIPTION -->
        <p
            v-if="offre.description"
            class="mt-4 line-clamp-2 text-xs leading-5 text-slate-500"
        >
            {{ offre.description }}
        </p>

        <!-- INFO -->
        <div
            class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-2
                   text-xs text-[#64748B]"
        >
            <!-- LOCATION -->
            <div
                v-if="offre.entreprise?.user?.ville?.nom"
                class="flex items-center gap-1.5"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-3.5 w-3.5 text-[#3A7CA5]"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"
                    />

                    <circle
                        cx="12"
                        cy="9"
                        r="2"
                    />
                </svg>

                <span>
                    {{ offre.entreprise.user.ville.nom }}
                </span>
            </div>

            <!-- DURATION -->
            <div
                v-if="offre.duree"
                class="flex items-center gap-1.5"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-3.5 w-3.5 text-[#3A7CA5]"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 7v5l3 2"
                    />
                </svg>

                <span>
                    {{ offre.duree }}
                </span>
            </div>
        </div>

        <!-- DEADLINE + STATUS -->
        <div
            v-if="offre.date_limite || offre.statut"
            class="mt-4 flex items-center justify-between gap-3
                   border-t border-slate-100 pt-3"
        >
            <!-- DEADLINE -->
            <div
                v-if="offre.date_limite"
                class="flex items-center gap-1.5 text-xs text-[#64748B]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-3.5 w-3.5 text-[#3A7CA5]"
                >
                    <rect
                        x="3"
                        y="4"
                        width="18"
                        height="17"
                        rx="2"
                    />

                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h18" />
                </svg>

                <span>
                    {{ formatDate(offre.date_limite) }}
                </span>
            </div>

            <!-- STATUS -->
            <span
                v-if="offre.statut"
                class="shrink-0 rounded-full px-3 py-1
                       text-[11px] font-semibold"
               :class="{
                    'bg-emerald-50 text-emerald-600':
                        offre.statut === 'ouverte',

                    'bg-slate-100 text-slate-500':
                        offre.statut === 'fermee',

                    'bg-amber-50 text-amber-600':
                        offre.statut === 'en_attente',
                }"
            >
                {{ formatStatus(offre.statut) }}
            </span>
        </div>

        <!-- ACTIONS -->
        <div class="mt-4 grid grid-cols-2 gap-2">

            <!-- VIEW DETAILS -->
            <Link
                :href="route('offres.show', offre.id)"
                class="flex items-center justify-center
                       rounded-lg border border-slate-200
                       bg-white px-4 py-2.5
                       text-xs font-semibold text-[#16425B]
                       transition
                       hover:border-[#81C3D7]
                       hover:bg-[#E8F1F5]"
            >
                View Details
            </Link>

            <!-- APPLY -->
            <Link
                :href="
                    route(
                        'stagiaire.candidatures.create',
                        offre.id
                    )
                "
                class="flex items-center justify-center
                       rounded-lg bg-[#16425B]
                       px-4 py-2.5
                       text-xs font-semibold text-white
                       transition hover:bg-[#3A7CA5]"
            >
                Apply Now
            </Link>
        </div>
    </article>
</template>