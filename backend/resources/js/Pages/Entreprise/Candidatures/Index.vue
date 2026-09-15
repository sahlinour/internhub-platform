<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { computed } from 'vue'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

const props = defineProps({
    candidatures: {
        type: Object,
        required: true,
    },

    offres: {
        type: Array,
        default: () => [],
    },

    filters: {
        type: Object,
        default: () => ({
            statut: '',
            offre_id: '',
        }),
    },
})

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}

const applications = computed(() => {
    return props.candidatures?.data ?? []
})

const totalApplicants = computed(() => {
    return props.candidatures?.total ?? applications.value.length
})

const paginationLinks = computed(() => {
    return props.candidatures?.links ?? []
})

const changeInternship = (event) => {
    const offreId = event.target.value

    router.get(
        appRoute('entreprise.candidatures.index'),
        {
            offre_id: offreId || undefined,
            statut: props.filters?.statut || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

const changeStatusFilter = (event) => {
    const statut = event.target.value

    router.get(
        appRoute('entreprise.candidatures.index'),
        {
            offre_id: props.filters?.offre_id || undefined,
            statut: statut || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

const updateStatus = (candidature, statut) => {
    router.patch(
        appRoute(
            'entreprise.candidatures.updateStatus',
            candidature.id
        ),
        {
            statut,
        },
        {
            preserveScroll: true,
        }
    )
}

const visitPage = (url) => {
    if (!url) return

    router.get(
        url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}

const formatDate = (date) => {
    if (!date) return '—'

    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}

const getApplicantName = (candidature) => {
    return (
        candidature?.stagiaire?.user?.nom_complet ??
        candidature?.stagiaire?.user?.name ??
        'Unknown applicant'
    )
}

const getApplicantEmail = (candidature) => {
    return candidature?.stagiaire?.user?.email ?? '—'
}

const getInitials = (candidature) => {
    return getApplicantName(candidature)
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((word) => word.charAt(0).toUpperCase())
        .join('')
}

const getInternshipTitle = (candidature) => {
    return candidature?.offre_de_stage?.titre ?? '—'
}

const statusLabel = (status) => {
    switch (status) {
        case 'en_attente':
            return 'Pending'

        case 'acceptee':
            return 'Accepted'

        case 'refusee':
            return 'Rejected'

        default:
            return status ?? '—'
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'en_attente':
            return 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200'

        case 'acceptee':
            return 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200'

        case 'refusee':
            return 'bg-red-50 text-red-600 ring-1 ring-inset ring-red-200'

        default:
            return 'bg-slate-100 text-slate-600'
    }
}
</script>

<template>
    <EntrepriseLayout>
        <Head title="Applicants" />

        <div class="space-y-6">

            <!-- HEADER -->
            <div
                class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between"
            >
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-slate-900"
                    >
                        Applicants
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Review and manage applicants for your internship offers.
                    </p>
                </div>

                <!-- FILTERS -->
                <div
                    class="flex flex-col gap-3 sm:flex-row sm:items-center"
                >
                    <!-- STATUS -->
                    <div class="relative">
                        <select
                            :value="filters?.statut || ''"
                            @change="changeStatusFilter"
                            class="h-11 min-w-[170px] appearance-none rounded-xl border border-slate-200 bg-white px-4 pr-10 text-sm font-medium text-slate-700 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                        >
                            <option value="">
                                All Statuses
                            </option>

                            <option value="en_attente">
                                Pending
                            </option>

                            <option value="acceptee">
                                Accepted
                            </option>

                            <option value="refusee">
                                Rejected
                            </option>
                        </select>

                        <svg
                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>

                    <!-- INTERNSHIP -->
                    <div class="relative">
                        <select
                            :value="filters?.offre_id || ''"
                            @change="changeInternship"
                            class="h-11 min-w-[230px] appearance-none rounded-xl border border-slate-200 bg-white px-4 pr-10 text-sm font-medium text-slate-700 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-100"
                        >
                            <option value="">
                                All Internships
                            </option>

                            <option
                                v-for="offre in offres"
                                :key="offre.id"
                                :value="offre.id"
                            >
                                {{ offre.titre }}
                            </option>
                        </select>

                        <svg
                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- SUMMARY -->
            <div
                class="rounded-2xl border border-slate-200 bg-white px-6 py-5 shadow-sm"
            >
                <div
                    class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <p
                            class="text-sm font-medium text-slate-500"
                        >
                            Total applicants
                        </p>

                        <p
                            class="mt-1 text-2xl font-bold text-slate-900"
                        >
                            {{ totalApplicants }}
                        </p>
                    </div>

                    <p
                        class="text-sm text-slate-500"
                    >
                        {{ applications.length }}
                        applicant{{ applications.length === 1 ? '' : 's' }}
                        displayed on this page
                    </p>
                </div>
            </div>

            <!-- TABLE -->
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
            >
                <div class="overflow-x-auto">
                    <table
                        class="min-w-[1000px] w-full table-fixed"
                    >
                        <thead class="bg-slate-50">
                            <tr
                                class="border-b border-slate-200 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                            >
                                <th
                                    class="w-[27%] px-6 py-4"
                                >
                                    Applicant
                                </th>

                                <th
                                    class="w-[24%] px-6 py-4"
                                >
                                    Internship
                                </th>

                                <th
                                    class="w-[14%] px-6 py-4"
                                >
                                    Applied
                                </th>

                                <th
                                    class="w-[14%] px-6 py-4"
                                >
                                    Status
                                </th>

                                <th
                                    class="w-[21%] px-6 py-4 text-right"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody
                            class="divide-y divide-slate-100"
                        >
                            <tr
                                v-for="candidature in applications"
                                :key="candidature.id"
                                class="transition hover:bg-slate-50/70"
                            >
                                <!-- APPLICANT -->
                                <td class="px-6 py-5">
                                    <div
                                        class="flex items-center gap-3"
                                    >
                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-700"
                                        >
                                            {{
                                                getInitials(
                                                    candidature
                                                )
                                            }}
                                        </div>

                                        <div class="min-w-0">
                                            <p
                                                class="truncate text-sm font-semibold text-slate-900"
                                            >
                                                {{
                                                    getApplicantName(
                                                        candidature
                                                    )
                                                }}
                                            </p>

                                            <p
                                                class="mt-0.5 truncate text-xs text-slate-500"
                                            >
                                                {{
                                                    getApplicantEmail(
                                                        candidature
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- INTERNSHIP -->
                                <td class="px-6 py-5">
                                    <p
                                        class="line-clamp-2 text-sm font-medium leading-5 text-slate-700"
                                    >
                                        {{
                                            getInternshipTitle(
                                                candidature
                                            )
                                        }}
                                    </p>
                                </td>

                                <!-- DATE -->
                                <td class="px-6 py-5">
                                    <span
                                        class="text-sm text-slate-600"
                                    >
                                        {{
                                            formatDate(
                                                candidature.date_postulation
                                            )
                                        }}
                                    </span>
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold"
                                        :class="
                                            statusClass(
                                                candidature.statut
                                            )
                                        "
                                    >
                                        {{
                                            statusLabel(
                                                candidature.statut
                                            )
                                        }}
                                    </span>
                                </td>

                                <!-- ACTIONS -->
                                <td class="px-6 py-5">
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <!-- VIEW -->
                                        <Link
                                            :href="
                                                appRoute(
                                                    'entreprise.candidatures.show',
                                                    candidature.id
                                                )
                                            "
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50"
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
                                                    d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                                                />
                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="2.75"
                                                    stroke-width="1.8"
                                                />
                                            </svg>

                                            View
                                        </Link>

                                        <!-- ACCEPT -->
                                        <button
                                            v-if="
                                                candidature.statut !==
                                                'acceptee'
                                            "
                                            type="button"
                                            @click="
                                                updateStatus(
                                                    candidature,
                                                    'acceptee'
                                                )
                                            "
                                            class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100"
                                        >
                                            Accept
                                        </button>

                                        <!-- REJECT -->
                                        <button
                                            v-if="
                                                candidature.statut !==
                                                'refusee'
                                            "
                                            type="button"
                                            @click="
                                                updateStatus(
                                                    candidature,
                                                    'refusee'
                                                )
                                            "
                                            class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-100"
                                        >
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- EMPTY -->
                            <tr
                                v-if="
                                    applications.length === 0
                                "
                            >
                                <td
                                    colspan="5"
                                    class="px-6 py-16 text-center"
                                >
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100"
                                    >
                                        <svg
                                            class="h-6 w-6 text-slate-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M17 20h5v-2a4 4 0 0 0-4-4h-1m-2 6H3v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2Zm-4-10a4 4 0 1 0-8 0 4 4 0 0 0 8 0Zm9 0a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                            />
                                        </svg>
                                    </div>

                                    <h3
                                        class="mt-4 text-sm font-semibold text-slate-900"
                                    >
                                        No applicants found
                                    </h3>

                                    <p
                                        class="mx-auto mt-1 max-w-sm text-sm text-slate-500"
                                    >
                                        No applications match
                                        the selected internship
                                        or status.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div
                    v-if="
                        paginationLinks.length > 3
                    "
                    class="flex flex-col gap-3 border-t border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <p
                        class="text-sm text-slate-500"
                    >
                        Showing
                        {{ candidatures.from ?? 0 }}
                        to
                        {{ candidatures.to ?? 0 }}
                        of
                        {{ candidatures.total ?? 0 }}
                        applicants
                    </p>

                    <div
                        class="flex flex-wrap items-center gap-1"
                    >
                        <button
                            v-for="(
                                link,
                                index
                            ) in paginationLinks"
                            :key="index"
                            type="button"
                            :disabled="!link.url"
                            @click="
                                visitPage(
                                    link.url
                                )
                            "
                            class="min-w-9 rounded-lg border px-3 py-2 text-sm transition"
                            :class="[
                                link.active
                                    ? 'border-slate-800 bg-slate-800 text-white'
                                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50',

                                !link.url
                                    ? 'cursor-not-allowed opacity-40'
                                    : '',
                            ]"
                            v-html="
                                link.label
                            "
                        />
                    </div>
                </div>
            </div>

        </div>
    </EntrepriseLayout>
</template>
