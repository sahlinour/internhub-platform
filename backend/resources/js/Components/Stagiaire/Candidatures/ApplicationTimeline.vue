<script setup>
import { computed } from 'vue'

const props = defineProps({
    candidature: {
        type: Object,
        required: true,
    },
})

const formatDate = (date) => {
    if (!date) return '-'

    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    })
}

const currentStep = computed(() => {
    switch (props.candidature.statut) {
        case 'en_attente':
            return 1

        case 'en_cours_examen':
            return 2

        case 'acceptee':
        case 'refusee':
            return 3

        default:
            return 1
    }
})

const steps = computed(() => [
    {
        title: 'Application submitted',
        description: 'Your application was successfully submitted.',
        date: formatDate(props.candidature.date_postulation),
        completed: currentStep.value >= 1,
    },
    {
        title: 'Under review',
        description: 'Your application is being reviewed by the company.',
        date: currentStep.value >= 2
            ? 'In progress'
            : 'Waiting',
        completed: currentStep.value >= 2,
    },
    {
        title: props.candidature.statut === 'refusee'
            ? 'Application rejected'
            : 'Application decision',

        description: props.candidature.statut === 'acceptee'
            ? 'Your application has been accepted.'
            : props.candidature.statut === 'refusee'
                ? 'Your application has been rejected.'
                : 'Waiting for the company decision.',
        date: currentStep.value >= 3
            ? 'Completed'
            : 'Waiting',
        completed: currentStep.value >= 3,
    },
])
</script>

<template>
    <section
        class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        <!-- Header -->
        <div class="border-b border-slate-100 px-5 py-4 sm:px-7">
            <h2 class="text-sm font-bold text-[#16425B]">
                Application Timeline
            </h2>

            <p class="mt-0.5 text-xs text-slate-400">
                Follow the progress of your application.
            </p>
        </div>

        <!-- Timeline -->
        <div class="px-5 py-6 sm:px-7 sm:py-7">

            <div
                v-for="(step, index) in steps"
                :key="step.title"
                class="relative flex gap-4"
            >

                <!-- Vertical line -->
                <div
                    v-if="index < steps.length - 1"
                    class="absolute left-[9px] top-5 h-full w-px"
                    :class="
                        step.completed
                            ? 'bg-[#81C3D7]'
                            : 'bg-slate-200'
                    "
                ></div>

                <!-- Circle -->
                <div
                    class="relative z-10 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2"
                    :class="
                        step.completed
                            ? 'border-[#3A7CA5] bg-[#3A7CA5] text-white'
                            : 'border-slate-200 bg-white text-slate-300'
                    "
                >
                    <svg
                        v-if="step.completed"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M16.704 5.296a1 1 0 010 1.414l-7.25 7.25a1 1 0 01-1.414 0l-3.25-3.25a1 1 0 011.414-1.414l2.543 2.543 6.543-6.543a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>

                <!-- Content -->
                <div
                    class="min-w-0"
                    :class="index < steps.length - 1 ? 'pb-8' : ''"
                >
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:gap-3">
                        <h3
                            class="text-xs font-bold"
                            :class="
                                step.completed
                                    ? 'text-[#16425B]'
                                    : 'text-slate-400'
                            "
                        >
                            {{ step.title }}
                        </h3>

                        <span
                            class="text-[10px]"
                            :class="
                                step.completed
                                    ? 'text-slate-400'
                                    : 'text-slate-300'
                            "
                        >
                            {{ step.date }}
                        </span>
                    </div>

                    <p
                        class="mt-1 text-[11px] leading-5"
                        :class="
                            step.completed
                                ? 'text-slate-500'
                                : 'text-slate-300'
                        "
                    >
                        {{ step.description }}
                    </p>
                </div>

            </div>

        </div>
    </section>
</template>