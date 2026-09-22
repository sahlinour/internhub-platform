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
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white px-4 py-5 shadow-sm sm:px-6">
        <div class="flex items-start">

            <template
                v-for="(step, index) in steps"
                :key="step.number"
            >
                <!-- Step -->
                <div class="flex min-w-0 flex-1 items-start">

                    <div class="flex w-full flex-col items-center">

                        <!-- Number -->
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full border-2 text-xs font-bold transition-all duration-200 sm:h-9 sm:w-9 sm:text-sm"
                            :class="[
                                currentStep > step.number
                                    ? 'border-[#2F6690] bg-[#2F6690] text-white'
                                    : currentStep === step.number
                                        ? 'border-[#2F6690] bg-white text-[#2F6690] ring-4 ring-[#E8F1F5]'
                                        : 'border-slate-200 bg-white text-slate-400'
                            ]"
                        >
                            <!-- Completed -->
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

                            <!-- Number -->
                            <span v-else>
                                {{ step.number }}
                            </span>
                        </div>

                        <!-- Desktop title -->
                        <span
                            class="mt-2 hidden text-center text-[11px] font-semibold leading-tight sm:block"
                            :class="[
                                currentStep >= step.number
                                    ? 'text-[#16425B]'
                                    : 'text-slate-400'
                            ]"
                        >
                            {{ step.title }}
                        </span>

                        <!-- Mobile title -->
                        <span
                            class="mt-2 max-w-[70px] text-center text-[9px] font-semibold leading-tight sm:hidden"
                            :class="[
                                currentStep >= step.number
                                    ? 'text-[#2F6690]'
                                    : 'text-slate-400'
                            ]"
                        >
                            {{ step.shortTitle }}
                        </span>
                    </div>

                    <!-- Progress line -->
                    <div
                        v-if="index < steps.length - 1"
                        class="mx-1.5 mt-4 h-0.5 flex-1 overflow-hidden rounded-full bg-slate-200 sm:mx-3 sm:mt-[18px]"
                    >
                        <div
                            class="h-full rounded-full transition-all duration-300"
                            :class="
                                currentStep > step.number
                                    ? 'w-full bg-[#2F6690]'
                                    : 'w-0'
                            "
                        ></div>
                    </div>

                </div>
            </template>

        </div>
    </div>
</template>
