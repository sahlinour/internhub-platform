<script setup>
defineProps({
    currentStep: {
        type: Number,
        required: true,
    },
})

const steps = [
    {
        number: 1,
        title: 'Personal Information',
        shortTitle: 'Personal',
    },
    {
        number: 2,
        title: 'Resume',
        shortTitle: 'Resume',
    },
    {
        number: 3,
        title: 'Cover Letter',
        shortTitle: 'Cover Letter',
    },
    {
        number: 4,
        title: 'Review',
        shortTitle: 'Review',
    },
]
</script>

<template>
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="flex items-start justify-between">
            <template
                v-for="(step, index) in steps"
                :key="step.number"
            >
                <div class="flex min-w-0 flex-1 items-center">
                    <div class="flex min-w-0 flex-col items-center">
                        <!-- Circle -->
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full border-2 text-sm font-semibold transition"
                            :class="[
                                currentStep >= step.number
                                    ? 'border-[#2F6690] bg-[#2F6690] text-white'
                                    : 'border-slate-300 bg-white text-slate-400'
                            ]"
                        >
                            <svg
                                v-if="currentStep > step.number"
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            <span v-else>
                                {{ step.number }}
                            </span>
                        </div>

                        <!-- Title -->
                        <span
                            class="mt-2 hidden text-center text-xs font-medium sm:block"
                            :class="
                                currentStep >= step.number
                                    ? 'text-[#2F6690]'
                                    : 'text-slate-400'
                            "
                        >
                            {{ step.title }}
                        </span>

                        <span
                            class="mt-2 text-center text-[10px] font-medium sm:hidden"
                            :class="
                                currentStep >= step.number
                                    ? 'text-[#2F6690]'
                                    : 'text-slate-400'
                            "
                        >
                            {{ step.shortTitle }}
                        </span>
                    </div>

                    <!-- Line -->
                    <div
                        v-if="index < steps.length - 1"
                        class="mx-2 mt-[-18px] h-0.5 flex-1 sm:mx-4"
                        :class="
                            currentStep > step.number
                                ? 'bg-[#2F6690]'
                                : 'bg-slate-200'
                        "
                    ></div>
                </div>
            </template>
        </div>
    </div>
</template>