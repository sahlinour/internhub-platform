<script setup>
defineProps({
    totalTasks: {
        type: Number,
        required: true,
    },
    pendingTasks: {
        type: Number,
        required: true,
    },
    inProgressTasks: {
        type: Number,
        required: true,
    },
    completedTasks: {
        type: Number,
        required: true,
    },
})
</script>

<template>
    <section class="mt-6">
        <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

            <!-- TOTAL TASKS -->
            <div
                class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3.5"
            >
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#16425B]/10 text-[#16425B]"
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 11l3 3L22 4" />
                        <path
                            d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"
                        />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-[10px] font-medium text-slate-500">
                        Total Tasks
                    </p>

                    <p
                        class="mt-1 text-xl font-bold leading-none text-[#16425B]"
                    >
                        {{ totalTasks }}
                    </p>
                </div>
            </div>

            <!-- TO DO -->
            <div
                class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3.5"
            >
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600"
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 3" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-[10px] font-medium text-slate-500">
                        To Do
                    </p>

                    <p
                        class="mt-1 text-xl font-bold leading-none text-[#16425B]"
                    >
                        {{ pendingTasks }}
                    </p>
                </div>
            </div>

            <!-- IN PROGRESS -->
            <div
                class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3.5"
            >
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-[#2F6690]"
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M21 12a9 9 0 1 1-3-6.7" />
                        <path d="M21 4v5h-5" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-[10px] font-medium text-slate-500">
                        In Progress
                    </p>

                    <p
                        class="mt-1 text-xl font-bold leading-none text-[#16425B]"
                    >
                        {{ inProgressTasks }}
                    </p>
                </div>
            </div>

            <!-- COMPLETED -->
            <div
                class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3.5"
            >
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600"
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-[10px] font-medium text-slate-500">
                        Completed
                    </p>

                    <p
                        class="mt-1 text-xl font-bold leading-none text-[#16425B]"
                    >
                        {{ completedTasks }}
                    </p>
                </div>
            </div>

        </div>
    </section>
</template>