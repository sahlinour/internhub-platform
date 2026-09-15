<script setup>
import { computed, ref } from 'vue'
import AssignedInternCard from '@/Components/Encadrant/AssignedInternCard.vue'

const activeFilter = ref('all')


const interns = ref([
    {
        id: 1,
        name: 'Soukayna El Amrani',
        initials: 'SEA',
        position: 'Backend Engineering Intern',
        company: 'ENSI Tanger · Génie Informatique',
        status: 'on_track',
        progress: 68,
        completedTasks: 9,
        totalTasks: 14,
        logbookPending: 1,
        evaluation: null,
        skills: ['PHP', 'Laravel', 'Vue.js', 'Docker'],
    },
    {
        id: 2,
        name: 'Marcus Chen',
        initials: 'MC',
        position: 'Software Engineering Intern',
        company: 'Tech Company',
        status: 'on_track',
        progress: 82,
        completedTasks: 12,
        totalTasks: 14,
        logbookPending: 0,
        evaluation: 4.6,
        skills: ['Go', 'PostgreSQL', 'React', 'Kubernetes'],
    },
    {
        id: 3,
        name: 'Priya Nair',
        initials: 'PN',
        position: 'Data Infrastructure Intern',
        company: 'Data Company',
        status: 'at_risk',
        progress: 41,
        completedTasks: 5,
        totalTasks: 12,
        logbookPending: 2,
        evaluation: null,
        skills: ['Python', 'Kafka', 'SQL', 'Airflow'],
    },
    {
        id: 4,
        name: 'Tom Baptiste',
        initials: 'TB',
        position: 'Platform Engineering Intern',
        company: 'Cloud Company',
        status: 'on_track',
        progress: 55,
        completedTasks: 7,
        totalTasks: 13,
        logbookPending: 1,
        evaluation: 4.1,
        skills: ['Go', 'Terraform', 'AWS', 'Kubernetes'],
    },
])

/*
|--------------------------------------------------------------------------
| Filtering
|--------------------------------------------------------------------------
*/
const filteredInterns = computed(() => {
    if (activeFilter.value === 'all') {
        return interns.value
    }

    return interns.value.filter(
        intern => intern.status === activeFilter.value
    )
})

/*
|--------------------------------------------------------------------------
| Actions
|--------------------------------------------------------------------------
*/
const viewProfile = (intern) => {
    console.log('View profile:', intern)
}

const assignTask = (intern) => {
    console.log('Assign task:', intern)
}
</script>

<template>
    <section class="mx-auto w-full max-w-[1500px]">

        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4
                   sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Assigned Interns
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Interns currently under your supervision
                </p>
            </div>

            <!-- Filters -->
            <div class="flex rounded-lg bg-slate-100 p-1">

                <button
                    type="button"
                    @click="activeFilter = 'all'"
                    class="rounded-md px-4 py-2
                           text-xs font-medium transition"
                    :class="
                        activeFilter === 'all'
                            ? 'bg-white text-slate-900 shadow-sm'
                            : 'text-slate-500 hover:text-slate-800'
                    "
                >
                    All
                </button>

                <button
                    type="button"
                    @click="activeFilter = 'on_track'"
                    class="rounded-md px-4 py-2
                           text-xs font-medium transition"
                    :class="
                        activeFilter === 'on_track'
                            ? 'bg-white text-slate-900 shadow-sm'
                            : 'text-slate-500 hover:text-slate-800'
                    "
                >
                    On Track
                </button>

                <button
                    type="button"
                    @click="activeFilter = 'at_risk'"
                    class="rounded-md px-4 py-2
                           text-xs font-medium transition"
                    :class="
                        activeFilter === 'at_risk'
                            ? 'bg-white text-slate-900 shadow-sm'
                            : 'text-slate-500 hover:text-slate-800'
                    "
                >
                    At Risk
                </button>

            </div>
        </div>

        <!-- Intern cards -->
        <div
            v-if="filteredInterns.length"
            class="grid grid-cols-1 gap-5 xl:grid-cols-2"
        >
            <AssignedInternCard
                v-for="(intern, index) in filteredInterns"
                :key="intern.id"
                :intern="intern"
                :index="index"
                @view-profile="viewProfile"
                @assign-task="assignTask"
            />
        </div>

        <!-- Empty state -->
        <div
            v-else
            class="rounded-xl border border-slate-200
                   bg-white px-6 py-16 text-center shadow-sm"
        >
            <div
                class="mx-auto flex h-12 w-12 items-center
                       justify-center rounded-full bg-slate-100"
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
                        stroke-width="1.7"
                        d="M16 21v-2a4 4 0 00-4-4H6
                           a4 4 0 00-4 4v2
                           M9 11a4 4 0 100-8 4 4 0 000 8
                           M22 21v-2a4 4 0 00-3-3.87"
                    />
                </svg>
            </div>

            <h3 class="mt-4 text-sm font-semibold text-slate-700">
                No interns found
            </h3>

            <p class="mt-1 text-xs text-slate-400">
                There are no interns matching this filter.
            </p>
        </div>

    </section>
</template>
