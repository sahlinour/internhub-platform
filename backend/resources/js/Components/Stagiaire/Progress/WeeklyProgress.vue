<script setup>
defineProps({
    weeklyChart: {
        type: Array,
        default: () => [],
    },

    formatDate: {
        type: Function,
        required: true,
    },
})
</script>

<template>
    <section
        class="mb-5 overflow-hidden rounded-2xl
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
            <div>
                <div class="flex items-center gap-2.5">
                    <div
                        class="flex h-8 w-8 shrink-0
                        items-center justify-center
                        rounded-lg bg-[#E8F1F5]
                        text-[#2F6690]"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 19V5M4 19h16"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 16v-5M12 16V8M16 16v-7M20 16v-3"
                            />
                        </svg>
                    </div>
                    <div>
                        <h3
                            class="text-[14px] font-bold
                            text-[#16425B]"
                        >
                            Weekly Progress
                        </h3>
                        <p
                            class="mt-0.5 text-[10.5px]
                            text-[#64748B]"
                        >
                            Task completion throughout the internship.
                        </p>
                    </div>
                </div>
            </div>

            <!-- LEGEND -->
            <div
                class="flex flex-wrap items-center gap-3
                rounded-lg bg-white px-3 py-2
                text-[9px] text-[#64748B]"
            >
                <div class="flex items-center gap-1.5">
                    <span
                        class="h-2 w-2 rounded-full
                        bg-[#16425B]"
                    ></span>
                    <span>75–100%</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span
                        class="h-2 w-2 rounded-full
                        bg-[#E08A00]"
                    ></span>
                    <span>40–74%</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span
                        class="h-2 w-2 rounded-full
                        bg-[#D80536]"
                    ></span>
                    <span>0–39%</span>
                </div>
            </div>
        </div>
        <!-- CONTENT -->
        <div
            v-if="weeklyChart.length"
            class="p-5"
        >
            <!-- HORIZONTAL SCROLL -->
            <div class="overflow-x-auto">
                <div class="min-w-[1080px]">
                    <!-- CHART -->
                    <div
                        class="relative h-[220px]
                        pl-[42px] pr-[12px]"
                    >

                        <!-- GRID -->
                        <div
                            class="pointer-events-none
                            absolute left-[42px]
                            right-[12px]
                            top-0 bottom-0
                            flex flex-col
                            justify-between"
                        >

                            <div
                                class="flex items-center"
                            >
                                <div
                                    class="h-px flex-1
                                    border-t
                                    border-dashed
                                    border-[#E2E8F0]"
                                ></div>
                            </div>
                            <div
                                class="flex items-center"
                            >
                                <div
                                    class="h-px flex-1
                                    border-t
                                    border-dashed
                                    border-[#E2E8F0]"
                                ></div>
                            </div>
                            <div
                                class="flex items-center"
                            >
                                <div
                                    class="h-px flex-1
                                    border-t
                                    border-dashed
                                    border-[#E2E8F0]"
                                ></div>
                            </div>
                            <div
                                class="flex items-center"
                            >
                                <div
                                    class="h-px flex-1
                                    border-t
                                    border-dashed
                                    border-[#E2E8F0]"
                                ></div>
                            </div>
                            <div
                                class="flex items-center"
                            >
                                <div
                                    class="h-px flex-1
                                    border-t
                                    border-[#CBD5E1]"
                                ></div>
                            </div>
                        </div>
                        <!-- Y AXIS -->
                        <div
                            class="absolute left-0 top-0
                            bottom-0 flex w-[30px]
                            flex-col justify-between"
                        >
                            <span
                                class="text-[8px]
                                font-medium
                                text-[#94A3B8]"
                            >
                                100
                            </span>
                            <span
                                class="text-[8px]
                                font-medium
                                text-[#94A3B8]"
                            >
                                75
                            </span>
                            <span
                                class="text-[8px]
                                font-medium
                                text-[#94A3B8]"
                            >
                                50
                            </span>
                            <span
                                class="text-[8px]
                                font-medium
                                text-[#94A3B8]"
                            >
                                25
                            </span>
                            <span
                                class="text-[8px]
                                font-medium
                                text-[#94A3B8]"
                            >
                                0
                            </span>
                        </div>
                        <!-- BARS -->
                        <div
                            class="absolute left-[58px]
                            right-[28px]
                            top-0 bottom-0
                            grid
                            grid-cols-[repeat(auto-fit,minmax(58px,1fr))]
                            gap-3"
                        >
                            <div
                                v-for="week in weeklyChart"
                                :key="week.week"
                                class="group relative
                                flex h-full
                                flex-col items-center
                                justify-end"
                            >
                                <!-- PERCENTAGE -->
                                <div
                                    class="absolute z-10
                                    flex h-6 min-w-[38px]
                                    items-center
                                    justify-center
                                    rounded-md px-2
                                    text-[9px] font-bold
                                    shadow-sm
                                    transition
                                    group-hover:-translate-y-0.5"
                                    :class="[
                                        week.textClass,

                                        week.progress >= 75
                                            ? 'bg-[#E8F1F5]'

                                            : week.progress >= 40
                                                ? 'bg-[#FFF4DE]'

                                                : 'bg-[#FDE8EE]'
                                    ]"
                                    :style="{
                                        bottom: `calc(
                                            ${Math.max(
                                                week.progress,
                                                3
                                            )}%
                                            + 8px
                                        )`
                                    }"
                                >
                                    {{ week.progress }}%
                                </div>

                                <!-- BAR TRACK -->
                                <div
                                    class="relative flex
                                    h-full w-full
                                    items-end
                                    justify-center"
                                >
                                    <!-- TRACK -->
                                    <div
                                        class="absolute bottom-0
                                        h-full w-[42px]
                                        rounded-t-xl
                                        bg-[#F1F5F9]"
                                    ></div>
                                    <!-- BAR -->
                                    <div
                                        class="relative z-[1]
                                        w-[42px]
                                        rounded-t-xl
                                        transition-all
                                        duration-700
                                        ease-out
                                        group-hover:brightness-105"
                                        :class="week.barClass"
                                        :style="{
                                            height: `${Math.max(
                                                week.progress,
                                                3
                                            )}%`
                                        }"
                                    >
                                        <!-- TOP HIGHLIGHT -->
                                        <div
                                            class="absolute
                                            inset-x-0 top-0
                                            h-[3px]
                                            rounded-t-xl
                                            bg-white/25"
                                        ></div>
                                        <!-- SOFT SHINE -->
                                        <div
                                            class="absolute inset-0
                                            bg-gradient-to-r
                                            from-white/[0.10]
                                            via-transparent
                                            to-black/[0.05]"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- WEEK LABELS -->
                    <div
                        class="ml-[58px] mr-[28px]
                        grid
                        grid-cols-[repeat(auto-fit,minmax(58px,1fr))]
                        gap-3"
                    >
                        <div
                            v-for="week in weeklyChart"
                            :key="`${week.week}-label`"
                            class="min-w-0
                            text-center"
                        >
                            <p
                                class="truncate
                                text-[10px] font-bold
                                text-[#334155]"
                            >
                                {{ week.label }}
                            </p>
                            <p
                                class="mt-0.5
                                whitespace-nowrap
                                text-[9px]
                                text-[#94A3B8]"
                            >
                                {{ formatDate(week.start_date) }}
                            </p>
                        </div>
                    </div>

                    <!-- TASK INFORMATION -->
                    <div
                        class="mt-3 ml-[58px] mr-[28px]
                        grid
                        grid-cols-[repeat(auto-fit,minmax(58px,1fr))]
                        gap-3
                        border-t border-[#EEF2F6]
                        pt-3"
                    >
                        <div
                            v-for="week in weeklyChart"
                            :key="`${week.week}-tasks`"
                            class="flex
                            min-w-0
                            items-center
                            justify-center"
                        >
                            <div
                                class="inline-flex
                                items-center
                                gap-1.5 rounded-md
                                bg-[#F8FAFC]
                                px-2 py-1"
                            >
                                <svg
                                    class="h-3 w-3
                                    shrink-0
                                    text-[#2F6690]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 12l4 4L19 6"
                                    />
                                </svg>
                                <span
                                    class="whitespace-nowrap
                                    text-[9px]
                                    text-[#64748B]"
                                >
                                    <strong
                                        class="font-bold
                                        text-[#16425B]"
                                    >
                                        {{ week.completed_tasks }}
                                    </strong>
                                    /{{ week.total_tasks }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- BOTTOM SUMMARY -->
                    <div
                        class="mt-4 flex flex-col
                        gap-2 border-t
                        border-[#EEF2F6]
                        pt-3
                        sm:flex-row
                        sm:items-center
                        sm:justify-between"
                    >
                        <div
                            class="flex items-center
                            gap-2"
                        >
                            <span
                                class="flex h-5 w-5
                                items-center
                                justify-center
                                rounded-md
                                bg-[#E8F1F5]
                                text-[#2F6690]"
                            >
                                <svg
                                    class="h-3 w-3"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4 19V5M4 19h16"
                                    />
                                </svg>
                            </span>
                            <span
                                class="text-[9px]
                                text-[#64748B]"
                            >
                                {{ weeklyChart.length }}

                                week<span
                                    v-if="weeklyChart.length > 1"
                                >
                                    s
                                </span>
                                tracked
                            </span>
                        </div>
                        <div
                            v-if="weeklyChart.length"
                            class="text-[9px]
                            text-[#94A3B8]"
                        >
                            Latest week:
                            <span
                                class="font-bold
                                text-[#16425B]"
                            >
                                {{
                                    weeklyChart[
                                        weeklyChart.length - 1
                                    ].progress
                                }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EMPTY STATE -->
        <div
            v-else
            class="p-5"
        >
            <div
                class="flex min-h-[180px]
                items-center
                justify-center
                rounded-xl
                bg-[#F8FAFC]
                text-center"
            >
                <div>
                    <div
                        class="mx-auto flex h-10 w-10
                        items-center
                        justify-center
                        rounded-full
                        bg-[#E8F1F5]
                        text-[#81C3D7]"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 19V5M4 19h16"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 16v-4M12 16V8M16 16v-7"
                            />
                        </svg>
                    </div>
                    <p
                        class="mt-2 text-[11px]
                        font-medium
                        text-[#64748B]"
                    >
                        No weekly task data available yet.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>