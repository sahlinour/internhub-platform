<script setup>
import { computed } from 'vue'

const props = defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },
})

const progress = computed(() =>
    Math.min(100, Math.max(0, Number(props.stagiaire.progress ?? 0)))
)

const initials = computed(() => {
    const name = props.stagiaire.name ?? ''

    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(word => word.charAt(0).toUpperCase())
        .join('')
})

const statusClasses = computed(() => {
    switch (props.stagiaire.status) {
        case 'risk':
        case 'at_risk':
            return 'bg-orange-50 text-orange-600'

        case 'late':
            return 'bg-red-50 text-red-600'

        default:
            return 'bg-emerald-50 text-emerald-600'
    }
})

const statusLabel = computed(() => {
    switch (props.stagiaire.status) {
        case 'risk':
        case 'at_risk':
            return 'À risque'

        case 'late':
            return 'En retard'

        default:
            return 'En bonne voie'
    }
})
</script>

<template>
    <div
        class="rounded-xl border border-gray-200 bg-white p-4
               transition hover:shadow-md"
    >
        <div class="flex items-start justify-between gap-3">
            <div class="flex min-w-0 items-center gap-3">

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center
                           rounded-full bg-[#17629b] text-xs font-bold text-white"
                >
                    {{ initials }}
                </div>

                <div class="min-w-0">
                    <h3 class="truncate text-sm font-semibold text-gray-900">
                        {{ stagiaire.name }}
                    </h3>

                    <p class="truncate text-xs text-gray-400">
                        {{ stagiaire.filiere }}
                    </p>
                </div>
            </div>

            <span
                class="shrink-0 rounded-md px-2 py-1 text-[10px] font-semibold"
                :class="statusClasses"
            >
                {{ statusLabel }}
            </span>
        </div>

        <div class="mt-5">
            <div class="mb-2 flex justify-between text-xs">
                <span class="text-gray-500">Progression</span>

                <span class="font-semibold text-gray-700">
                    {{ progress }}%
                </span>
            </div>

            <div class="h-1.5 overflow-hidden rounded-full bg-gray-100">
                <div
                    class="h-full rounded-full bg-[#17629b] transition-all"
                    :style="{ width: `${progress}%` }"
                />
            </div>
        </div>

        <div
            class="mt-4 flex items-center justify-between
                   border-t border-gray-100 pt-3 text-xs text-gray-400"
        >
            <span>
                {{ stagiaire.completedTasks ?? 0 }}/{{ stagiaire.totalTasks ?? 0 }}
                tâches
            </span>

            <span>
                {{ stagiaire.lastActivity ?? '' }}
            </span>
        </div>
    </div>
</template>
