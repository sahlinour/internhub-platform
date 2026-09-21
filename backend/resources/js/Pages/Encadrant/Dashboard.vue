<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'
import StatCard from '@/Components/Encadrant/StatCard.vue'
import StagiaireCard from '@/Components/Encadrant/StagiaireCard.vue'
import RecentActivity from '@/Components/Encadrant/RecentActivity.vue'
import PendingTaskReviews from '@/Components/Encadrant/PendingTaskReviews.vue'

defineProps({
    encadrant: {
        type: Object,
        default: () => ({
            id: null,
            name: 'Supervisor',
        }),
    },

    stats: {
        type: Object,
        default: () => ({
            stagiaires: 0,
            pendingReviews: 0,
            meetings: 0,
            averageProgress: 0,
        }),
    },

    stagiaires: {
        type: Array,
        default: () => [],
    },

    activities: {
        type: Array,
        default: () => [],
    },

    pendingTasks: {
        type: Array,
        default: () => [],
    },
})

const reviewTask = (task) => {
    if (!task?.id) return

    router.get(
        route('encadrant.task-reviews.index'),
        {
            task_id: task.id,
        },
        {
            preserveScroll: true,
            preserveState: false,
        }
    )
}
</script>

<template>
    <Head title="Supervisor Dashboard" />

    <EncadrantLayout>
        <div class="mx-auto max-w-[1500px] space-y-5">
            <!-- Header -->
            <section
                class="rounded-xl bg-gradient-to-r from-[#17629b] to-[#2385c4] p-6 text-white shadow-sm"
            >
                <div
                    class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <p class="text-sm font-medium text-blue-100">
                            Supervisor Dashboard
                        </p>

                        <h1 class="mt-1 text-2xl font-bold">
                            Welcome back, {{ encadrant.name }}
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm text-blue-100">
                            Monitor your students, review their work and track
                            their internship progress.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <Link
                            :href="route('encadrant.task-reviews.index')"
                            class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#17629b] transition hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white/60"
                        >
                            Review tasks

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </Link>

                        <Link
                            :href="route('encadrant.stagiaires.index')"
                            class="inline-flex items-center gap-2 rounded-lg border border-white/70 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/60"
                        >
                            View students
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Statistics -->
            <section
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4"
            >
                <StatCard
                    title="Assigned students"
                    :value="stats.stagiaires"
                    subtitle="Students currently under your supervision"
                    icon="users"
                    variant="blue"
                />

                <StatCard
                    title="Tasks to review"
                    :value="stats.pendingReviews"
                    subtitle="Waiting for your feedback"
                    icon="tasks"
                    variant="violet"
                />

                <StatCard
                    title="Upcoming meetings"
                    :value="stats.meetings"
                    subtitle="Scheduled meetings"
                    icon="calendar"
                    variant="orange"
                />

                <StatCard
                    title="Average progress"
                    :value="`${stats.averageProgress}%`"
                    subtitle="Overall student progress"
                    icon="progress"
                    variant="green"
                />
            </section>

            <!-- Main dashboard content -->
            <section
                class="grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,2fr)_minmax(280px,0.8fr)]"
            >
                <!-- Left column -->
                <div class="space-y-5">
                    <!-- Assigned students -->
                    <section
                        class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
                    >
                        <div
                            class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
                        >
                            <div>
                                <h2 class="text-sm font-semibold text-gray-900">
                                    Assigned students
                                </h2>

                                <p class="mt-1 text-xs text-gray-400">
                                    Monitor your students and their progress
                                </p>
                            </div>

                            <Link
                                :href="route('encadrant.stagiaires.index')"
                                class="inline-flex w-fit items-center gap-1 rounded-lg border border-[#17629b] px-3 py-2 text-xs font-semibold text-[#17629b] transition hover:bg-[#17629b] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#17629b]/30"
                            >
                                View all

                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </Link>
                        </div>

                        <div
                            v-if="stagiaires.length"
                            class="grid grid-cols-1 gap-4 lg:grid-cols-2"
                        >
                            <StagiaireCard
                                v-for="stagiaire in stagiaires"
                                :key="stagiaire.id"
                                :stagiaire="stagiaire"
                            />
                        </div>

                        <div
                            v-else
                            class="rounded-lg border border-dashed border-gray-200 px-4 py-10 text-center"
                        >
                            <div
                                class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400"
                            >
                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                    />

                                    <circle cx="9" cy="7" r="4" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 8v6M22 11h-6"
                                    />
                                </svg>
                            </div>

                            <p class="mt-3 text-sm font-medium text-gray-700">
                                No students assigned
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                Students assigned to you will appear here.
                            </p>

                            <Link
                                :href="route('encadrant.stagiaires.index')"
                                class="mt-4 inline-flex items-center rounded-lg bg-[#17629b] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#124f7d] focus:outline-none focus:ring-2 focus:ring-[#17629b]/30"
                            >
                                Open student list
                            </Link>
                        </div>
                    </section>

                    <!-- Pending reviews -->
                    <PendingTaskReviews
                        :tasks="pendingTasks"
                        @review="reviewTask"
                    />
                </div>

                <!-- Right column -->
                <div>
                    <RecentActivity :activities="activities" />
                </div>
            </section>
        </div>
    </EncadrantLayout>
</template>
