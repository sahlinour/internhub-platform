<script setup>
const props = defineProps({
    tasks: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['review'])

const priorityClass = priority => {
    switch (priority?.toLowerCase()) {
        case 'high':
        case 'haute':
            return 'bg-red-50 text-red-600'

        case 'medium':
        case 'moyenne':
            return 'bg-orange-50 text-orange-600'

        default:
            return 'bg-emerald-50 text-emerald-600'
    }
}

const priorityLabel = priority => {
    switch (priority?.toLowerCase()) {
        case 'high':
            return 'Haute'

        case 'medium':
            return 'Moyenne'

        case 'low':
            return 'Faible'

        default:
            return priority ?? 'Normale'
    }
}
</script>

<template>
    <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-semibold text-gray-900">
                    Tâches en attente de validation
                </h2>

                <p class="mt-1 text-xs text-gray-400">
                    Travaux en attente de votre retour
                </p>
            </div>

            <button
                type="button"
                class="text-xs font-semibold text-[#17629b] hover:underline"
            >
                Tout voir
            </button>
        </div>

        <div v-if="tasks.length">
            <div
                v-for="task in tasks"
                :key="task.id"
                class="flex flex-col gap-3 border-t border-gray-100 py-4
                       first:border-t-0 sm:flex-row sm:items-center
                       sm:justify-between"
            >
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-gray-800">
                        {{ task.title }}
                    </p>

                    <p class="mt-1 text-xs text-gray-400">
                        {{ task.stagiaire }}
                        <span v-if="task.date">
                            · {{ task.date }}
                        </span>
                    </p>
                </div>

                <div class="flex shrink-0 items-center gap-3">
                    <span
                        class="rounded-md px-2.5 py-1 text-[10px] font-semibold"
                        :class="priorityClass(task.priority)"
                    >
                        {{ priorityLabel(task.priority) }}
                    </span>

                    <button
                        type="button"
                        class="rounded-md border border-gray-200 px-3 py-1.5
                               text-xs font-medium text-gray-600
                               transition hover:bg-gray-50"
                        @click="emit('review', task)"
                    >
                        Examiner
                    </button>
                </div>
            </div>
        </div>

        <div
            v-else
            class="py-8 text-center text-sm text-gray-400"
        >
            Aucune tâche à valider.
        </div>
    </section>
</template>
