<script setup>
import { computed } from 'vue'

const props = defineProps({
    intern: {
        type: Object,
        required: true,
    },

    index: {
        type: Number,
        default: 0,
    },
})

const emit = defineEmits([
    'view-profile',
    'assign-task',
])

const statusLabel = computed(() => {
    if (props.intern.status === 'on_track') {
        return 'On Track'
    }

    if (props.intern.status === 'at_risk') {
        return 'At Risk'
    }

    return 'Unknown'
})

const statusClass = computed(() => {
    if (props.intern.status === 'on_track') {
        return 'bg-emerald-50 text-emerald-700'
    }

    if (props.intern.status === 'at_risk') {
        return 'bg-amber-50 text-amber-700'
    }

    return 'bg-slate-100 text-slate-500'
})

const avatarClass = computed(() => {
    const classes = [
        'bg-[#17629b]',
        'bg-[#2385c4]',
        'bg-[#124f7d]',
        'bg-[#3b94c8]',
    ]

    return classes[props.index % classes.length]
})

const progress = computed(() => {
    const value = Number(props.intern.progress ?? 0)

    return Math.min(100, Math.max(0, value))
})

const progressClass = computed(() => {
    if (props.intern.status === 'at_risk') {
        return 'bg-amber-500'
    }

    return 'bg-[#17629b]'
})

const viewProfile = () => {
    emit('view-profile', props.intern)
}

const assignTask = () => {
    emit('assign-task', props.intern)
}
</script>

<template>
    <article
        class="rounded-xl border border-[#d8e8f3] bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-[#a8cde5] hover:shadow-md"
    >
        <!-- Header -->
        <div class="flex items-start justify-between gap-4">
            <div class="flex min-w-0 items-center gap-3">
                <!-- Avatar -->
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-[11px] font-bold text-white"
                    :class="avatarClass"
                >
                    {{ intern.initials || 'IN' }}
                </div>

                <!-- Intern information -->
                <div class="min-w-0">
                    <h2
                        class="truncate text-sm font-semibold text-[#124f7d]"
                    >
                        {{ intern.name }}
                    </h2>

                    <p class="mt-0.5 truncate text-xs text-slate-500">
                        {{ intern.position }}
                    </p>

                    <p class="mt-0.5 truncate text-[11px] text-slate-400">
                        {{ intern.company }}
                    </p>
                </div>
            </div>

            <!-- Status -->
            <span
                class="shrink-0 rounded-md px-2.5 py-1 text-[10px] font-semibold"
                :class="statusClass"
            >
                {{ statusLabel }}
            </span>
        </div>

        <!-- Progress -->
        <div class="mt-5">
            <div class="mb-2 flex items-center justify-between">
                <span class="text-[11px] text-slate-500">
                    Overall progress
                </span>

                <span class="text-[11px] font-bold text-[#17629b]">
                    {{ progress }}%
                </span>
            </div>

            <div
                class="h-1.5 overflow-hidden rounded-full bg-[#eaf4fb]"
                role="progressbar"
                :aria-valuenow="progress"
                aria-valuemin="0"
                aria-valuemax="100"
            >
                <div
                    class="h-full rounded-full transition-all duration-300"
                    :class="progressClass"
                    :style="{ width: `${progress}%` }"
                />
            </div>
        </div>

        <!-- Statistics -->
        <div class="mt-4 grid grid-cols-3 gap-2">
            <!-- Tasks -->
            <div class="rounded-lg bg-[#f5faff] px-3 py-3 text-center">
                <p class="text-sm font-bold text-[#17629b]">
                    {{ intern.completedTasks }}/{{ intern.totalTasks }}
                </p>

                <p class="mt-1 text-[10px] text-slate-500">
                    Tasks
                </p>
            </div>

            <!-- Logbook -->
            <div class="rounded-lg bg-[#f5faff] px-3 py-3 text-center">
                <p class="text-sm font-bold text-[#17629b]">
                    {{ intern.logbookPending }}
                </p>

                <p class="mt-1 text-[10px] text-slate-500">
                    Logbook pending
                </p>
            </div>

            <!-- Evaluation -->
            <div class="rounded-lg bg-[#f5faff] px-3 py-3 text-center">
                <p class="text-sm font-bold text-[#17629b]">
                    {{ intern.evaluation ?? '—' }}
                </p>

                <p class="mt-1 text-[10px] text-slate-500">
                    Evaluation
                </p>
            </div>
        </div>

        <!-- Skills -->
        <div
            v-if="intern.skills?.length"
            class="mt-4 flex flex-wrap gap-2"
        >
            <span
                v-for="skill in intern.skills"
                :key="skill"
                class="rounded-md bg-[#eaf4fb] px-2.5 py-1 text-[10px] font-medium text-[#17629b]"
            >
                {{ skill }}
            </span>
        </div>

        <!-- Actions -->
        <div class="mt-5 grid grid-cols-1 gap-2 sm:grid-cols-2">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-lg border border-[#17629b] bg-white px-4 py-2.5 text-xs font-semibold text-[#17629b] transition hover:bg-[#eaf4fb] focus:outline-none focus:ring-2 focus:ring-[#17629b]/30 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="!intern.stagiaireId"
                @click="viewProfile"
            >
                View Profile
            </button>

            <button
                type="button"
                class="inline-flex items-center justify-center rounded-lg bg-[#17629b] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#124f7d] focus:outline-none focus:ring-2 focus:ring-[#17629b]/30 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="!intern.id"
                @click="assignTask"
            >
                Assign Task
            </button>
        </div>
    </article>
</template>
