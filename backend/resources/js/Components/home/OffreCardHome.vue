<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

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
        active: 'Active',
        Active: 'Active',
        ouverte: 'Open',
        Ouverte: 'Open',
        open: 'Open',
        Open: 'Open',
        fermée: 'Closed',
        Fermée: 'Closed',
        closed: 'Closed',
        Closed: 'Closed',
        'en attente': 'Pending',
        'En attente': 'Pending',
        pending: 'Pending',
        Pending: 'Pending',
    }

    return statuses[status] ?? status
}

const isActive = (status) => [
    'active', 'Active', 'ouverte', 'Ouverte', 'open', 'Open',
].includes(status)

const isClosed = (status) => [
    'fermée', 'Fermée', 'closed', 'Closed',
].includes(status)

const isPending = (status) => [
    'en attente', 'En attente', 'pending', 'Pending',
].includes(status)
</script>

<template>
    <article
        class="relative rounded-2xl border border-slate-200 bg-white p-5
               shadow-sm transition duration-200
               hover:-translate-y-0.5 hover:shadow-md"
    >
        <!-- Header -->
        <div class="flex items-start gap-3">
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center
                       rounded-full bg-[#3A7CA5] text-sm font-bold text-white"
            >
                {{
                    (
                        offre.entreprise?.user?.nom_complet
                        ?? offre.entreprise?.user?.name
                        ?? offre.titre
                        ?? 'I'
                    ).charAt(0).toUpperCase()
                }}
            </div>

            <div class="min-w-0 flex-1">
                <h3 class="truncate text-sm font-bold text-[#16425B]">
                    {{ offre.titre }}
                </h3>

                <p class="mt-0.5 truncate text-xs text-slate-500">
                    {{
                        offre.entreprise?.user?.nom_complet
                        ?? offre.entreprise?.user?.name
                        ?? 'Company'
                    }}
                </p>
            </div>
        </div>

        <!-- Description -->
        <p
            v-if="offre.description"
            class="mt-4 line-clamp-2 text-xs leading-5 text-slate-500"
        >
            {{ offre.description }}
        </p>

        <!-- Information -->
        <div
            class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-2
                   text-xs text-[#64748B]"
        >
            <!-- Location -->
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
                    <circle cx="12" cy="9" r="2" />
                </svg>

                {{ offre.entreprise.user.ville.nom }}
            </div>

            <!-- Duration -->
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
                    <circle cx="12" cy="12" r="9" />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 7v5l3 2"
                    />
                </svg>

                {{ offre.duree }}
            </div>
        </div>

        <!-- Deadline / Status -->
        <div
            v-if="offre.date_limite || offre.statut"
            class="mt-4 flex items-center justify-between gap-3
                   border-t border-slate-100 pt-3"
        >
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

                {{ formatDate(offre.date_limite) }}
            </div>

            <span
                v-if="offre.statut"
                class="shrink-0 rounded-full px-3 py-1 text-[11px] font-semibold"
                :class="{
                    'bg-emerald-50 text-emerald-600': isActive(offre.statut),
                    'bg-slate-100 text-slate-500': isClosed(offre.statut),
                    'bg-amber-50 text-amber-600': isPending(offre.statut),
                }"
            >
                {{ formatStatus(offre.statut) }}
            </span>
        </div>

        <!-- Apply -->
        <div class="mt-4">
            <Link
                :href="route('register')"
                class="flex w-full items-center justify-center rounded-lg
                       bg-[#16425B] px-4 py-2.5 text-xs font-semibold
                       text-white transition hover:bg-[#3A7CA5]"
            >
                Apply Now
            </Link>
        </div>
    </article>
</template>