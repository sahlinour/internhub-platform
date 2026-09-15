<script setup>
import { computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

const props = defineProps({
    acceptedStudents: {
        type: Object,
        required: true,
    },
})

const appRoute = (name, params = undefined) =>
    route(name, params, false)

const students = computed(() => {
    return props.acceptedStudents?.data ?? []
})

const totalStudents = computed(() => {
    return props.acceptedStudents?.total ?? students.value.length
})

const paginationLinks = computed(() => {
    return props.acceptedStudents?.links ?? []
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
            class:
                'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',
        }
    }

    if (!candidature.stage.date_debut) {
        return {
            label: 'Awaiting start',
            class:
                'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-200',
        }
    }

    const startDate = new Date(candidature.stage.date_debut)
    const today = new Date()

    startDate.setHours(0, 0, 0, 0)
    today.setHours(0, 0, 0, 0)

    if (startDate > today) {
        return {
            label: 'Awaiting start',
            class:
                'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-200',
        }
    }

    return {
        label: 'Started',
        class:
            'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',
    }
}

const visitPage = (url) => {
    if (!url) {
        return
    }

    router.get(
        url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <EntrepriseLayout>
        <Head title="Accepted Students" />

        <div class="space-y-6">
            <!-- PAGE HEADER -->
            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-slate-900"
                    >
                        Accepted Students
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Students accepted for your internship offers
                    </p>
                </div>

                <!-- TOTAL -->
                <div
                    class="inline-flex w-fit items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm"
                >
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50"
                    >
                        <svg
                            class="h-4 w-4 text-emerald-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m5 13 4 4L19 7"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500">
                            Total accepted
                        </p>

                        <p class="text-sm font-bold text-slate-900">
                            {{ totalStudents }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
            >
                <!-- TABLE HEADER -->
                <div
                    class="flex items-center justify-between border-b border-slate-200 px-6 py-5"
                >
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">
                            Accepted Students
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage students who have been accepted for internships
                        </p>
                    </div>
                </div>

                <!-- TABLE -->
                <div
                    v-if="students.length"
                    class="overflow-x-auto"
                >
                    <table class="w-full min-w-[900px] table-fixed">
                        <thead>
                            <tr
                                class="border-b border-slate-200 bg-slate-50/80"
                            >
                                <th
                                    class="w-[30%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Student
                                </th>

                                <th
                                    class="w-[27%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Internship
                                </th>

                                <th
                                    class="w-[18%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Start Date
                                </th>

                                <th
                                    class="w-[15%] px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Status
                                </th>

                                <th
                                    class="w-[10%] px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            <tr
                                v-for="candidature in students"
                                :key="candidature.id"
                                class="transition-colors hover:bg-slate-50/70"
                            >
                                <!-- STUDENT -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#e8f2f7] text-sm font-bold text-[#1c3a52]"
                                        >
                                            {{ getInitials(candidature) }}
                                        </div>

                                        <div class="min-w-0">
                                            <p
                                                class="truncate text-sm font-semibold text-slate-900"
                                            >
                                                {{ getName(candidature) }}
                                            </p>

                                            <p
                                                class="mt-1 truncate text-xs text-slate-500"
                                            >
                                                {{ getEmail(candidature) }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- INTERNSHIP -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100"
                                        >
                                            <svg
                                                class="h-4 w-4 text-slate-500"
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

                                        <span
                                            class="truncate text-sm font-medium text-slate-700"
                                        >
                                            {{ getInternship(candidature) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- START DATE -->
                                <td class="px-6 py-5">
                                    <div
                                        v-if="getStartDate(candidature)"
                                        class="flex items-center gap-2 text-sm text-slate-700"
                                    >
                                        <svg
                                            class="h-4 w-4 shrink-0 text-slate-400"
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

                                        <span class="font-medium">
                                            {{ getStartDate(candidature) }}
                                        </span>
                                    </div>

                                    <span
                                        v-else
                                        class="text-sm text-slate-400"
                                    >
                                        Not set
                                    </span>
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-semibold"
                                        :class="
                                            getOnboardingStatus(candidature).class
                                        "
                                    >
                                        {{
                                            getOnboardingStatus(candidature)
                                                .label
                                        }}
                                    </span>
                                </td>

                                <!-- ACTIONS -->
                                <td class="px-6 py-5 text-right">
                                    <Link
                                        :href="
                                            appRoute(
                                                'entreprise.acceptedStudents.show',
                                                candidature.id
                                            )
                                        "
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-[#1c3a52] hover:text-[#1c3a52]"
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
                        </tbody>
                    </table>
                </div>

                <!-- EMPTY STATE -->
                <div
                    v-else
                    class="px-6 py-20 text-center"
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
                                d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 0 2 2 4-4"
                            />
                        </svg>
                    </div>

                    <h3
                        class="mt-4 text-sm font-semibold text-slate-900"
                    >
                        No accepted students yet
                    </h3>

                    <p
                        class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500"
                    >
                        Students will appear here once you accept their
                        internship applications.
                    </p>
                </div>

                <!-- PAGINATION -->
                <div
                    v-if="paginationLinks.length > 3"
                    class="flex flex-col gap-3 border-t border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <p class="text-sm text-slate-500">
                        Showing

                        <span class="font-medium text-slate-700">
                            {{ acceptedStudents.from ?? 0 }}
                        </span>

                        to

                        <span class="font-medium text-slate-700">
                            {{ acceptedStudents.to ?? 0 }}
                        </span>

                        of

                        <span class="font-medium text-slate-700">
                            {{ acceptedStudents.total ?? 0 }}
                        </span>
                    </p>

                    <div class="flex items-center gap-1">
                        <button
                            v-for="(link, index) in paginationLinks"
                            :key="index"
                            type="button"
                            :disabled="!link.url"
                            @click="visitPage(link.url)"
                            class="min-w-9 rounded-lg border px-3 py-2 text-sm font-medium transition"
                            :class="[
                                link.active
                                    ? 'border-[#1c3a52] bg-[#1c3a52] text-white'
                                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50',

                                !link.url
                                    ? 'cursor-not-allowed opacity-40'
                                    : '',
                            ]"
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>
        </div>
    </EntrepriseLayout>
</template>
