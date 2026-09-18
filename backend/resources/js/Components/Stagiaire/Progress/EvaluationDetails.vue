<script setup>
defineProps({
    evaluation: {
        type: Object,
        default: null,
    },

    evaluationGlobal: {
        type: String,
        default: '-',
    },

    formatDate: {
        type: Function,
        required: true,
    },
})
</script>

<template>
    <section
        v-if="evaluation"
        class="overflow-hidden rounded-2xl
        border border-[#E2E8F0] bg-white
        shadow-[0_4px_18px_rgba(22,66,91,0.05)]"
    >
        <!-- HEADER -->
        <div
            class="flex flex-col justify-between gap-3
            border-b border-[#EEF2F6]
            bg-[#F8FAFC] px-5 py-4
            sm:flex-row sm:items-center"
        >
            <div class="flex items-center gap-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-xl
                    bg-[#E8F1F5] text-[#2F6690]"
                >
                    <svg
                        class="h-[18px] w-[18px]"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3l-5.6 2.9 1.1-6.2L3 9.6l6.2-.9L12 3z"
                        />
                    </svg>
                </div>

                <div>
                    <h3
                        class="text-[14px] font-bold
                        text-[#16425B]"
                    >
                        Latest Evaluation
                    </h3>

                    <p
                        class="mt-0.5 text-[10.5px]
                        text-[#64748B]"
                    >
                        Evaluation provided by your supervisor.
                    </p>
                </div>
            </div>

            <span
                class="self-start rounded-full
                border border-[#E2E8F0]
                bg-white px-3 py-1.5
                text-[10px] font-medium text-[#64748B]
                sm:self-auto"
            >
                {{ formatDate(evaluation.date_evaluation) }}
            </span>
        </div>

        <!-- SCORE AREA -->
        <div class="grid grid-cols-1 lg:grid-cols-[190px_1fr]">

            <!-- GLOBAL SCORE -->
            <div
                class="flex flex-col items-center
                justify-center border-b border-[#EEF2F6]
                bg-gradient-to-br from-[#16425B] to-[#2F6690]
                px-5 py-7 text-white
                lg:border-b-0 lg:border-r"
            >
                <p
                    class="text-[9px] font-bold uppercase
                    tracking-[1.4px] text-[#81C3D7]"
                >
                    Global Score
                </p>

                <div
                    class="mt-2 flex items-baseline
                    justify-center"
                >
                    <span
                        class="text-[40px] font-bold
                        leading-none tracking-[-1px]"
                    >
                        {{ evaluationGlobal }}
                    </span>

                    <span
                        class="ml-1 text-[13px]
                        font-medium text-white/60"
                    >
                        / 10
                    </span>
                </div>

                <div
                    class="mt-4 h-1.5 w-24 overflow-hidden
                    rounded-full bg-white/15"
                >
                    <div
                        class="h-full rounded-full
                        bg-[#81C3D7]"
                        :style="{
                            width: `${
                                Math.min(
                                    100,
                                    Math.max(
                                        0,
                                        Number(evaluation.note_global ?? 0) * 10
                                    )
                                )
                            }%`
                        }"
                    ></div>
                </div>
            </div>

            <!-- CRITERIA -->
            <div class="p-5">

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                    <!-- TECHNICAL -->
                    <div
                        class="rounded-xl border
                        border-[#E2E8F0] bg-white
                        p-4"
                    >
                        <div
                            class="flex items-center
                            justify-between"
                        >
                            <div class="flex items-center gap-2">

                                <span
                                    class="flex h-7 w-7
                                    items-center justify-center
                                    rounded-lg bg-[#E8F1F5]
                                    text-[#2F6690]"
                                >
                                    <svg
                                        class="h-3.5 w-3.5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M14.7 6.3a4.5 4.5 0 0 0-5.9 5.9L3 18v3h3l5.8-5.8a4.5 4.5 0 0 0 5.9-5.9l-2.3 2.3-2.2-.7-.7-2.2 2.2-2.4z"
                                        />
                                    </svg>
                                </span>

                                <span
                                    class="text-[11px]
                                    font-semibold text-[#64748B]"
                                >
                                    Technical
                                </span>
                            </div>

                            <span
                                class="text-[9px]
                                text-[#94A3B8]"
                            >
                                / 10
                            </span>
                        </div>

                        <p
                            class="mt-4 text-[25px]
                            font-bold leading-none
                            text-[#16425B]"
                        >
                            {{ evaluation.note_technique ?? '-' }}
                        </p>

                        <div
                            class="mt-3 h-1.5 overflow-hidden
                            rounded-full bg-[#E8F1F5]"
                        >
                            <div
                                class="h-full rounded-full
                                bg-[#2F6690]"
                                :style="{
                                    width: `${
                                        Math.min(
                                            100,
                                            Math.max(
                                                0,
                                                Number(
                                                    evaluation.note_technique ?? 0
                                                ) * 10
                                            )
                                        )
                                    }%`
                                }"
                            ></div>
                        </div>
                    </div>

                    <!-- RELATIONAL -->
                    <div
                        class="rounded-xl border
                        border-[#E2E8F0] bg-white
                        p-4"
                    >
                        <div
                            class="flex items-center
                            justify-between"
                        >
                            <div class="flex items-center gap-2">

                                <span
                                    class="flex h-7 w-7
                                    items-center justify-center
                                    rounded-lg bg-[#E8F1F5]
                                    text-[#2F6690]"
                                >
                                    <svg
                                        class="h-3.5 w-3.5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <circle
                                            cx="9"
                                            cy="8"
                                            r="3"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3.5 20a5.5 5.5 0 0 1 11 0"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16 5.5a3 3 0 0 1 0 5.8M17 14a5 5 0 0 1 3.5 4.5"
                                        />
                                    </svg>
                                </span>

                                <span
                                    class="text-[11px]
                                    font-semibold text-[#64748B]"
                                >
                                    Relational
                                </span>
                            </div>

                            <span
                                class="text-[9px]
                                text-[#94A3B8]"
                            >
                                / 10
                            </span>
                        </div>

                        <p
                            class="mt-4 text-[25px]
                            font-bold leading-none
                            text-[#16425B]"
                        >
                            {{ evaluation.note_relationnelle ?? '-' }}
                        </p>

                        <div
                            class="mt-3 h-1.5 overflow-hidden
                            rounded-full bg-[#E8F1F5]"
                        >
                            <div
                                class="h-full rounded-full
                                bg-[#2F6690]"
                                :style="{
                                    width: `${
                                        Math.min(
                                            100,
                                            Math.max(
                                                0,
                                                Number(
                                                    evaluation.note_relationnelle ?? 0
                                                ) * 10
                                            )
                                        )
                                    }%`
                                }"
                            ></div>
                        </div>
                    </div>
                </div>

                <!-- COMMENT -->
                <div
                    v-if="evaluation.remarque_encadrant"
                    class="mt-4 rounded-xl
                    border border-[#D8E8EF]
                    bg-[#F8FAFC] p-4"
                >
                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-7 w-7 shrink-0
                            items-center justify-center
                            rounded-lg bg-[#E8F1F5]
                            text-[#81C3D7]"
                        >
                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7 8h10M7 12h6M5 20l2.5-3H19a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2z"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <p
                                class="text-[10px] font-bold
                                uppercase tracking-[0.8px]
                                text-[#64748B]"
                            >
                                Supervisor Comment
                            </p>

                            <p
                                class="mt-1.5 text-[11.5px]
                                leading-5 text-[#475569]"
                            >
                                {{ evaluation.remarque_encadrant }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>