```vue
<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
    stage: {
        type: Object,
        default: null,
    },

    weeklyTasks: {
        type: Array,
        default: () => [],
    },

    availableTasks: {
        type: Array,
        default: () => [],
    },

    show: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['close', 'save'])

const selectedTasks = ref([])

const formatDate = (date) => {
    if (!date) return '-'

    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    })
}

/*
|--------------------------------------------------------------------------
| LAST WEEK
|--------------------------------------------------------------------------
*/

const lastWeek = computed(() => {
    if (!props.weeklyTasks.length) {
        return null
    }

    return props.weeklyTasks[props.weeklyTasks.length - 1]
})

/*
|--------------------------------------------------------------------------
| NEXT WEEK
|--------------------------------------------------------------------------
*/

const nextWeek = computed(() => {
    if (!lastWeek.value) {
        return {
            week: 1,
            start_date: props.stage?.date_debut,
            end_date: calculateWeekEnd(
                props.stage?.date_debut,
                props.stage?.date_fin
            ),
            tasks: [],
        }
    }

    const nextStart = new Date(lastWeek.value.end_date)
    nextStart.setDate(nextStart.getDate() + 1)

    const nextEnd = new Date(nextStart)
    nextEnd.setDate(nextEnd.getDate() + 6)

    const internshipEnd = new Date(props.stage.date_fin)

    if (nextEnd > internshipEnd) {
        nextEnd.setTime(internshipEnd.getTime())
    }

    return {
        week: lastWeek.value.week + 1,
        start_date: toDateString(nextStart),
        end_date: toDateString(nextEnd),
        tasks: [],
    }
})

/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

const toDateString = (date) => {
    return date.toISOString().split('T')[0]
}

const calculateWeekEnd = (startDate, internshipEnd) => {
    if (!startDate) return null

    const start = new Date(startDate)

    const end = new Date(start)
    end.setDate(end.getDate() + 6)

    if (internshipEnd) {
        const maxDate = new Date(internshipEnd)

        if (end > maxDate) {
            return toDateString(maxDate)
        }
    }

    return toDateString(end)
}

/*
|--------------------------------------------------------------------------
| TASK SELECTION
|--------------------------------------------------------------------------
*/

const isTaskSelected = (taskId) => {
    return selectedTasks.value.includes(taskId)
}

const toggleTask = (taskId) => {
    if (isTaskSelected(taskId)) {
        selectedTasks.value = selectedTasks.value.filter(
            id => id !== taskId
        )

        return
    }

    selectedTasks.value.push(taskId)
}

/*
|--------------------------------------------------------------------------
| SAVE
|--------------------------------------------------------------------------
*/

const saveWeeklyEntry = () => {
    emit('save', {
        week: nextWeek.value.week,
        start_date: nextWeek.value.start_date,
        end_date: nextWeek.value.end_date,
        task_ids: selectedTasks.value,
    })
}

/*
|--------------------------------------------------------------------------
| CLOSE
|--------------------------------------------------------------------------
*/

const closeModal = () => {
    selectedTasks.value = []
    emit('close')
}

/*
|--------------------------------------------------------------------------
| STATUS
|--------------------------------------------------------------------------
*/

const displayStatus = (status) => {
    switch (status) {
        case 'À faire':
            return 'To Do'

        case 'En cours':
            return 'In Progress'

        case 'Terminée':
            return 'Completed'

        default:
            return status || '-'
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
</script>

<template>
    <Teleport to="body">
        <div
            v-if="show && stage"
            class="fixed inset-0 z-[100]
                   flex items-center justify-center
                   bg-[#16425B]/30
                   px-4 py-6
                   backdrop-blur-[2px]"
            @click.self="closeModal"
        >

            <div
                class="w-full max-w-[620px]
                       overflow-hidden
                       rounded-2xl
                       border border-slate-100
                       bg-white
                       shadow-[0_20px_60px_rgba(16,46,65,0.18)]"
            >

                <!-- HEADER -->

                <div
                    class="flex items-start
                           justify-between
                           border-b border-slate-100
                           px-5 py-4"
                >

                    <div>

                        <h2
                            class="text-[14px]
                                   font-bold
                                   text-[#16425B]"
                        >
                            New Weekly Entry
                        </h2>

                        <p
                            class="mt-0.5
                                   text-[9px]
                                   text-slate-400"
                        >
                            Select the activities completed during this week.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="flex h-7 w-7
                               items-center justify-center
                               rounded-[7px]
                               text-slate-400
                               transition
                               hover:bg-slate-50
                               hover:text-[#16425B]"
                        @click="closeModal"
                    >

                        <svg
                            width="15"
                            height="15"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M6 6l12 12" />
                            <path d="M18 6L6 18" />
                        </svg>

                    </button>

                </div>

                <!-- CONTENT -->

                <div class="p-5">

                    <!-- INTERNSHIP -->

                    <div
                        class="mb-4 rounded-xl
                               border border-[#E8F1F5]
                               bg-[#F9FBFC]
                               px-4 py-3"
                    >

                        <p
                            class="text-[8px]
                                   font-bold uppercase
                                   tracking-[1px]
                                   text-[#3A7CA5]"
                        >
                            Current Internship
                        </p>

                        <h3
                            class="mt-1 text-[12px]
                                   font-bold
                                   text-[#16425B]"
                        >
                            {{ stage.sujet }}
                        </h3>

                        <p
                            class="mt-1 text-[9px]
                                   text-[#64748B]"
                        >
                            {{ formatDate(stage.date_debut) }}
                            —
                            {{ formatDate(stage.date_fin) }}
                        </p>

                    </div>

                    <!-- NEXT WEEK -->

                    <div
                        class="mb-4 rounded-xl
                               bg-[#E8F1F5]
                               px-4 py-3"
                    >

                        <div
                            class="flex items-center
                                   justify-between"
                        >

                            <div>

                                <p
                                    class="text-[13px]
                                           font-bold
                                           text-[#16425B]"
                                >
                                    Week {{ nextWeek.week }}
                                </p>

                                <p
                                    class="mt-1 text-[9px]
                                           text-[#64748B]"
                                >
                                    {{ formatDate(nextWeek.start_date) }}
                                    —
                                    {{ formatDate(nextWeek.end_date) }}
                                </p>

                            </div>

                            <span
                                class="rounded-full
                                       bg-white
                                       px-2.5 py-1
                                       text-[8px]
                                       font-semibold
                                       text-[#2F6690]"
                            >
                                New Week
                            </span>

                        </div>

                    </div>

                    <!-- PREVIOUS WEEK -->

                    <div
                        v-if="lastWeek"
                        class="mb-5 rounded-xl
                               border border-slate-100
                               bg-white
                               px-4 py-3"
                    >

                        <p
                            class="text-[8px]
                                   font-bold uppercase
                                   tracking-[1px]
                                   text-slate-400"
                        >
                            Previous Week
                        </p>

                        <div
                            class="mt-1 flex items-center
                                   justify-between"
                        >

                            <p
                                class="text-[10px]
                                       font-semibold
                                       text-[#16425B]"
                            >
                                Week {{ lastWeek.week }}
                            </p>

                            <p
                                class="text-[8px]
                                       text-[#64748B]"
                            >
                                {{ formatDate(lastWeek.start_date) }}
                                —
                                {{ formatDate(lastWeek.end_date) }}
                            </p>

                        </div>

                    </div>

                    <!-- TASKS -->

                    <div>

                        <div
                            class="mb-3 flex items-center
                                   justify-between"
                        >

                            <div>

                                <p
                                    class="text-[9px]
                                           font-bold uppercase
                                           tracking-[1px]
                                           text-[#16425B]"
                                >
                                    Available Activities
                                </p>

                                <p
                                    class="mt-1 text-[8px]
                                           text-[#94A3B8]"
                                >
                                    Select the tasks assigned by your supervisor.
                                </p>

                            </div>

                            <span
                                class="text-[8px]
                                       font-semibold
                                       text-[#2F6690]"
                            >
                                {{ selectedTasks.length }} selected
                            </span>

                        </div>

                        <!-- TASK LIST -->

                        <div
                            v-if="availableTasks.length"
                            class="max-h-[280px]
                                   space-y-2
                                   overflow-y-auto
                                   pr-1"
                        >

                            <button
                                v-for="task in availableTasks"
                                :key="task.id"
                                type="button"
                                class="w-full rounded-xl
                                       border px-4 py-3
                                       text-left
                                       transition"
                                :class="
                                    isTaskSelected(task.id)
                                        ? 'border-[#81C3D7] bg-[#F4F9FB]'
                                        : 'border-slate-100 bg-[#F9FBFC] hover:border-[#81C3D7]'
                                "
                                @click="toggleTask(task.id)"
                            >

                                <div
                                    class="flex items-start
                                           gap-3"
                                >

                                    <!-- CHECKBOX -->

                                    <div
                                        class="mt-0.5 flex h-4 w-4
                                               shrink-0 items-center
                                               justify-center
                                               rounded border"
                                        :class="
                                            isTaskSelected(task.id)
                                                ? 'border-[#2F6690] bg-[#2F6690]'
                                                : 'border-slate-300 bg-white'
                                        "
                                    >

                                        <svg
                                            v-if="isTaskSelected(task.id)"
                                            class="h-2.5 w-2.5 text-white"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="3"
                                        >
                                            <path d="m5 12 4 4L19 6" />
                                        </svg>

                                    </div>

                                    <!-- TASK -->

                                    <div class="min-w-0 flex-1">

                                        <div
                                            class="flex items-start
                                                   justify-between
                                                   gap-3"
                                        >

                                            <h4
                                                class="text-[10px]
                                                       font-semibold
                                                       text-[#16425B]"
                                            >
                                                {{ task.titre }}
                                            </h4>

                                            <span
                                                class="shrink-0
                                                       rounded-full
                                                       px-2 py-1
                                                       text-[7px]
                                                       font-semibold"
                                                :class="statusClass(task.statut)"
                                            >
                                                {{ displayStatus(task.statut) }}
                                            </span>

                                        </div>

                                        <p
                                            v-if="task.description"
                                            class="mt-1 text-[8px]
                                                   leading-4
                                                   text-[#64748B]"
                                        >
                                            {{ task.description }}
                                        </p>

                                        <p
                                            v-if="task.date_creation"
                                            class="mt-1.5 text-[8px]
                                                   text-slate-400"
                                        >
                                            Created:
                                            {{ formatDate(task.date_creation) }}
                                        </p>

                                    </div>

                                </div>

                            </button>

                        </div>

                        <!-- NO TASKS -->

                        <div
                            v-else
                            class="rounded-xl
                                   border border-dashed
                                   border-slate-200
                                   px-5 py-8
                                   text-center"
                        >

                            <p
                                class="text-[10px]
                                       font-medium
                                       text-[#64748B]"
                            >
                                No tasks are available.
                            </p>

                            <p
                                class="mt-1 text-[8px]
                                       text-slate-400"
                            >
                                Tasks assigned by your supervisor
                                will appear here.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- FOOTER -->

                <div
                    class="flex items-center
                           justify-end gap-2
                           border-t border-slate-100
                           px-5 py-4"
                >

                    <button
                        type="button"
                        class="rounded-[7px]
                               border border-slate-200
                               bg-white
                               px-4 py-2
                               text-[10px]
                               font-semibold
                               text-slate-500
                               transition
                               hover:bg-slate-50
                               hover:text-[#16425B]"
                        @click="closeModal"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        :disabled="!selectedTasks.length"
                        class="rounded-[7px]
                               bg-[#2F6690]
                               px-4 py-2
                               text-[10px]
                               font-semibold
                               text-white
                               transition
                               hover:bg-[#16425B]
                               disabled:cursor-not-allowed
                               disabled:opacity-40"
                        @click="saveWeeklyEntry"
                    >
                        Save Weekly Entry
                    </button>

                </div>

            </div>

        </div>
    </Teleport>
</template>
```
