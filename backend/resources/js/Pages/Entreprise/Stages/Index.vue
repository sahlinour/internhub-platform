<script setup>
import { Head, router } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

const props = defineProps({
    stages: {
        type: Object,
        required: true,
    },
})

const appRoute = (name, params = undefined) =>
    route(name, params, false)

const getStudentName = (stage) => {
    return (
        stage?.candidature?.stagiaire?.user?.nom_complet ??
        'Student'
    )
}

const getStudentEmail = (stage) => {
    return (
        stage?.candidature?.stagiaire?.user?.email ??
        '—'
    )
}

const getInternshipTitle = (stage) => {
    return (
        stage?.candidature?.offre_de_stage?.titre ??
        stage?.sujet ??
        'Internship'
    )
}

const getSupervisorName = (stage) => {
    return (
        stage?.encadrant?.user?.nom_complet ??
        'Not assigned'
    )
}

const getInitials = (name) => {
    if (!name) return 'ST'

    return name
        .trim()
        .split(/\s+/)
        .slice(0, 2)
        .map((word) => word.charAt(0).toUpperCase())
        .join('')
}

const formatDate = (date) => {
    if (!date) return '—'

    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}

const getTimeline = (stage) => {
    if (!stage?.date_debut || !stage?.date_fin) {
        return '—'
    }

    const start = new Date(stage.date_debut)
    const end = new Date(stage.date_fin)

    const today = new Date()

    start.setHours(0, 0, 0, 0)
    end.setHours(0, 0, 0, 0)
    today.setHours(0, 0, 0, 0)

    const millisecondsPerWeek =
        1000 * 60 * 60 * 24 * 7

    const totalWeeks = Math.max(
        1,
        Math.ceil(
            (end.getTime() - start.getTime()) /
                millisecondsPerWeek
        )
    )

    if (today < start) {
        return `Week 0/${totalWeeks}`
    }

    if (today >= end) {
        return `Week ${totalWeeks}/${totalWeeks}`
    }

    const currentWeek = Math.max(
        1,
        Math.ceil(
            (today.getTime() - start.getTime()) /
                millisecondsPerWeek
        )
    )

    return `Week ${Math.min(
        currentWeek,
        totalWeeks
    )}/${totalWeeks}`
}

const getTimelinePercentage = (stage) => {
    if (!stage?.date_debut || !stage?.date_fin) {
        return 0
    }

    const start = new Date(stage.date_debut)
    const end = new Date(stage.date_fin)
    const today = new Date()

    const totalDuration =
        end.getTime() - start.getTime()

    if (totalDuration <= 0) {
        return 100
    }

    if (today <= start) {
        return 0
    }

    if (today >= end) {
        return 100
    }

    const elapsed =
        today.getTime() - start.getTime()

    return Math.min(
        100,
        Math.max(
            0,
            Math.round(
                (elapsed / totalDuration) * 100
            )
        )
    )
}

const deleteStage = (stage) => {
    if (
        !confirm(
            'Are you sure you want to delete this internship?'
        )
    ) {
        return
    }

    router.delete(
        appRoute(
            'entreprise.stages.destroy',
            stage.id
        ),
        {
            preserveScroll: true,
        }
    )
}

const goToPage = (url) => {
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
</script>

<template>
    <Head title="Current Interns" />

    <EntrepriseLayout>
        <div class="min-h-screen bg-slate-50">
            <div
                class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8"
            >
                <!-- Header -->
                <div
                    class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <h1
                            class="text-2xl font-bold text-slate-900"
                        >
                            Current Interns
                        </h1>

                        <p
                            class="mt-1 text-sm text-slate-500"
                        >
                            Track your active internships,
                            supervisors and internship progress.
                        </p>
                    </div>

                    <div
                        class="rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm"
                    >
                        <p
                            class="text-xs font-medium uppercase tracking-wide text-slate-400"
                        >
                            Active Interns
                        </p>

                        <p
                            class="mt-1 text-xl font-bold text-slate-800"
                        >
                            {{ stages.total ?? 0 }}
                        </p>
                    </div>
                </div>

                <!-- Table -->
                <div
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >
                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full divide-y divide-slate-200"
                        >
                            <thead
                                class="bg-slate-50"
                            >
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                    >
                                        Intern
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                    >
                                        Internship
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                    >
                                        Supervisor
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                    >
                                        Start Date
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                    >
                                        End Date
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                    >
                                        Timeline
                                    </th>

                                    <th
                                        class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody
                                class="divide-y divide-slate-100 bg-white"
                            >
                                <tr
                                    v-for="stage in stages.data"
                                    :key="stage.id"
                                    class="transition hover:bg-slate-50"
                                >
                                    <!-- Intern -->
                                    <td
                                        class="whitespace-nowrap px-6 py-5"
                                    >
                                        <div
                                            class="flex items-center gap-3"
                                        >
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-600"
                                            >
                                                {{
                                                    getInitials(
                                                        getStudentName(
                                                            stage
                                                        )
                                                    )
                                                }}
                                            </div>

                                            <div>
                                                <p
                                                    class="font-semibold text-slate-800"
                                                >
                                                    {{
                                                        getStudentName(
                                                            stage
                                                        )
                                                    }}
                                                </p>

                                                <p
                                                    class="mt-0.5 text-xs text-slate-500"
                                                >
                                                    {{
                                                        getStudentEmail(
                                                            stage
                                                        )
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Internship -->
                                    <td
                                        class="px-6 py-5"
                                    >
                                        <p
                                            class="max-w-[220px] font-medium text-slate-700"
                                        >
                                            {{
                                                getInternshipTitle(
                                                    stage
                                                )
                                            }}
                                        </p>

                                        <p
                                            v-if="
                                                stage.sujet &&
                                                stage.sujet !==
                                                    getInternshipTitle(
                                                        stage
                                                    )
                                            "
                                            class="mt-1 max-w-[220px] truncate text-xs text-slate-400"
                                        >
                                            {{ stage.sujet }}
                                        </p>
                                    </td>

                                    <!-- Supervisor -->
                                    <td
                                        class="whitespace-nowrap px-6 py-5"
                                    >
                                        <span
                                            v-if="
                                                stage
                                                    ?.encadrant
                                                    ?.user
                                            "
                                            class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700"
                                        >
                                            {{
                                                getSupervisorName(
                                                    stage
                                                )
                                            }}
                                        </span>

                                        <span
                                            v-else
                                            class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700"
                                        >
                                            Not assigned
                                        </span>
                                    </td>

                                    <!-- Start -->
                                    <td
                                        class="whitespace-nowrap px-6 py-5 text-sm text-slate-600"
                                    >
                                        {{
                                            formatDate(
                                                stage.date_debut
                                            )
                                        }}
                                    </td>

                                    <!-- End -->
                                    <td
                                        class="whitespace-nowrap px-6 py-5 text-sm text-slate-600"
                                    >
                                        {{
                                            formatDate(
                                                stage.date_fin
                                            )
                                        }}
                                    </td>

                                    <!-- Timeline -->
                                    <td
                                        class="min-w-[170px] px-6 py-5"
                                    >
                                        <div
                                            class="flex items-center justify-between gap-3"
                                        >
                                            <span
                                                class="whitespace-nowrap text-sm font-semibold text-slate-600"
                                            >
                                                {{
                                                    getTimeline(
                                                        stage
                                                    )
                                                }}
                                            </span>

                                            <span
                                                class="text-xs font-medium text-slate-400"
                                            >
                                                {{
                                                    getTimelinePercentage(
                                                        stage
                                                    )
                                                }}%
                                            </span>
                                        </div>

                                        <div
                                            v-if="
                                                stage.date_debut &&
                                                stage.date_fin
                                            "
                                            class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-slate-100"
                                        >
                                            <div
                                                class="h-full rounded-full bg-slate-700 transition-all"
                                                :style="{
                                                    width:
                                                        getTimelinePercentage(
                                                            stage
                                                        ) +
                                                        '%',
                                                }"
                                            />
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td
                                        class="whitespace-nowrap px-6 py-5 text-right"
                                    >
                                        <button
                                            type="button"
                                            class="rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                                            @click="
                                                deleteStage(
                                                    stage
                                                )
                                            "
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                                <!-- Empty state -->
                                <tr
                                    v-if="
                                        !stages.data ||
                                        stages.data
                                            .length === 0
                                    "
                                >
                                    <td
                                        colspan="7"
                                        class="px-6 py-16 text-center"
                                    >
                                        <div
                                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6 text-slate-400"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M17 20h5V4H2v16h5m10 0v-2a5 5 0 00-10 0v2m10 0H7m8-11a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                            </svg>
                                        </div>

                                        <h3
                                            class="mt-4 text-sm font-semibold text-slate-800"
                                        >
                                            No current interns
                                        </h3>

                                        <p
                                            class="mt-1 text-sm text-slate-500"
                                        >
                                            Internships will
                                            appear here after
                                            they are created
                                            from accepted
                                            applications.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="
                            stages.links &&
                            stages.links.length > 3
                        "
                        class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 px-6 py-4"
                    >
                        <p
                            class="text-sm text-slate-500"
                        >
                            Showing
                            <span
                                class="font-medium text-slate-700"
                            >
                                {{ stages.from ?? 0 }}
                            </span>
                            to
                            <span
                                class="font-medium text-slate-700"
                            >
                                {{ stages.to ?? 0 }}
                            </span>
                            of
                            <span
                                class="font-medium text-slate-700"
                            >
                                {{ stages.total ?? 0 }}
                            </span>
                            interns
                        </p>

                        <div
                            class="flex flex-wrap gap-1"
                        >
                            <button
                                v-for="(
                                    link, index
                                ) in stages.links"
                                :key="index"
                                type="button"
                                :disabled="!link.url"
                                class="min-w-9 rounded-lg border px-3 py-2 text-sm transition"
                                :class="[
                                    link.active
                                        ? 'border-slate-700 bg-slate-700 text-white'
                                        : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50',
                                    !link.url
                                        ? 'cursor-not-allowed opacity-40'
                                        : '',
                                ]"
                                @click="
                                    goToPage(link.url)
                                "
                                v-html="link.label"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </EntrepriseLayout>
</template>
