<script setup>
defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(['edit', 'delete'])

const formatDate = (date) => {
    if (!date) return '-'

    const parsedDate = new Date(date)
    if (Number.isNaN(parsedDate.getTime())) return date

    return parsedDate.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    })
}

const locationName = (offre) =>
    offre?.entreprise?.user?.ville?.nom ||
    offre?.entreprise?.ville?.nom ||
    offre?.entreprise?.ville ||
    '-'

const statusLabel = (status) =>
    ({
        ouverte: 'Open',
        en_attente: 'Pending',
        fermee: 'Closed',
    })[status] || status || 'Unknown'

const statusClass = (status) =>
    ({
        ouverte: 'bg-emerald-50 text-emerald-600',
        en_attente: 'bg-amber-50 text-amber-600',
        fermee: 'bg-red-50 text-red-500',
    })[status] || 'bg-slate-100 text-slate-500'
</script>

<template>
    <!-- DESKTOP -->
    <tr
        class="hidden border-b border-slate-100 last:border-0
               transition hover:bg-[#F4F7F9] md:table-row"
    >
        <td class="px-5 py-4 align-top">
            <p class="text-xs font-bold text-[#16425B]">
                {{ offre.titre }}
            </p>

            <p class="mt-1 flex items-center gap-1 truncate text-[10px] text-slate-400">
                <svg
                    class="h-3 w-3 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M12 21s7-6.1 7-12a7 7 0 10-14 0c0 5.9 7 12 7 12z"
                    />
                    <circle cx="12" cy="9" r="2.2" />
                </svg>

                {{ locationName(offre) }}
            </p>
        </td>

        <td class="px-5 py-4 align-top">
            <p class="text-[10px] text-slate-500">
                <span class="font-semibold text-slate-700">Duration:</span>
                {{ offre.duree || '-' }}
            </p>

            <p class="mt-1 text-[10px] text-slate-400">
                Published internship
            </p>
        </td>

        <td class="whitespace-nowrap px-5 py-4 align-top">
            <p class="text-xs font-medium text-slate-700">
                {{ formatDate(offre.date_limite) }}
            </p>
        </td>

        <td class="px-5 py-4 align-top">
            <span
                class="inline-flex items-center gap-1.5 rounded-full
                       px-2.5 py-1 text-[10px] font-semibold"
                :class="statusClass(offre.statut)"
            >
                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                {{ statusLabel(offre.statut) }}
            </span>
        </td>

        <!-- ACTIONS -->
        <td class="px-5 py-4 text-right align-top">
            <div class="flex justify-end gap-2">
                <!-- EDIT -->
                <button
                    type="button"
                    title="Edit internship"
                    class="inline-flex items-center gap-1.5 rounded-lg border
                           border-slate-200 bg-white px-3 py-2
                           text-xs font-semibold text-slate-600
                           transition hover:border-[#63A9C6]
                           hover:bg-[#f0f8fb] hover:text-[#174E6D]"
                    @click="emit('edit', offre)"
                >
                    <svg
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M16.862 3.487a2.25 2.25 0 013.182 3.182L8.25 18.464 4 19.5l1.036-4.25L16.862 3.487z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M15.5 5l3.5 3.5"
                        />
                    </svg>

                    Edit
                </button>

                <!-- DELETE -->
                <button
                    type="button"
                    title="Delete internship"
                    class="inline-flex items-center gap-1.5 rounded-lg border
                           border-red-100 bg-red-50 px-3 py-2
                           text-xs font-semibold text-red-500
                           transition hover:border-red-200
                           hover:bg-red-100"
                    @click="emit('delete', offre.id)"
                >
                    <svg
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M6 7h12M9 7V4h6v3m-8 0l.7 13h8.6L17 7M10 11v5m4-5v5"
                        />
                    </svg>

                    Delete
                </button>
            </div>
        </td>
    </tr>

    <!-- MOBILE -->
    <article class="p-4 md:hidden">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <h3 class="truncate text-xs font-bold text-[#16425B]">
                    {{ offre.titre }}
                </h3>

                <p class="mt-1 flex items-center gap-1 truncate text-[10px] text-slate-400">
                    <svg
                        class="h-3 w-3 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 21s7-6.1 7-12a7 7 0 10-14 0c0 5.9 7 12 7 12z"
                        />
                        <circle cx="12" cy="9" r="2.2" />
                    </svg>

                    {{ locationName(offre) }}
                </p>
            </div>

            <span
                class="inline-flex shrink-0 items-center gap-1.5 rounded-full
                       px-2.5 py-1 text-[10px] font-semibold"
                :class="statusClass(offre.statut)"
            >
                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                {{ statusLabel(offre.statut) }}
            </span>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-2 rounded-xl bg-[#F4F7F9] p-3">
            <div>
                <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                    Duration
                </p>
                <p class="mt-1 text-[11px] font-medium text-slate-700">
                    {{ offre.duree || '-' }}
                </p>
            </div>

            <div>
                <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                    Location
                </p>
                <p class="mt-1 truncate text-[11px] font-medium text-slate-700">
                    {{ locationName(offre) }}
                </p>
            </div>

            <div>
                <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                    Deadline
                </p>
                <p class="mt-1 text-[11px] font-medium text-slate-700">
                    {{ formatDate(offre.date_limite) }}
                </p>
            </div>

            <div>
                <p class="text-[9px] font-semibold uppercase tracking-wide text-slate-400">
                    Created
                </p>
                <p class="mt-1 text-[11px] font-medium text-slate-700">
                    {{ formatDate(offre.created_at) }}
                </p>
            </div>
        </div>

        <!-- MOBILE ACTIONS -->
        <div class="mt-3 flex justify-end gap-2">
            <!-- EDIT -->
            <button
                type="button"
                title="Edit internship"
                class="inline-flex items-center gap-1.5 rounded-lg
                       border border-slate-200 bg-white px-3 py-2
                       text-xs font-semibold text-slate-600
                       transition hover:border-[#63A9C6]
                       hover:bg-[#f0f8fb] hover:text-[#174E6D]"
                @click="emit('edit', offre)"
            >
                <svg
                    class="h-3.5 w-3.5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M16.862 3.487a2.25 2.25 0 013.182 3.182L8.25 18.464 4 19.5l1.036-4.25L16.862 3.487z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M15.5 5l3.5 3.5"
                    />
                </svg>
                Edit
            </button>

            <!-- DELETE -->
            <button
                type="button"
                title="Delete internship"
                class="inline-flex items-center gap-1.5 rounded-lg
                       border border-red-100 bg-red-50 px-3 py-2
                       text-xs font-semibold text-red-500
                       transition hover:border-red-200
                       hover:bg-red-100"
                @click="emit('delete', offre.id)"
            >
                <svg
                    class="h-3.5 w-3.5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M6 7h12M9 7V4h6v3m-8 0l.7 13h8.6L17 7M10 11v5m4-5v5"
                    />
                </svg>
                Delete
            </button>
        </div>
    </article>
</template>