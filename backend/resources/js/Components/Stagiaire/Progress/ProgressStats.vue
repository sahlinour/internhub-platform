<script setup>
defineProps({
    stats: {
        type: Object,
        required: true,
    },

    evaluation: {
        type: Object,
        default: null,
    },

    evaluationGlobal: {
        type: String,
        default: '-',
    },

    clampPercentage: {
        type: Function,
        required: true,
    },
})
</script>

<template>
    <section
        class="mb-5 grid grid-cols-1 gap-4
        sm:grid-cols-2 xl:grid-cols-3"
    >
        <!-- TASKS -->
        <div
            class="rounded-2xl border border-[#E2E8F0]
            bg-white p-5 shadow-sm transition-shadow
            hover:shadow-md"
        >
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-medium text-[#64748B]">
                        Tasks Completed
                    </p>

                    <p
                        class="mt-2 text-[27px] font-bold
                        leading-none text-[#16425B]"
                    >
                        {{ stats.tasks_completed ?? 0 }}

                        <span
                            class="text-[15px] font-medium
                            text-[#94A3B8]"
                        >
                            / {{ stats.tasks_total ?? 0 }}
                        </span>
                    </p>
                </div>

                <div
                    class="flex h-10 w-10 items-center
                    justify-center rounded-xl
                    bg-[#E8F1F5] text-[#2F6690]"
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"
                        />
                    </svg>
                </div>
            </div>

            <div
                class="mt-4 h-2 overflow-hidden
                rounded-full bg-[#E8F1F5]"
            >
                <div
                    class="h-full rounded-full bg-[#2F6690]
                    transition-all duration-500"
                    :style="{
                        width: `${clampPercentage(stats.tasks_progress)}%`
                    }"
                ></div>
            </div>

            <p class="mt-1.5 text-[12px] text-[#64748B]">
                {{ clampPercentage(stats.tasks_progress) }}% completed
            </p>
        </div>

        <!-- DOCUMENTS -->
        <div
            class="rounded-2xl border border-[#E2E8F0]
            bg-white p-5 shadow-sm transition-shadow
            hover:shadow-md"
        >
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-medium text-[#64748B]">
                        Documents
                    </p>

                    <p
                        class="mt-2 text-[27px] font-bold
                        leading-none text-[#16425B]"
                    >
                        {{ stats.documents_total ?? 0 }}
                    </p>
                </div>

                <div
                    class="flex h-10 w-10 items-center
                    justify-center rounded-xl
                    bg-[#E8F1F5] text-[#2F6690]"
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 2v6h6M9 13h6M9 17h6"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-4 text-[12px] text-[#64748B]">
                <span class="font-medium text-[#2F6690]">
                    {{ stats.documents_approved ?? 0 }}
                </span>
                approved
                &middot;

                <span class="font-medium text-[#E08A00]">
                    {{ stats.documents_pending ?? 0 }}
                </span>
                pending
                &middot;

                <span class="font-medium text-[#D80536]">
                    {{ stats.documents_rejected ?? 0 }}
                </span>
                rejected
            </p>
        </div>

        <!-- EVALUATION -->
        <div
            class="rounded-2xl border border-[#E2E8F0]
            bg-white p-5 shadow-sm transition-shadow
            hover:shadow-md"
        >
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-medium text-[#64748B]">
                        Global Evaluation
                    </p>

                    <p
                        class="mt-2 text-[27px] font-bold
                        leading-none text-[#16425B]"
                    >
                        {{ evaluationGlobal }}

                        <span
                            v-if="evaluation"
                            class="text-[14px] font-medium
                            text-[#94A3B8]"
                        >
                            / 10
                        </span>
                    </p>
                </div>

                <div
                    class="flex h-10 w-10 items-center
                    justify-center rounded-xl
                    bg-[#E8F1F5] text-[#2F6690]"
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 17.3l-5.4 3 1.4-6.1L3 9.9l6.2-.5L12 3.5l2.8 5.9 6.2.5-4.9 4.3 1.4 6.1z"
                        />
                    </svg>
                </div>
            </div>

            <p class="mt-4 text-[12px] text-[#64748B]">
                Latest evaluation
            </p>
        </div>
    </section>
</template>