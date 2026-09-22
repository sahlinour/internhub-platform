```vue
<script setup>
import { computed } from 'vue'

const props = defineProps({
    week: {
        type: Object,
        required: true,
    },

    evaluation: {
        type: Object,
        default: null,
    },
})

const formatDate = (date) => {
    if (!date) return '-'

    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    })
}

const displayStatus = (status) => {
    switch (status) {
        case 'À faire':
            return 'To Do'

        case 'En cours':
            return 'In Progress'

        case 'Terminée':
            return 'Completed'

        default:
            return status
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'Terminée':
            return 'bg-emerald-50 text-emerald-600'

        case 'En cours':
            return 'bg-blue-50 text-[#2F6690]'

        case 'À faire':
            return 'bg-amber-50 text-[#E8A33D]'

        default:
            return 'bg-slate-50 text-[#64748B]'
    }
}

const completedCount = computed(() => {
    return (props.week.tasks ?? []).filter(
        (task) => task.statut === 'Terminée'
    ).length
})

const totalCount = computed(() => {
    return (props.week.tasks ?? []).length
})

const inProgressCount = computed(() => {
    return (props.week.tasks ?? []).filter(
        (task) => task.statut === 'En cours'
    ).length
})

const pendingCount = computed(() => {
    return (props.week.tasks ?? []).filter(
        (task) => task.statut === 'À faire'
    ).length
})

const weekProgress = computed(() => {
    if (!totalCount.value) {
        return 0
    }

    return Math.round(
        (completedCount.value / totalCount.value) * 100
    )
})
</script>

<template>
    <article
        class="overflow-hidden rounded-2xl
               border border-slate-100
               bg-white
               shadow-[0_3px_12px_rgba(15,23,42,0.04)]"
    >

        <!-- ================================================= -->
        <!-- WEEK HEADER -->
        <!-- ================================================= -->

        <div
            class="border-b border-slate-100
                   px-5 py-5"
        >

            <div
                class="flex flex-col gap-4
                       md:flex-row md:items-center
                       md:justify-between"
            >

                <!-- Week -->
                <div
                    class="flex items-center gap-3"
                >

                    <div
                        class="flex h-10 w-10 shrink-0
                               items-center justify-center
                               rounded-xl
                               bg-[#E8F1F5]"
                    >
                        <span
                            class="text-[11px] font-bold
                                   text-[#2F6690]"
                        >
                            W{{ week.week }}
                        </span>
                    </div>

                    <div>
                        <h2
                            class="text-[15px]
                                   font-bold
                                   text-[#16425B]"
                        >
                            Week {{ week.week }}
                        </h2>

                        <p
                            class="mt-1 text-[10px]
                                   text-[#64748B]"
                        >
                            {{ formatDate(week.start_date) }}
                            —
                            {{ formatDate(week.end_date) }}
                        </p>
                    </div>

                </div>

                <!-- Summary -->
                <div
                    class="flex items-center gap-3"
                >

                    <span
                        class="rounded-full
                               bg-[#E8F1F5]
                               px-2.5 py-1
                               text-[9px]
                               font-semibold
                               text-[#2F6690]"
                    >
                        {{ totalCount }}
                        task{{ totalCount > 1 ? 's' : '' }}
                    </span>

                    <span
                        class="text-[11px]
                               font-bold
                               text-[#16425B]"
                    >
                        {{ weekProgress }}%
                    </span>

                </div>

            </div>

        </div>

        <!-- ================================================= -->
        <!-- PROGRESS -->
        <!-- ================================================= -->

        <div
            class="border-b border-slate-100
                   px-5 py-4"
        >

            <div
                class="mb-2 flex items-center
                       justify-between"
            >

                <span
                    class="text-[9px] font-semibold
                           text-[#64748B]"
                >
                    Weekly Progress
                </span>

                <span
                    class="text-[9px] font-bold
                           text-[#2F6690]"
                >
                    {{ completedCount }}
                    / {{ totalCount }} completed
                </span>

            </div>

            <div
                class="h-1.5 overflow-hidden
                       rounded-full
                       bg-[#E8F1F5]"
            >
                <div
                    class="h-full rounded-full
                           bg-[#3A7CA5]
                           transition-all duration-500"
                    :style="{
                        width: `${weekProgress}%`
                    }"
                ></div>
            </div>

            <!-- Task summary -->
            <div
                class="mt-3 flex flex-wrap
                       items-center gap-4"
            >

                <span
                    class="flex items-center gap-1.5
                           text-[8px]
                           text-[#64748B]"
                >
                    <span
                        class="h-1.5 w-1.5
                               rounded-full
                               bg-emerald-500"
                    ></span>

                    {{ completedCount }} Completed
                </span>

                <span
                    class="flex items-center gap-1.5
                           text-[8px]
                           text-[#64748B]"
                >
                    <span
                        class="h-1.5 w-1.5
                               rounded-full
                               bg-[#3A7CA5]"
                    ></span>

                    {{ inProgressCount }} In Progress
                </span>

                <span
                    class="flex items-center gap-1.5
                           text-[8px]
                           text-[#64748B]"
                >
                    <span
                        class="h-1.5 w-1.5
                               rounded-full
                               bg-[#E8A33D]"
                    ></span>

                    {{ pendingCount }} To Do
                </span>

            </div>

        </div>

        <!-- ================================================= -->
        <!-- DAILY ACTIVITIES -->
        <!-- ================================================= -->

        <div
            class="px-5 py-5"
        >

            <div
                class="mb-4 flex items-center
                       justify-between"
            >

                <div>
                    <p
                        class="text-[9px] font-bold
                               uppercase
                               tracking-[1.2px]
                               text-[#3A7CA5]"
                    >
                        Weekly Log
                    </p>

                    <h3
                        class="mt-1 text-[13px]
                               font-bold
                               text-[#16425B]"
                    >
                        Daily Activities
                    </h3>
                </div>

                <span
                    class="text-[9px]
                           text-[#64748B]"
                >
                    {{ totalCount }}
                    activit{{ totalCount > 1 ? 'ies' : 'y' }}
                </span>

            </div>

            <!-- Activities -->
            <div
                v-if="week.tasks?.length"
                class="space-y-2.5"
            >

                <div
                    v-for="task in week.tasks"
                    :key="task.id"
                    class="rounded-xl
                           border border-slate-100
                           bg-[#F9FBFC]
                           px-4 py-3"
                >

                    <div
                        class="flex items-start
                               gap-3"
                    >

                        <!-- Activity indicator -->
                        <div
                            class="mt-1.5 h-2 w-2
                                   shrink-0 rounded-full"
                            :class="{
                                'bg-emerald-500':
                                    task.statut === 'Terminée',

                                'bg-[#3A7CA5]':
                                    task.statut === 'En cours',

                                'bg-[#E8A33D]':
                                    task.statut === 'À faire',

                                'bg-slate-300':
                                    ![
                                        'Terminée',
                                        'En cours',
                                        'À faire'
                                    ].includes(task.statut)
                            }"
                        ></div>

                        <div
                            class="min-w-0 flex-1"
                        >

                            <div
                                class="flex flex-col
                                       gap-2
                                       sm:flex-row
                                       sm:items-start
                                       sm:justify-between"
                            >

                                <div class="min-w-0">

                                    <h4
                                        class="text-[11px]
                                               font-semibold
                                               text-[#16425B]"
                                    >
                                        {{ task.titre }}
                                    </h4>

                                    <p
                                        v-if="task.description"
                                        class="mt-1
                                               text-[9px]
                                               leading-4
                                               text-[#64748B]"
                                    >
                                        {{ task.description }}
                                    </p>

                                </div>

                                <span
                                    class="shrink-0
                                           self-start
                                           rounded-full
                                           px-2 py-1
                                           text-[8px]
                                           font-semibold"
                                    :class="
                                        statusClass(task.statut)
                                    "
                                >
                                    {{ displayStatus(task.statut) }}
                                </span>

                            </div>

                            <p
                                v-if="task.date_creation"
                                class="mt-2 text-[8px]
                                       text-slate-400"
                            >
                                {{ formatDate(task.date_creation) }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Empty -->
            <div
                v-else
                class="rounded-xl
                       border border-dashed
                       border-slate-200
                       px-5 py-7
                       text-center"
            >
                <p
                    class="text-[10px]
                           font-medium
                           text-[#64748B]"
                >
                    No activities recorded
                    for this week.
                </p>

                <p
                    class="mt-1 text-[8px]
                           text-slate-400"
                >
                    Activities will appear here
                    when tasks are created for this internship.
                </p>
            </div>

        </div>

        <!-- ================================================= -->
        <!-- SUPERVISOR COMMENT -->
        <!-- ================================================= -->

        <div
            v-if="evaluation?.remarque_encadrant"
            class="border-t border-slate-100
                   bg-[#F9FBFC]
                   px-5 py-4"
        >

            <div
                class="flex items-start gap-3"
            >

                <div
                    class="flex h-8 w-8 shrink-0
                           items-center justify-center
                           rounded-lg
                           bg-[#E8F1F5]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-[#2F6690]"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-1.9 5.4
                               A8.5 8.5 0 0 1 12 20
                               a8.38 8.38 0 0 1-4.1-1.05
                               L3 20l1.05-4.9A8.38 8.38 0 0 1
                               3 11.5 8.5 8.5 0 1 1 21 11.5Z"
                        />
                        <path d="M8 11.5h.01" />
                        <path d="M12 11.5h.01" />
                        <path d="M16 11.5h.01" />
                    </svg>
                </div>

                <div class="min-w-0">

                    <p
                        class="text-[9px] font-bold
                               uppercase
                               tracking-[1.1px]
                               text-[#3A7CA5]"
                    >
                        Supervisor Comment
                    </p>

                    <p
                        class="mt-1.5 text-[10px]
                               leading-5
                               text-[#64748B]"
                    >
                        {{ evaluation.remarque_encadrant }}
                    </p>

                    <p
                        v-if="evaluation.date_evaluation"
                        class="mt-1.5 text-[8px]
                               text-slate-400"
                    >
                        Evaluation:
                        {{ formatDate(evaluation.date_evaluation) }}
                    </p>

                </div>

            </div>

        </div>

    </article>
</template>
```
