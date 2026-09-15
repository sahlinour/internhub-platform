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

/*
|--------------------------------------------------------------------------
| Status
|--------------------------------------------------------------------------
*/
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
        return 'bg-emerald-50 text-emerald-600'
    }

    if (props.intern.status === 'at_risk') {
        return 'bg-amber-50 text-amber-600'
    }

    return 'bg-slate-100 text-slate-500'
})

/*
|--------------------------------------------------------------------------
| Avatar
|--------------------------------------------------------------------------
*/
const avatarClass = computed(() => {
    const classes = [
        'bg-blue-600',
        'bg-violet-600',
        'bg-rose-500',
        'bg-emerald-600',
    ]

    return classes[props.index % classes.length]
})
</script>

<template>
    <article
        class="rounded-xl border border-slate-200
               bg-white p-5 shadow-sm
               transition-all duration-200
               hover:-translate-y-0.5 hover:shadow-md"
    >

        <!-- Header -->
        <div class="flex items-start justify-between gap-4">

            <div class="flex min-w-0 items-center gap-3">

                <!-- Avatar -->
                <div
                    class="flex h-11 w-11 shrink-0
                           items-center justify-center
                           rounded-full text-[11px]
                           font-bold text-white"
                    :class="avatarClass"
                >
                    {{ intern.initials }}
                </div>

                <!-- Intern information -->
                <div class="min-w-0">

                    <h2
                        class="truncate text-sm
                               font-semibold text-slate-800"
                    >
                        {{ intern.name }}
                    </h2>

                    <p
                        class="mt-0.5 truncate
                               text-xs text-slate-500"
                    >
                        {{ intern.position }}
                    </p>

                    <p
                        class="mt-0.5 truncate
                               text-[11px] text-slate-400"
                    >
                        {{ intern.company }}
                    </p>

                </div>
            </div>

            <!-- Status -->
            <span
                class="shrink-0 rounded-md
                       px-2.5 py-1 text-[10px]
                       font-semibold"
                :class="statusClass"
            >
                {{ statusLabel }}
            </span>

        </div>

        <!-- Progress -->
        <div class="mt-5">

            <div
                class="mb-2 flex items-center
                       justify-between"
            >
                <span class="text-[11px] text-slate-500">
                    Overall progress
                </span>

                <span
                    class="text-[11px]
                           font-bold text-slate-700"
                >
                    {{ intern.progress }}%
                </span>
            </div>

            <div
                class="h-1.5 overflow-hidden
                       rounded-full bg-slate-100"
            >
                <div
                    class="h-full rounded-full
                           bg-[#17629b]
                           transition-all duration-300"
                    :style="{
                        width: `${intern.progress}%`
                    }"
                />
            </div>

        </div>

        <!-- Statistics -->
        <div class="mt-4 grid grid-cols-3 gap-2">

            <!-- Tasks -->
            <div
                class="rounded-lg bg-slate-50
                       px-3 py-3 text-center"
            >
                <p
                    class="text-sm font-bold
                           text-slate-800"
                >
                    {{ intern.completedTasks }}/{{ intern.totalTasks }}
                </p>

                <p
                    class="mt-1 text-[10px]
                           text-slate-400"
                >
                    Tasks
                </p>
            </div>

            <!-- Logbook -->
            <div
                class="rounded-lg bg-slate-50
                       px-3 py-3 text-center"
            >
                <p
                    class="text-sm font-bold
                           text-slate-800"
                >
                    {{ intern.logbookPending }}
                </p>

                <p
                    class="mt-1 text-[10px]
                           text-slate-400"
                >
                    Logbook pending
                </p>
            </div>

            <!-- Evaluation -->
            <div
                class="rounded-lg bg-slate-50
                       px-3 py-3 text-center"
            >
                <p
                    class="text-sm font-bold
                           text-slate-800"
                >
                    {{ intern.evaluation ?? '—' }}
                </p>

                <p
                    class="mt-1 text-[10px]
                           text-slate-400"
                >
                    Eval score
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
                class="rounded-md bg-slate-100
                       px-2.5 py-1 text-[10px]
                       font-medium text-slate-600"
            >
                {{ skill }}
            </span>
        </div>

        <!-- Actions -->
        <div class="mt-5 grid grid-cols-2 gap-2">

            <button
                type="button"
                class="rounded-lg border
                       border-slate-200 bg-white
                       px-4 py-2.5 text-xs
                       font-semibold text-slate-700
                       transition
                       hover:border-slate-300
                       hover:bg-slate-50"
                @click="emit('view-profile', intern)"
            >
                View Profile
            </button>

            <button
                type="button"
                class="rounded-lg bg-slate-900
                       px-4 py-2.5 text-xs
                       font-semibold text-white
                       transition hover:bg-slate-800"
                @click="emit('assign-task', intern)"
            >
                Assign Task
            </button>

        </div>

    </article>
</template>
