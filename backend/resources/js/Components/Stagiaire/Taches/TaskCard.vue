<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
})

const task = computed(() => props.task)

const formatDate = (date) => {
    if (!date) {
        return '—'
    }

    const parsedDate = new Date(date)

    if (Number.isNaN(parsedDate.getTime())) {
        return date
    }

    return parsedDate.toLocaleDateString('en-GB', {
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

const displayPriority = (priority) => {
    switch (priority) {
        case 'Haute':
            return 'High'

        case 'Moyenne':
            return 'Medium'

        case 'Basse':
            return 'Low'

        default:
            return priority
    }
}

const priorityDot = (priority) => {
    switch (priority) {
        case 'Haute':
            return 'bg-[#D80536]'

        case 'Moyenne':
            return 'bg-[#E8A33D]'

        case 'Basse':
            return 'bg-[#3A7CA5]'

        default:
            return 'bg-slate-300'
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'Terminée':
            return 'bg-emerald-50 text-emerald-600'

        case 'En cours':
            return 'bg-[#3A7CA5]/10 text-[#2F6690]'

        case 'À faire':
            return 'bg-[#E8A33D]/10 text-[#B7791F]'

        default:
            return 'bg-slate-100 text-slate-500'
    }
}

const updateTaskStatus = () => {
    let newStatus = task.value.statut

    if (task.value.statut === 'À faire') {
        newStatus = 'En cours'
    } else if (task.value.statut === 'En cours') {
        newStatus = 'Terminée'
    }

    if (newStatus === task.value.statut) {
        return
    }

    router.patch(
        route('stagiaire.taches.updateStatus', task.value.id),
        {
            statut: newStatus,
        },
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <article
        class="group relative rounded-xl border border-slate-200 bg-white transition-all duration-200 hover:border-[#3A7CA5]/40 hover:shadow-[0_6px_20px_rgba(22,66,91,0.07)]"
    >
        <div
            class="flex flex-col gap-4 p-4 lg:flex-row lg:items-center"
        >

            <!-- LEFT : TASK MAIN INFO -->

            <div class="min-w-0 flex-1">

                <!-- TOP -->

                <div class="flex items-center gap-2">

                    <!-- STATUS -->

                    <span
                        class="inline-flex items-center gap-1.5 rounded-md px-2 py-1 text-[8px] font-bold"
                        :class="statusClass(task.statut)"
                    >
                        <span
                            class="h-1.5 w-1.5 rounded-full"
                            :class="
                                task.statut === 'Terminée'
                                    ? 'bg-emerald-500'
                                    : task.statut === 'En cours'
                                        ? 'bg-[#3A7CA5]'
                                        : 'bg-[#E8A33D]'
                            "
                        ></span>

                        {{ displayStatus(task.statut) }}
                    </span>

                    <!-- PRIORITY -->

                    <span
                        v-if="task.priorite"
                        class="inline-flex items-center gap-1.5 text-[8px] font-semibold"
                        :class="
                            task.priorite === 'Haute'
                                ? 'text-[#D80536]'
                                : task.priorite === 'Moyenne'
                                    ? 'text-[#B7791F]'
                                    : 'text-[#2F6690]'
                        "
                    >
                        <span
                            class="h-1.5 w-1.5 rounded-full"
                            :class="priorityDot(task.priorite)"
                        ></span>

                        {{ displayPriority(task.priorite) }}
                    </span>

                </div>

                <!-- TITLE -->

                <h3
                    class="mt-2 text-[14px] font-bold text-[#16425B] transition-colors group-hover:text-[#2F6690]"
                >
                    {{ task.titre }}
                </h3>

                <!-- DESCRIPTION -->

                <p
                    v-if="task.description"
                    class="mt-1 line-clamp-1 max-w-[650px] text-[10px] leading-5 text-slate-500"
                >
                    {{ task.description }}
                </p>

            </div>

            <!-- CENTER : TASK DETAILS -->

            <div
                class="flex shrink-0 items-center gap-6 border-t border-slate-100 pt-3 lg:border-l lg:border-t-0 lg:pl-6 lg:pt-0"
            >

                <!-- DUE DATE -->

                <div class="min-w-[95px]">
                    <p
                        class="text-[8px] font-semibold uppercase tracking-wide text-slate-400"
                    >
                        Due Date
                    </p>

                    <div class="mt-1 flex items-center gap-1.5">
                        <svg
                            width="13"
                            height="13"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-[#3A7CA5]"
                        >
                            <rect
                                x="3"
                                y="4"
                                width="18"
                                height="18"
                                rx="2"
                            />

                            <line
                                x1="16"
                                y1="2"
                                x2="16"
                                y2="6"
                            />

                            <line
                                x1="8"
                                y1="2"
                                x2="8"
                                y2="6"
                            />

                            <line
                                x1="3"
                                y1="10"
                                x2="21"
                                y2="10"
                            />
                        </svg>

                        <span
                            class="text-[9px] font-semibold text-[#16425B]"
                        >
                            {{ formatDate(task.date_echeance) }}
                        </span>
                    </div>
                </div>

                <!-- CREATED -->

                <div class="min-w-[95px]">
                    <p
                        class="text-[8px] font-semibold uppercase tracking-wide text-slate-400"
                    >
                        Created
                    </p>

                    <div class="mt-1 flex items-center gap-1.5">
                        <svg
                            width="13"
                            height="13"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-slate-400"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                            />

                            <path d="M12 7v5l3 2" />
                        </svg>

                        <span
                            class="text-[9px] font-medium text-slate-600"
                        >
                            {{ formatDate(task.date_creation) }}
                        </span>
                    </div>
                </div>

                <!-- SUPERVISOR -->

                <div
                    v-if="task.encadrant?.user"
                    class="hidden min-w-[130px] xl:block"
                >
                    <p
                        class="text-[8px] font-semibold uppercase tracking-wide text-slate-400"
                    >
                        Supervisor
                    </p>

                    <div class="mt-1 flex items-center gap-2">
                        <div
                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#81C3D7]/20 text-[8px] font-bold text-[#2F6690]"
                        >
                            {{
                                task.encadrant.user.nom_complet
                                    ?.charAt(0)
                                    ?.toUpperCase()
                            }}
                        </div>

                        <span
                            class="max-w-[100px] truncate text-[9px] font-medium text-slate-600"
                        >
                            {{ task.encadrant.user.nom_complet }}
                        </span>
                    </div>
                </div>

            </div>

            <!-- RIGHT : ACTION -->

            <div
                class="flex shrink-0 items-center justify-between gap-3 border-t border-slate-100 pt-3 lg:justify-end lg:border-t-0 lg:pt-0"
            >

                <!-- ID -->

                <span
                    class="rounded-md bg-slate-50 px-2 py-1 text-[8px] font-semibold text-slate-400"
                >
                    #{{ task.id }}
                </span>

                <!-- BUTTON -->

                <button
                    v-if="task.statut !== 'Terminée'"
                    type="button"
                    @click="updateTaskStatus"
                    class="rounded-lg bg-[#16425B] px-3.5 py-2 text-[9px] font-semibold text-white transition hover:bg-[#2F6690] active:scale-[0.97]"
                >
                    {{
                        task.statut === 'À faire'
                            ? 'Start Task'
                            : 'Mark as Completed'
                    }}
                </button>

                <!-- COMPLETED -->

                <span
                    v-else
                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-3 py-2 text-[9px] font-semibold text-emerald-600"
                >
                    <span
                        class="h-1.5 w-1.5 rounded-full bg-emerald-500"
                    ></span>

                    Completed
                </span>

            </div>

        </div>

        <!-- BOTTOM PROGRESS LINE -->

        <div class="h-[2px] w-full bg-slate-100">
            <div
                class="h-full transition-all"
                :class="
                    task.statut === 'Terminée'
                        ? 'bg-emerald-500'
                        : task.statut === 'En cours'
                            ? 'bg-[#3A7CA5]'
                            : 'bg-[#E8A33D]'
                "
                :style="
                    task.statut === 'Terminée'
                        ? { width: '100%' }
                        : task.statut === 'En cours'
                            ? { width: '50%' }
                            : { width: '15%' }
                "
            ></div>
        </div>
    </article>
</template>