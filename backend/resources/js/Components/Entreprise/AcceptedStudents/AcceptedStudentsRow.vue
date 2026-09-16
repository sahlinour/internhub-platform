<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    candidature: {
        type: Object,
        required: true,
    },
})

const getName = (candidature) => {
    return (
        candidature?.stagiaire?.user?.nom_complet ??
        candidature?.stagiaire?.user?.name ??
        'Unknown student'
    )
}

const getEmail = (candidature) => {
    return candidature?.stagiaire?.user?.email ?? '—'
}

const getInitials = (candidature) => {
    return getName(candidature)
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((word) => word.charAt(0).toUpperCase())
        .join('')
}

const getInternship = (candidature) => {
    return candidature?.offre_de_stage?.titre ?? '—'
}

const formatDate = (date) => {
    if (!date) {
        return null
    }

    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    }).format(new Date(date))
}

const getStartDate = (candidature) => {
    if (!candidature?.stage?.date_debut) {
        return null
    }

    return formatDate(candidature.stage.date_debut)
}

const getOnboardingStatus = (candidature) => {
    if (!candidature.stage) {
        return {
            label: 'Pending setup',
            class: 'bg-amber-50 text-amber-600',
        }
    }

    if (!candidature.stage.date_debut) {
        return {
            label: 'Awaiting start',
            class: 'bg-sky-50 text-sky-600',
        }
    }

    const startDate = new Date(
        candidature.stage.date_debut
    )

    const today = new Date()

    startDate.setHours(0, 0, 0, 0)
    today.setHours(0, 0, 0, 0)

    if (startDate > today) {
        return {
            label: 'Awaiting start',
            class: 'bg-sky-50 text-sky-600',
        }
    }

    return {
        label: 'Started',
        class: 'bg-emerald-50 text-emerald-600',
    }
}
</script>

<template>
    <tr
        class="hidden
               border-b border-slate-100
               last:border-0
               transition
               hover:bg-[#F4F7F9]
               md:table-row"
    >
        <td class="px-5 py-4 align-top">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           rounded-full
                           bg-[#E8F1F5]
                           text-[10px] font-bold
                           text-[#16425B]"
                >
                    {{ getInitials(candidature) }}
                </div>
                <div class="min-w-0">
                    <p
                        class="truncate text-xs
                               font-bold text-[#16425B]"
                    >
                        {{ getName(candidature) }}
                    </p>
                    <p
                        class="mt-0.5 truncate
                               text-[10px]
                               text-slate-400"
                    >
                        {{ getEmail(candidature) }}
                    </p>
                </div>
            </div>
        </td>
        <td class="px-5 py-4 align-top">
            <div class="flex items-center gap-2">
                <div
                    class="flex h-8 w-8 shrink-0
                           items-center justify-center
                           rounded-lg
                           bg-[#E8F1F5]
                           text-[#3A7CA5]"
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
                            stroke-width="1.8"
                            d="M20 7h-4V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2ZM10 5h4v2h-4V5Z"
                        />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p
                        class="truncate text-xs
                               font-semibold
                               text-slate-700"
                    >
                        {{ getInternship(candidature) }}
                    </p>
                    <p
                        class="mt-0.5 text-[10px]
                               text-slate-400"
                    >
                        Internship
                    </p>
                </div>
            </div>
        </td>
        <td class="px-5 py-4 align-top">
            <div
                v-if="getStartDate(candidature)"
                class="flex items-center gap-2
                       text-xs font-medium
                       text-slate-700"
            >
                <svg
                    class="h-4 w-4 shrink-0
                           text-slate-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"
                    />
                </svg>
                <span>
                    {{ getStartDate(candidature) }}
                </span>
            </div>
            <span
                v-else
                class="text-[10px] text-slate-400"
            >
                Not set
            </span>
        </td>
        <td class="px-5 py-4 align-top">
            <span
                class="inline-flex items-center
                       gap-1.5 whitespace-nowrap
                       rounded-full
                       px-2.5 py-1
                       text-[10px]
                       font-semibold"
                :class="
                    getOnboardingStatus(candidature).class
                "
            >
                <span
                    class="h-1.5 w-1.5
                           rounded-full
                           bg-current"
                ></span>

                {{ getOnboardingStatus(candidature).label }}
            </span>
        </td>
        <td
            class="px-5 py-4
                   text-right align-top"
        >
            <Link
                :href="
                    route(
                        'entreprise.acceptedStudents.show',
                        candidature.id,
                        false
                    )
                "
                class="inline-flex items-center gap-1.5
                       rounded-lg
                       border border-slate-200
                       bg-white
                       px-3 py-2
                       text-xs font-semibold
                       text-slate-600
                       transition
                       hover:border-[#63A9C6]
                       hover:bg-[#f0f8fb]
                       hover:text-[#174E6D]"
            >
                View
                <svg
                    class="h-3.5 w-3.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m9 18 6-6-6-6"
                    />
                </svg>
            </Link>
        </td>
    </tr>

    <article
        class="p-4 md:hidden"
    >
        <div
            class="flex items-start
                   justify-between gap-3"
        >
            <div class="flex min-w-0 items-center gap-3">
                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           rounded-full
                           bg-[#E8F1F5]
                           text-[10px] font-bold
                           text-[#16425B]"
                >
                    {{ getInitials(candidature) }}
                </div>
                <div class="min-w-0">
                    <p
                        class="truncate text-xs
                               font-bold
                               text-[#16425B]"
                    >
                        {{ getName(candidature) }}
                    </p>
                    <p
                        class="mt-0.5 truncate
                               text-[10px]
                               text-slate-400"
                    >
                        {{ getEmail(candidature) }}
                    </p>
                </div>
            </div>
            <span
                class="shrink-0 rounded-full
                       px-2.5 py-1
                       text-[10px] font-semibold"
                :class="
                    getOnboardingStatus(candidature).class
                "
            >
                {{ getOnboardingStatus(candidature).label }}
            </span>
        </div>
        <div
            class="mt-4 grid grid-cols-2 gap-2
                   rounded-xl
                   bg-[#F4F7F9]
                   p-3"
        >
            <div class="min-w-0">
                <p
                    class="text-[9px] uppercase
                           tracking-wide
                           text-slate-400"
                >
                    Internship
                </p>
                <p
                    class="mt-1 truncate
                           text-[10px]
                           font-semibold
                           text-slate-700"
                >
                    {{ getInternship(candidature) }}
                </p>
            </div>
            <div>
                <p
                    class="text-[9px] uppercase
                           tracking-wide
                           text-slate-400"
                >
                    Start date
                </p>
                <p
                    class="mt-1 text-[10px]
                           font-semibold
                           text-slate-700"
                >
                    {{ getStartDate(candidature) ?? 'Not set' }}
                </p>
            </div>
        </div>

        <div
            class="mt-3 flex justify-end gap-2"
        >
            <Link
                :href="
                    route(
                        'entreprise.acceptedStudents.show',
                        candidature.id,
                        false
                    )
                "
                class="inline-flex items-center gap-1.5
                       rounded-lg
                       border border-slate-200
                       bg-white
                       px-3 py-2
                       text-xs font-semibold
                       text-slate-600
                       transition
                       hover:border-[#63A9C6]
                       hover:bg-[#f0f8fb]
                       hover:text-[#174E6D]"
            >
                View
                <svg
                    class="h-3.5 w-3.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m9 18 6-6-6-6"
                    />
                </svg>
            </Link>
        </div>
    </article>
</template>