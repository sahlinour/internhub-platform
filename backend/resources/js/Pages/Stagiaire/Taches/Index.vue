<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import TaskStats from '@/Components/Stagiaire/Taches/TaskStats.vue'
import TaskCard from '@/Components/Stagiaire/Taches/TaskCard.vue'
import TaskPagination from '@/Components/Stagiaire/Taches/TaskPagination.vue'
import TaskHeader from '@/Components/Stagiaire/Taches/TaskHeader.vue'

const props = defineProps({
    taches: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
})

const tasks = computed(() => props.taches?.data ?? [])

const totalTasks = computed(() => props.taches?.total ?? 0)

const pendingTasks = computed(() => {
    return tasks.value.filter(
        (task) => task.statut === 'À faire'
    ).length
})

const inProgressTasks = computed(() => {
    return tasks.value.filter(
        (task) => task.statut === 'En cours'
    ).length
})

const completedTasks = computed(() => {
    return tasks.value.filter(
        (task) => task.statut === 'Terminée'
    ).length
})

const ratio = (value) => {
    if (totalTasks.value === 0) {
        return 0
    }

    return Math.round((value / totalTasks.value) * 100)
}

const updateFilter = (event) => {
    const statut = event.target.value

    router.get(
        route('stagiaire.taches.index'),
        statut ? { statut } : {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <StagiaireLayout>
        <main class="min-h-screen bg-[#F4F7F9]">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <!-- PAGE HEADER -->
                <TaskHeader />

                <!-- STATISTICS -->
                <TaskStats
                    :total-tasks="totalTasks"
                    :pending-tasks="pendingTasks"
                    :in-progress-tasks="inProgressTasks"
                    :completed-tasks="completedTasks"
                />

                <!-- TASK SECTION -->
                <section
                    class="mt-10 rounded-2xl border border-slate-100
                        bg-white
                        shadow-[0_4px_18px_rgba(16,46,65,0.045)]"
                >
                    <!-- SECTION HEADER -->
                    <div
                        class="flex flex-col gap-3
                            border-b border-slate-100
                            px-5 py-4
                            sm:flex-row sm:items-center
                            sm:justify-between"
                    >
                        <div>
                            <h2
                                class="text-[14px] font-bold
                                    text-[#16425B]"
                            >
                                Assigned Tasks
                            </h2>
                            <p
                                class="mt-0.5 text-[9px]
                                    text-slate-400"
                            >
                                Tasks assigned by your internship supervisor.
                            </p>
                        </div>

                        <!-- FILTER -->
                        <select
                            :value="filters.statut ?? ''"
                            @change="updateFilter"
                            class="h-[34px] min-w-[125px]
                                rounded-lg border border-slate-200
                                bg-slate-50 px-3
                                text-[10px] font-medium
                                text-slate-600
                                outline-none transition
                                focus:border-[#3A7CA5]
                                focus:bg-white
                                focus:ring-2
                                focus:ring-[#3A7CA5]/10"
                        >
                            <option value="">
                                All tasks
                            </option>
                            <!-- Backend value stays French -->
                            <option value="À faire">
                                To Do
                            </option>
                            <option value="En cours">
                                In Progress
                            </option>

                            <option value="Terminée">
                                Completed
                            </option>
                        </select>
                    </div>

                    <!-- EMPTY -->
                    <div
                        v-if="tasks.length === 0"
                        class="flex flex-col items-center
                            justify-center px-6 py-16
                            text-center"
                    >
                        <div
                            class="mb-4 flex h-14 w-14
                                items-center justify-center
                                rounded-2xl bg-[#3A7CA5]/10
                                text-[#2F6690]"
                        >
                            <svg
                                width="25"
                                height="25"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                            >
                                <path d="M9 11l3 3L22 4" />
                                <path
                                    d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"
                                />
                            </svg>
                        </div>
                        <h3
                            class="text-[14px] font-semibold
                                text-[#16425B]"
                        >
                            No tasks found
                        </h3>
                        <p
                            class="mt-1 max-w-[350px]
                                text-[10px] leading-5
                                text-slate-400"
                        >
                            No tasks match the selected filter.
                        </p>
                    </div>

                    <!-- TASK CARDS -->
                    <div
                        v-else
                        class="space-y-3 p-5"
                    >
                        <TaskCard
                            v-for="task in tasks"
                            :key="task.id"
                            :task="task"
                        />
                    </div>

                    <!-- PAGINATION -->
                    <TaskPagination
                        :links="taches?.links ?? []"
                    />
                </section>
            </div>
        </main>
    </StagiaireLayout>
</template>