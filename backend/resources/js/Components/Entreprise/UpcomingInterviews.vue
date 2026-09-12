<script setup>
defineProps({
    interviews: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <div
        class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm"
    >
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-[13px] font-semibold text-gray-800">
                    Upcoming Interviews
                </h2>

                <p class="mt-1 text-[9px] text-gray-400">
                    Interviews scheduled soon
                </p>
            </div>

            <button
                type="button"
                class="text-[9px] font-semibold text-[#2d7da0] hover:underline"
            >
                View Calendar
            </button>
        </div>

        <!-- Empty -->
        <div
            v-if="interviews.length === 0"
            class="flex min-h-[150px] flex-col items-center justify-center text-center"
        >
            <div
                class="flex h-11 w-11 items-center justify-center rounded-full bg-gray-50 text-gray-400"
            >
                <svg
                    viewBox="0 0 24 24"
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                >
                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="16"
                        rx="2"
                    />
                    <path d="M16 3v4M8 3v4M3 10h18" />
                </svg>
            </div>

            <p class="mt-3 text-[10px] font-semibold text-gray-600">
                No interviews scheduled
            </p>

            <p class="mt-1 text-[8px] text-gray-400">
                Scheduled interviews will appear here.
            </p>
        </div>

        <!-- List -->
        <div v-else class="mt-4 space-y-3">
            <div
                v-for="interview in interviews"
                :key="interview.id"
                class="flex items-start gap-3 rounded-lg border border-gray-100 bg-gray-50/60 p-3"
            >
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#e8f3f7] text-[#286f8e]"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="5"
                            width="18"
                            height="16"
                            rx="2"
                        />
                        <path d="M16 3v4M8 3v4M3 10h18" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="truncate text-[10px] font-semibold text-gray-700">
                        {{ interview.student }}
                    </p>

                    <p
                        v-if="interview.type"
                        class="mt-1 truncate text-[8px] text-gray-400"
                    >
                        {{ interview.type }}
                    </p>

                    <p
                        class="mt-1.5 text-[8px] font-medium text-[#2d7da0]"
                    >
                        {{ interview.date }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
