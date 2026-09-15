<script setup>
defineProps({
    activities: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <h2 class="mb-5 text-sm font-semibold text-gray-900">
            Activité récente
        </h2>

        <div
            v-if="activities.length"
            class="space-y-5"
        >
            <div
                v-for="activity in activities"
                :key="activity.id"
                class="flex gap-3"
            >
                <div
                    class="mt-0.5 flex h-8 w-8 shrink-0 items-center
                           justify-center rounded-lg bg-blue-50 text-blue-600"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-xs leading-5 text-gray-700">
                        {{ activity.text }}
                    </p>

                    <p class="mt-1 text-[11px] text-gray-400">
                        {{ activity.time }}
                    </p>
                </div>
            </div>
        </div>

        <div
            v-else
            class="py-8 text-center text-sm text-gray-400"
        >
            Aucune activité récente.
        </div>
    </section>
</template>
