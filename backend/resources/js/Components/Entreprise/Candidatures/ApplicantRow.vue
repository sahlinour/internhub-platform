<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    candidature: {
        type: Object,
        required: true,
    },
})

defineEmits(['update-status'])

const applicantName = (c) =>
    c?.stagiaire?.user?.nom_complet ||
    c?.stagiaire?.user?.name ||
    'Unknown applicant'

const applicantEmail = (c) =>
    c?.stagiaire?.user?.email || '—'

const initials = (c) =>
    applicantName(c)
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((word) => word[0].toUpperCase())
        .join('')

const internshipTitle = (c) =>
    c?.offre_de_stage?.titre || '—'

const formatDate = (date) => {
    if (!date) return '-'

    const parsedDate = new Date(date)

    if (Number.isNaN(parsedDate.getTime())) {
        return date
    }

    return parsedDate.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    })
}

const statusLabel = (status) => {
    const labels = {
        en_attente: 'Pending',
        acceptee: 'Accepted',
        refusee: 'Rejected',
    }

    return labels[status] || status || 'Unknown'
}

const statusClass = (status) => {
    switch (status) {
        case 'en_attente':
            return 'bg-amber-50 text-amber-600'

        case 'acceptee':
            return 'bg-emerald-50 text-emerald-600'

        case 'refusee':
            return 'bg-red-50 text-red-500'

        default:
            return 'bg-slate-100 text-slate-500'
    }
}
</script>

<template>

    <!-- DESKTOP -->
    <tr
        class="hidden border-b border-slate-100
               last:border-0 transition
               hover:bg-[#F4F7F9] md:table-row"
    >

        <!-- APPLICANT -->
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
                    {{ initials(candidature) }}
                </div>

                <div class="min-w-0">
                    <p
                        class="truncate text-xs font-bold
                               text-[#16425B]"
                    >
                        {{ applicantName(candidature) }}
                    </p>

                    <p
                        class="mt-1 truncate text-[10px]
                               text-slate-400"
                    >
                        {{ applicantEmail(candidature) }}
                    </p>
                </div>

            </div>
        </td>

        <!-- INTERNSHIP -->
        <td class="px-5 py-4 align-top">
            <div class="min-w-[180px] max-w-[300px]">
                <p
                    class="truncate text-xs font-semibold
                           text-slate-700"
                >
                    {{ internshipTitle(candidature) }}
                </p>

                <p
                    class="mt-1 text-[10px]
                           text-slate-400"
                >
                    Internship application
                </p>
            </div>
        </td>

        <!-- APPLIED -->
        <td
            class="whitespace-nowrap
                   px-5 py-4 align-top"
        >
            <p
                class="text-xs font-medium
                       text-slate-700"
            >
                {{ formatDate(candidature.date_postulation) }}
            </p>
        </td>

        <!-- STATUS -->
        <td class="px-5 py-4 align-top">
            <span
                class="inline-flex items-center
                       gap-1.5 rounded-full
                       px-2.5 py-1 text-[10px]
                       font-semibold"
                :class="statusClass(candidature.statut)"
            >
                <span
                    class="h-1.5 w-1.5
                           rounded-full bg-current"
                ></span>

                {{ statusLabel(candidature.statut) }}
            </span>
        </td>

        <!-- ACTIONS -->
        <td
            class="px-5 py-4 align-top
                   text-right"
        >
            <div
                class="flex items-center
                       justify-end gap-2"
            >

                <!-- VIEW -->
                <Link
                    :href="
                        route(
                            'entreprise.candidatures.show',
                            candidature.id,
                            false
                        )
                    "
                    class="inline-flex items-center gap-1.5
                           rounded-lg border
                           border-slate-200 bg-white
                           px-3 py-2 text-xs
                           font-semibold
                           text-slate-600
                           transition
                           hover:border-[#63A9C6]
                           hover:bg-[#f0f8fb]
                           hover:text-[#174E6D]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                        />
                        <circle
                            cx="12"
                            cy="12"
                            r="2.5"
                        />
                    </svg>

                    View
                </Link>

                <!-- ACCEPT -->
                <button
                    v-if="candidature.statut !== 'acceptee'"
                    type="button"
                    @click="
                        $emit(
                            'update-status',
                            candidature,
                            'acceptee'
                        )
                    "
                    class="inline-flex items-center
                           gap-1.5 rounded-lg border
                           border-emerald-100
                           bg-emerald-50
                           px-3 py-2 text-xs
                           font-semibold
                           text-emerald-600
                           transition
                           hover:border-emerald-200
                           hover:bg-emerald-100"
                >
                    Accept
                </button>

                <!-- REJECT -->
                <button
                    v-if="candidature.statut !== 'refusee'"
                    type="button"
                    @click="
                        $emit(
                            'update-status',
                            candidature,
                            'refusee'
                        )
                    "
                    class="inline-flex items-center
                           gap-1.5 rounded-lg border
                           border-red-100
                           bg-red-50
                           px-3 py-2 text-xs
                           font-semibold
                           text-red-500
                           transition
                           hover:border-red-200
                           hover:bg-red-100"
                >
                    Reject
                </button>

            </div>
        </td>

    </tr>

    <!-- MOBILE -->
    <article class="p-4 md:hidden">

        <div
            class="flex items-start
                   justify-between gap-3"
        >
            <div
                class="flex min-w-0
                       items-center gap-3"
            >
                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           rounded-full
                           bg-[#E8F1F5]
                           text-[10px] font-bold
                           text-[#16425B]"
                >
                    {{ initials(candidature) }}
                </div>

                <div class="min-w-0">
                    <h3
                        class="truncate text-xs font-bold
                               text-[#16425B]"
                    >
                        {{ applicantName(candidature) }}
                    </h3>

                    <p
                        class="mt-1 truncate text-[10px]
                               text-slate-400"
                    >
                        {{ applicantEmail(candidature) }}
                    </p>
                </div>
            </div>

            <span
                class="inline-flex shrink-0
                       items-center gap-1.5
                       rounded-full px-2.5 py-1
                       text-[10px] font-semibold"
                :class="statusClass(candidature.statut)"
            >
                <span
                    class="h-1.5 w-1.5
                           rounded-full bg-current"
                ></span>

                {{ statusLabel(candidature.statut) }}
            </span>
        </div>

        <div
            class="mt-4 grid grid-cols-2 gap-2
                   rounded-xl bg-[#F4F7F9] p-3"
        >
            <div class="col-span-2">
                <p
                    class="text-[9px] font-semibold
                           uppercase tracking-wide
                           text-slate-400"
                >
                    Internship
                </p>

                <p
                    class="mt-1 truncate text-[11px]
                           font-medium text-slate-700"
                >
                    {{ internshipTitle(candidature) }}
                </p>
            </div>

            <div>
                <p
                    class="text-[9px] font-semibold
                           uppercase tracking-wide
                           text-slate-400"
                >
                    Applied
                </p>

                <p
                    class="mt-1 text-[11px]
                           font-medium text-slate-700"
                >
                    {{ formatDate(candidature.date_postulation) }}
                </p>
            </div>

            <div>
                <p
                    class="text-[9px] font-semibold
                           uppercase tracking-wide
                           text-slate-400"
                >
                    Status
                </p>

                <p
                    class="mt-1 text-[11px]
                           font-medium text-slate-700"
                >
                    {{ statusLabel(candidature.statut) }}
                </p>
            </div>
        </div>

        <div
            class="mt-3 flex justify-end gap-2"
        >
            <Link
                :href="
                    route(
                        'entreprise.candidatures.show',
                        candidature.id,
                        false
                    )
                "
                class="inline-flex items-center gap-1.5
                       rounded-lg border
                       border-slate-200 bg-white
                       px-3 py-2 text-xs
                       font-semibold
                       text-slate-600
                       transition
                       hover:border-[#63A9C6]
                       hover:bg-[#f0f8fb]
                       hover:text-[#174E6D]"
            >
                View
            </Link>

            <button
                v-if="candidature.statut !== 'acceptee'"
                type="button"
                @click="
                    $emit(
                        'update-status',
                        candidature,
                        'acceptee'
                    )
                "
                class="rounded-lg border
                       border-emerald-100
                       bg-emerald-50
                       px-3 py-2 text-xs
                       font-semibold
                       text-emerald-600
                       transition
                       hover:bg-emerald-100"
            >
                Accept
            </button>

            <button
                v-if="candidature.statut !== 'refusee'"
                type="button"
                @click="
                    $emit(
                        'update-status',
                        candidature,
                        'refusee'
                    )
                "
                class="rounded-lg border
                       border-red-100
                       bg-red-50
                       px-3 py-2 text-xs
                       font-semibold
                       text-red-500
                       transition
                       hover:bg-red-100"
            >
                Reject
            </button>
        </div>

    </article>
</template>