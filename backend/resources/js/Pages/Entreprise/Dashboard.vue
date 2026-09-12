<script setup>
import { Head } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

defineProps({
    stats: {
        type: Object,
        default: () => ({
            open_offers: 0,
            applicants: 0,
            accepted: 0,
            active_interns: 0,
        }),
    },

    recentApplicants: {
        type: Array,
        default: () => [],
    },

    upcomingInterviews: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <Head title="Company Dashboard" />

    <EntrepriseLayout>


        <section
            class="relative overflow-hidden rounded-2xl
                   bg-gradient-to-r from-[#174e6d] to-[#286f8e]
                   px-7 py-7 text-white shadow-sm"
        >

            <div
                class="absolute -right-10 -top-14
                       h-44 w-44 rounded-full
                       border-[28px] border-white/[0.05]"
            ></div>

            <div
                class="absolute right-28 top-14
                       h-24 w-24 rounded-full
                       bg-white/[0.04]"
            ></div>

            <div class="relative z-10">
                <h1 class="text-[22px] font-bold">
                    Welcome back!
                </h1>

                <p
                    class="mt-2 max-w-[550px]
                           text-[11px] leading-5 text-white/70"
                >
                    Manage your internship opportunities, review applicants
                    and follow the progress of your interns from one place.
                </p>

                
            </div>
        </section>


        <section
            class="mt-6 grid grid-cols-1 gap-4
                   sm:grid-cols-2 xl:grid-cols-4"
        >
            <!-- OPEN OFFERS -->
            <div
                class="rounded-xl border border-gray-100
                       bg-white p-5 shadow-sm"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p
                            class="text-[10px] font-medium
                                   text-gray-400"
                        >
                            Open Internships
                        </p>

                        <p
                            class="mt-2 text-[25px]
                                   font-bold text-gray-800"
                        >
                            {{ stats.open_offers }}
                        </p>

                        <p
                            class="mt-1 text-[9px]
                                   text-emerald-500"
                        >
                            Active opportunities
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl bg-blue-50
                               text-[#2d7da0]"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <rect
                                x="3"
                                y="7"
                                width="18"
                                height="13"
                                rx="2"
                            />
                            <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                    </div>
                </div>
            </div>


            <div
                class="rounded-xl border border-gray-100
                       bg-white p-5 shadow-sm"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[10px] font-medium text-gray-400">
                            Total Applicants
                        </p>

                        <p class="mt-2 text-[25px] font-bold text-gray-800">
                            {{ stats.applicants }}
                        </p>

                        <p class="mt-1 text-[9px] text-gray-400">
                            Across your offers
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl bg-violet-50
                               text-violet-500"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- ACCEPTED -->
            <div
                class="rounded-xl border border-gray-100
                       bg-white p-5 shadow-sm"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[10px] font-medium text-gray-400">
                            Accepted Students
                        </p>

                        <p class="mt-2 text-[25px] font-bold text-gray-800">
                            {{ stats.accepted }}
                        </p>

                        <p class="mt-1 text-[9px] text-emerald-500">
                            Approved applications
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl bg-emerald-50
                               text-emerald-500"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- ACTIVE INTERNS -->
            <div
                class="rounded-xl border border-gray-100
                       bg-white p-5 shadow-sm"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[10px] font-medium text-gray-400">
                            Current Interns
                        </p>

                        <p class="mt-2 text-[25px] font-bold text-gray-800">
                            {{ stats.active_interns }}
                        </p>

                        <p class="mt-1 text-[9px] text-gray-400">
                            Active internships
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl bg-orange-50
                               text-orange-500"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M22 10 12 5 2 10l10 5 10-5Z" />
                            <path d="M6 12v5c3 2 9 2 12 0v-5" />
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- =========================
             MAIN CONTENT
        ========================== -->
        <section
            class="mt-6 grid grid-cols-1 gap-5
                   xl:grid-cols-[1.7fr_1fr]"
        >
            <!-- RECENT APPLICANTS -->
            <div
                class="overflow-hidden rounded-xl
                       border border-gray-100
                       bg-white shadow-sm"
            >
                <div
                    class="flex items-center justify-between
                           border-b border-gray-100
                           px-5 py-4"
                >
                    <div>
                        <h2 class="text-[13px] font-semibold text-gray-800">
                            Recent Applicants
                        </h2>

                        <p class="mt-1 text-[9px] text-gray-400">
                            Latest applications to your internships
                        </p>
                    </div>

                    <button
                        class="text-[9px] font-semibold
                               text-[#2d7da0] hover:underline"
                    >
                        View All
                    </button>
                </div>

                <!-- EMPTY STATE -->
                <div
                    v-if="recentApplicants.length === 0"
                    class="flex min-h-[220px]
                           flex-col items-center
                           justify-center px-5 text-center"
                >
                    <div
                        class="flex h-12 w-12
                               items-center justify-center
                               rounded-full bg-gray-50
                               text-gray-400"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                    </div>

                    <p class="mt-3 text-[11px] font-semibold text-gray-600">
                        No applications yet
                    </p>

                    <p class="mt-1 text-[9px] text-gray-400">
                        New applications will appear here.
                    </p>
                </div>

                <!-- APPLICANTS -->
                <div v-else class="divide-y divide-gray-100">
                    <div
                        v-for="applicant in recentApplicants"
                        :key="applicant.id"
                        class="flex items-center
                               justify-between px-5 py-4
                               transition hover:bg-gray-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9
                                       items-center justify-center
                                       rounded-full bg-[#e8f3f7]
                                       text-[10px] font-bold
                                       text-[#286f8e]"
                            >
                                {{ applicant.initials ?? 'ST' }}
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold text-gray-700">
                                    {{ applicant.name }}
                                </p>

                                <p class="mt-1 text-[8px] text-gray-400">
                                    {{ applicant.offer }}
                                </p>
                            </div>
                        </div>

                        <span
                            class="rounded-full bg-amber-50
                                   px-2.5 py-1
                                   text-[8px] font-medium
                                   text-amber-600"
                        >
                            {{ applicant.status ?? 'Pending' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="space-y-5">

                <!-- UPCOMING INTERVIEWS -->
                <div
                    class="rounded-xl border border-gray-100
                           bg-white p-5 shadow-sm"
                >
                    <div class="flex items-center justify-between">
                        <h2 class="text-[13px] font-semibold text-gray-800">
                            Upcoming Interviews
                        </h2>

                        <span class="text-[9px] text-[#2d7da0]">
                            View Calendar
                        </span>
                    </div>

                    <div
                        v-if="upcomingInterviews.length === 0"
                        class="flex min-h-[120px]
                               flex-col items-center
                               justify-center text-center"
                    >
                        <p class="text-[10px] font-medium text-gray-500">
                            No interviews scheduled
                        </p>

                        <p class="mt-1 text-[8px] text-gray-400">
                            Upcoming interviews will appear here.
                        </p>
                    </div>

                    <div
                        v-else
                        class="mt-4 space-y-3"
                    >
                        <div
                            v-for="interview in upcomingInterviews"
                            :key="interview.id"
                            class="rounded-lg bg-gray-50 p-3"
                        >
                            <p class="text-[10px] font-semibold text-gray-700">
                                {{ interview.student }}
                            </p>

                            <p class="mt-1 text-[8px] text-gray-400">
                                {{ interview.date }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- QUICK ACTIONS -->
                <div
                    class="rounded-xl border border-gray-100
                           bg-white p-5 shadow-sm"
                >
                    <h2 class="text-[13px] font-semibold text-gray-800">
                        Quick Actions
                    </h2>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <button
                            class="rounded-lg border border-gray-100
                                   bg-gray-50 px-3 py-3
                                   text-[9px] font-semibold
                                   text-gray-600 transition
                                   hover:border-[#63a9c6]/30
                                   hover:bg-[#f0f8fb]
                                   hover:text-[#174e6d]"
                        >
                            + Post Internship
                        </button>

                        <button
                            class="rounded-lg border border-gray-100
                                   bg-gray-50 px-3 py-3
                                   text-[9px] font-semibold
                                   text-gray-600 transition
                                   hover:border-[#63a9c6]/30
                                   hover:bg-[#f0f8fb]
                                   hover:text-[#174e6d]"
                        >
                            View Applicants
                        </button>

                        <button
                            class="rounded-lg border border-gray-100
                                   bg-gray-50 px-3 py-3
                                   text-[9px] font-semibold
                                   text-gray-600 transition
                                   hover:border-[#63a9c6]/30
                                   hover:bg-[#f0f8fb]
                                   hover:text-[#174e6d]"
                        >
                            Add Supervisor
                        </button>

                        <button
                            class="rounded-lg border border-gray-100
                                   bg-gray-50 px-3 py-3
                                   text-[9px] font-semibold
                                   text-gray-600 transition
                                   hover:border-[#63a9c6]/30
                                   hover:bg-[#f0f8fb]
                                   hover:text-[#174e6d]"
                        >
                            Company Profile
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- =========================
             APPLICATIONS OVERVIEW
        ========================== -->
        <section
            class="mt-5 rounded-xl border border-gray-100
                   bg-white p-5 shadow-sm"
        >
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-[13px] font-semibold text-gray-800">
                        Applications Overview
                    </h2>

                    <p class="mt-1 text-[9px] text-gray-400">
                        Application activity across your internship offers
                    </p>
                </div>

                <select
                    class="rounded-lg border border-gray-200
                           bg-white px-3 py-2
                           text-[9px] text-gray-500
                           outline-none
                           focus:border-[#63a9c6]
                           focus:ring-0"
                >
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 3 months</option>
                </select>
            </div>

            <!-- Chart placeholder -->
            <div
                class="mt-5 flex h-[180px]
                       items-center justify-center
                       rounded-lg border border-dashed
                       border-gray-200 bg-gray-50/50"
            >
                <p class="text-[9px] text-gray-400">
                    Application chart will be connected later
                </p>
            </div>
        </section>

    </EntrepriseLayout>
</template>
