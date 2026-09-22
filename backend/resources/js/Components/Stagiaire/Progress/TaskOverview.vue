<script setup>
defineProps({
    taskStatus: {
        type: Array,
        default: () => [],
    },

    taskPriority: {
        type: Array,
        default: () => [],
    },

    taskPercentage: {
        type: Function,
        required: true,
    },

    statusColor: {
        type: Function,
        required: true,
    },

    priorityColor: {
        type: Function,
        required: true,
    },
})
</script>

<template>
    <section
        class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-2"
    >

        <!-- TASK STATUS -->
        <div
            class="rounded-2xl border border-[#E2E8F0]
            bg-white p-5 shadow-sm"
        >
            <div class="mb-5">
                <h3 class="text-[15px] font-semibold text-[#16425B]">
                    Task Completion
                </h3>

                <p class="mt-1 text-[12px] text-[#64748B]">
                    Overview of your assigned tasks.
                </p>
            </div>

            <div
                v-if="taskStatus.length"
                class="space-y-4"
            >
                <div
                    v-for="item in taskStatus"
                    :key="item.label"
                >
                    <div
                        class="mb-1.5 flex items-center
                        justify-between text-[12px]"
                    >
                        <span
                            class="font-medium"
                            :class="statusColor(item.label).text"
                        >
                            {{ item.label }}
                        </span>

                        <span
                            class="font-semibold text-[#16425B]"
                        >
                            {{ item.value }}
                        </span>
                    </div>

                    <div
                        class="h-2 overflow-hidden
                        rounded-full bg-[#E8F1F5]"
                    >
                        <div
                            class="h-full rounded-full
                            transition-all duration-500"
                            :class="statusColor(item.label).bg"
                            :style="{
                                width: `${taskPercentage(item.value)}%`
                            }"
                        ></div>
                    </div>
                </div>
            </div>

            <div
                v-else
                class="rounded-xl bg-[#F8FAFC]
                px-4 py-8 text-center text-[12px]
                text-[#64748B]"
            >
                No task data available yet.
            </div>
        </div>

        <!-- TASK PRIORITY -->
        <div
            class="rounded-2xl border border-[#E2E8F0]
            bg-white p-5 shadow-sm"
        >
            <div class="mb-5">
                <h3 class="text-[15px] font-semibold text-[#16425B]">
                    Tasks by Priority
                </h3>

                <p class="mt-1 text-[12px] text-[#64748B]">
                    Distribution of assigned tasks by priority.
                </p>
            </div>

            <div
                v-if="taskPriority.length"
                class="space-y-4"
            >
                <div
                    v-for="item in taskPriority"
                    :key="item.label"
                >
                    <div
                        class="mb-1.5 flex items-center
                        justify-between text-[12px]"
                    >
                        <span
                            class="font-medium"
                            :class="priorityColor(item.label).text"
                        >
                            {{ item.label }}
                        </span>

                        <span
                            class="font-semibold text-[#16425B]"
                        >
                            {{ item.value }}
                        </span>
                    </div>

                    <div
                        class="h-2 overflow-hidden
                        rounded-full bg-[#E8F1F5]"
                    >
                        <div
                            class="h-full rounded-full
                            transition-all duration-500"
                            :class="priorityColor(item.label).bg"
                            :style="{
                                width: `${taskPercentage(item.value)}%`
                            }"
                        ></div>
                    </div>
                </div>
            </div>

            <div
                v-else
                class="rounded-xl bg-[#F8FAFC]
                px-4 py-8 text-center text-[12px]
                text-[#64748B]"
            >
                No task data available yet.
            </div>
        </div>
    </section>
</template>