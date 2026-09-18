<script setup>
defineProps({
    ringRadius: {
        type: Number,
        required: true,
    },

    ringCircumference: {
        type: Number,
        required: true,
    },

    stageProgressValue: {
        type: Number,
        default: 0,
    },

    ringOffset: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <section class="mb-6">

        <div
            class="relative overflow-hidden rounded-2xl
                bg-gradient-to-r from-[#16425B] to-[#2F6690]
                px-6 py-6 text-white
                shadow-[0_8px_25px_rgba(22,66,91,0.12)]"
        >
            <!-- DECORATION -->
            <div
                class="absolute -right-10 -top-14
                    h-36 w-36 rounded-full
                    bg-white/[0.06]"
            ></div>

            <div
                class="absolute -bottom-16 right-24
                    h-32 w-32 rounded-full
                    bg-[#81C3D7]/10"
            ></div>

            <div
                class="relative flex flex-col gap-6
                    lg:flex-row lg:items-center
                    lg:justify-between"
            >

                <!-- LEFT : TITLE -->
                <div class="min-w-0">

                    <p
                        class="mb-1 text-[9px] font-bold uppercase
                            tracking-[1.5px] text-[#81C3D7]"
                    >
                        My Internship
                    </p>

                    <h1
                        class="text-[25px] font-bold tracking-[-0.4px]"
                    >
                        My Progress
                    </h1>

                    <p
                        class="mt-1 max-w-[550px]
                            text-[11px] leading-5 text-white/65"
                    >
                        Track your internship progress, tasks, documents
                        and evaluation.
                    </p>

                </div>

                <!-- RIGHT : OVERALL PROGRESS -->
                <div
                    class="relative flex shrink-0 items-center
                        gap-4 rounded-xl
                        border border-white/10
                        bg-white/[0.08]
                        px-4 py-3"
                >

                    <!-- CIRCLE -->
                    <div class="relative h-[72px] w-[72px]">

                        <svg
                            viewBox="0 0 100 100"
                            class="h-[72px] w-[72px] -rotate-90"
                        >
                            <!-- BACKGROUND -->
                            <circle
                                cx="50"
                                cy="50"
                                :r="ringRadius"
                                fill="none"
                                stroke="rgba(255,255,255,0.14)"
                                stroke-width="9"
                            />

                            <!-- PROGRESS -->
                            <circle
                                cx="50"
                                cy="50"
                                :r="ringRadius"
                                fill="none"
                                stroke="#81C3D7"
                                stroke-width="9"
                                stroke-linecap="round"
                                :stroke-dasharray="ringCircumference"
                                :stroke-dashoffset="ringOffset"
                                style="transition: stroke-dashoffset 600ms ease"
                            />
                        </svg>

                        <!-- CENTER -->
                        <div
                            class="absolute inset-0 flex items-center
                                justify-center"
                        >
                            <span
                                class="text-[15px] font-bold text-white"
                            >
                                {{ stageProgressValue }}%
                            </span>
                        </div>

                    </div>

                    <!-- LABEL -->
                    <div class="pr-1">

                        <p
                            class="text-[9px] font-bold uppercase
                                tracking-[1.2px] text-[#81C3D7]"
                        >
                            Overall Progress
                        </p>

                        <p
                            class="mt-1 text-[12px] font-medium
                                text-white/80"
                        >
                            Internship completion
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>