<script setup>
import { computed } from 'vue'
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import ProgressHeader from '@/Components/Stagiaire/Progress/ProgressHeader.vue'
import InternshipInformation from '@/Components/Stagiaire/Progress/InternshipInformation.vue'
import ProgressStats from '@/Components/Stagiaire/Progress/ProgressStats.vue'
import TaskOverview from '@/Components/Stagiaire/Progress/TaskOverview.vue'
import WeeklyProgress from '@/Components/Stagiaire/Progress/WeeklyProgress.vue'
import EvaluationDetails from '@/Components/Stagiaire/Progress/EvaluationDetails.vue'

const props = defineProps({
    stage: {
        type: Object,
        default: null,
    },

    stats: {
        type: Object,
        default: () => ({}),
    },

    taskStatus: {
        type: Array,
        default: () => [],
    },

    taskPriority: {
        type: Array,
        default: () => [],
    },

    weeklyProgress: {
        type: Array,
        default: () => [],
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
const clampPercentage = (value) => {
    const number = Number(value ?? 0)

    return Math.min(
        100,
        Math.max(0, Math.round(number))
    )
}
const evaluation = computed(() => {
    return props.stats?.evaluation ?? null
})
const evaluationGlobal = computed(() => {
    if (
        evaluation.value?.note_global === null ||
        evaluation.value?.note_global === undefined
    ) {
        return '-'
    }
    return Number(evaluation.value.note_global).toFixed(1)
})
const taskPercentage = (value) => {
    const total = Number(props.stats?.tasks_total ?? 0)
    if (!total) {
        return 0
    }

    return Math.min(
        100,
        Math.round((Number(value ?? 0) / total) * 100)
    )
}
const statusColor = (label) => {
    const value = String(label ?? '').toLowerCase()

    if (
        value.includes('completed') ||
        value.includes('terminée') ||
        value.includes('terminé')
    ) {
        return {
            text: 'text-[#16425B]',
            bg: 'bg-[#16425B]',
            light: 'bg-[#E8F1F5]',
        }
    }

    if (
        value.includes('progress') ||
        value.includes('cours')
    ) {
        return {
            text: 'text-[#E08A00]',
            bg: 'bg-[#E08A00]',
            light: 'bg-[#FFF4DE]',
        }
    }

    if (
        value.includes('to do') ||
        value.includes('à faire')
    ) {
        return {
            text: 'text-[#D80536]',
            bg: 'bg-[#D80536]',
            light: 'bg-[#FDE8EE]',
        }
    }

    return {
        text: 'text-[#2F6690]',
        bg: 'bg-[#2F6690]',
        light: 'bg-[#E8F1F5]',
    }
}
const priorityColor = (label) => {
    const value = String(label ?? '').toLowerCase()

    if (
        value.includes('high') ||
        value.includes('haute')
    ) {
        return {
            text: 'text-[#D80536]',
            bg: 'bg-[#D80536]',
            light: 'bg-[#FDE8EE]',
        }
    }

    if (
        value.includes('medium') ||
        value.includes('moyenne')
    ) {
        return {
            text: 'text-[#E08A00]',
            bg: 'bg-[#E08A00]',
            light: 'bg-[#FFF4DE]',
        }
    }

    if (
        value.includes('low') ||
        value.includes('basse')
    ) {
        return {
            text: 'text-[#2F6690]',
            bg: 'bg-[#2F6690]',
            light: 'bg-[#E8F1F5]',
        }
    }

    return {
        text: 'text-[#64748B]',
        bg: 'bg-[#64748B]',
        light: 'bg-[#F1F5F9]',
    }
}
const RING_RADIUS = 42
const RING_CIRCUMFERENCE = 2 * Math.PI * RING_RADIUS
const stageProgressValue = computed(() => {
    return clampPercentage(props.stats?.stage_progress)
})
const ringOffset = computed(() => {
    return (
        RING_CIRCUMFERENCE -
        (stageProgressValue.value / 100) * RING_CIRCUMFERENCE
    )
})
const weeklyChart = computed(() => {
    return (props.weeklyProgress ?? []).map((week) => {
        const progress = clampPercentage(week.progress)

        let barClass = 'bg-[#D80536]'
        let textClass = 'text-[#D80536]'

        if (progress >= 75) {
            barClass = 'bg-[#16425B]'
            textClass = 'text-[#16425B]'
        } else if (progress >= 40) {
            barClass = 'bg-[#E08A00]'
            textClass = 'text-[#E08A00]'
        }

        return {
            ...week,
            progress,
            barClass,
            textClass,
        }
    })
})
</script>

<template>
    <StagiaireLayout>
        <main class="min-h-screen bg-[#F4F7F9]">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <!-- HEADER -->
                <ProgressHeader
                    :ring-radius="RING_RADIUS"
                    :ring-circumference="RING_CIRCUMFERENCE"
                    :stage-progress-value="stageProgressValue"
                    :ring-offset="ringOffset"
                />

                <!-- NO INTERNSHIP -->
                <div
                    v-if="!stage"
                    class="rounded-2xl border border-[#E2E8F0]
                    bg-white p-10 text-center shadow-sm"
                >
                    <div
                        class="mx-auto mb-4 flex h-12 w-12 items-center
                        justify-center rounded-full bg-[#E8F1F5]"
                    >
                        <svg
                            class="h-6 w-6 text-[#2F6690]"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6l4 2"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                            />
                        </svg>
                    </div>

                    <h2 class="text-[16px] font-semibold text-[#16425B]">
                        No active internship
                    </h2>

                    <p class="mt-1 text-[13px] text-[#64748B]">
                        Your internship progress will appear here once
                        you have an active internship.
                    </p>
                </div>

                <!-- CONTENT -->
                <template v-else>
                    <InternshipInformation
                        :stage="stage"
                        :format-date="formatDate"
                        :evaluation-global="evaluationGlobal"
                    />
                    <ProgressStats
                        :stats="stats"
                        :evaluation="evaluation"
                        :evaluation-global="evaluationGlobal"
                        :clamp-percentage="clampPercentage"
                    />
                    <TaskOverview
                        :task-status="taskStatus"
                        :task-priority="taskPriority"
                        :task-percentage="taskPercentage"
                        :status-color="statusColor"
                        :priority-color="priorityColor"
                    />
                    <WeeklyProgress
                        :weekly-chart="weeklyChart"
                        :format-date="formatDate"
                    />
                    <EvaluationDetails
                        :evaluation="evaluation"
                        :evaluation-global="evaluationGlobal"
                        :format-date="formatDate"
                    />
                </template>
            </div>
        </main>
    </StagiaireLayout>
</template>