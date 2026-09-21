<script setup>
import { Link, router } from '@inertiajs/vue3'

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
const getCompanyName = (offre) => {
    return (
        offre?.entreprise?.user?.nom_complet ||
        'Entreprise'
    )
}
const getLocation = (offre) => {
    return (
        offre?.entreprise?.user?.ville?.nom ||
        null
    )
}
const formatDate = (date) => {
    if (!date) {
        return ''
    }

    return new Intl.DateTimeFormat('en-US', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}
const toggleSave = () => {
    router.post(
        route('stagiaire.favoris.toggle', props.offre.id),
        {},
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <div>
        <!-- Back -->
        <Link
            :href="route('offres.index')"
            class="mb-5 inline-flex items-center gap-2 text-sm font-medium
                   text-slate-500 transition hover:text-[#2F6690]"
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

            Back to offers
        </Link>

        <section
            class="rounded-2xl border border-slate-200 bg-white p-6
                   shadow-sm sm:p-8"
        >
            <!-- TOP -->
            <div
                class="flex flex-col gap-5
                       lg:flex-row lg:items-start lg:justify-between"
            >
                <!-- LEFT : TITLE -->
                <div class="flex min-w-0 gap-4">
                    <!-- Company avatar -->
                    <div
                        class="flex h-14 w-14 shrink-0 items-center
                               justify-center rounded-xl
                               bg-[#E8F1F5]
                               text-xl font-bold text-[#2F6690]"
                    >
                        {{
                            getCompanyName(offre)
                                .charAt(0)
                                .toUpperCase()
                        }}
                    </div>

                    <div class="min-w-0">
                        <h1
                            class="text-2xl font-bold text-[#16425B]
                                   sm:text-3xl"
                        >
                            {{ offre.titre }}
                        </h1>

                        <p class="mt-1 font-medium text-slate-600">
                            {{ getCompanyName(offre) }}
                        </p>
                    </div>
                </div>

                <!-- RIGHT : ACTIONS -->
                <div
                    class="flex shrink-0 items-center gap-2
                           lg:pt-1"
                >
                    <!-- SAVE OPPORTUNITY -->
                    <button
                        type="button"
                        @click="toggleSave"
                        class="inline-flex items-center justify-center
                               gap-2 rounded-xl border px-4 py-2.5
                               text-sm font-semibold transition"
                        :class="
                            isSaved
                                ? 'border-[#81C3D7] bg-[#E8F1F5] text-[#2F6690]'
                                : 'border-slate-200 bg-white text-slate-600 hover:border-[#81C3D7] hover:bg-[#E8F1F5] hover:text-[#2F6690]'
                        "
                    >
                        <svg
                            class="h-4 w-4"
                            :fill="isSaved ? 'currentColor' : 'none'"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-4-7 4V5z"
                            />
                        </svg>

                        {{ isSaved ? 'Saved' : 'Save Opportunity' }}
                    </button>

                    <!-- APPLY NOW -->
                    <Link
                        v-if="offre.statut === 'ouverte'"
                        :href="
                            route(
                                'stagiaire.candidatures.create',
                                offre.id
                            )
                        "
                        class="inline-flex items-center justify-center
                               gap-2 rounded-xl bg-[#16425B]
                               px-4 py-2.5
                               text-sm font-semibold text-white
                               transition hover:bg-[#3A7CA5]"
                    >
                        Apply Now

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
                                d="M5 12h14m-6-6 6 6"
                            />
                        </svg>
                    </Link>

                    <!-- CLOSED / PENDING -->
                    <span
                        v-else
                        class="inline-flex items-center justify-center
                               rounded-xl bg-slate-100
                               px-4 py-2.5
                               text-sm font-semibold text-slate-400"
                    >
                        {{
                            offre.statut === 'fermee'
                                ? 'Applications Closed'
                                : 'Applications Unavailable'
                        }}
                    </span>
                </div>
            </div>

            <!-- INFORMATION GRID -->
            <div
                class="mt-7 grid grid-cols-1 gap-y-5
                       border-t border-slate-100 pt-6
                       sm:grid-cols-2 sm:gap-x-10"
            >
                <!-- LOCATION -->
                <div
                    v-if="getLocation(offre)"
                    class="flex items-center gap-3"
                >
                    <div
                        class="flex h-10 w-10 shrink-0 items-center
                               justify-center rounded-lg
                               text-[#2F6690]"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">
                            Location
                        </p>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ getLocation(offre) }}
                        </p>
                    </div>
                </div>

                <!-- DURATION -->
                <div
                    v-if="offre.duree"
                    class="flex items-center gap-3"
                >
                    <div
                        class="flex h-10 w-10 shrink-0 items-center
                               justify-center rounded-lg
                               text-[#2F6690]"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 7v5l3 2"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">
                            Duration
                        </p>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ offre.duree }}
                        </p>
                    </div>
                </div>

                <!-- DEADLINE -->
                <div
                    v-if="offre.date_limite"
                    class="flex items-center gap-3"
                >
                    <div
                        class="flex h-10 w-10 shrink-0 items-center
                               justify-center rounded-lg
                                text-[#2F6690]"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <rect
                                x="3"
                                y="4"
                                width="18"
                                height="17"
                                rx="2"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M16 2v4M8 2v4M3 10h18"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">
                            Application Deadline
                        </p>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ formatDate(offre.date_limite) }}
                        </p>
                    </div>
                </div>

                <!-- STATUS -->
                <div
                    v-if="offre.statut"
                    class="flex items-center gap-3"
                >
                    <div
                        class="flex h-10 w-10 shrink-0 items-center
                               justify-center rounded-lg
                             text-[#2F6690]"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 12l2.5 2.5L16 9"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400">
                            Status
                        </p>

                        <span
                            class="inline-flex rounded-full px-2.5 py-1
                                   text-xs font-semibold"
                            :class="
                                offre.statut === 'ouverte'
                                    ? 'bg-emerald-50 text-emerald-700'
                                    : offre.statut === 'fermee'
                                        ? 'bg-slate-100 text-slate-500'
                                        : 'bg-amber-50 text-amber-700'
                            "
                        >
                            {{
                                offre.statut === 'ouverte'
                                    ? 'Open'
                                    : offre.statut === 'fermee'
                                        ? 'Closed'
                                        : 'Pending'
                            }}
                        </span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
