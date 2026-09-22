<script setup>
import { Head, Link } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

defineProps({
    interns: {
        type: Array,
        default: () => [],
    },
})

const internName = (intern) => {
    return intern.intern?.nom_complet ?? 'Unknown intern'
}

const progressClass = (progress) => {
    if (progress >= 75) {
        return 'bg-emerald-500'
    }

    if (progress >= 50) {
        return 'bg-[#17629b]'
    }

    if (progress > 0) {
        return 'bg-sky-400'
    }

    return 'bg-gray-300'
}

const progressTextClass = (progress) => {
    if (progress >= 75) {
        return 'text-emerald-600'
    }

    if (progress >= 50) {
        return 'text-[#17629b]'
    }

    if (progress > 0) {
        return 'text-sky-600'
    }

    return 'text-gray-500'
}
</script>

<template>
    <Head title="Progress Tracking" />

    <EncadrantLayout>
        <div class="p-6">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    Progress Tracking
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Monitor progress across your assigned interns.
                </p>
            </div>

            <!-- Progress Cards -->
            <div
                v-if="interns.length"
                class="grid gap-4 md:grid-cols-2 xl:grid-cols-3"
            >
                <div
                    v-for="intern in interns"
                    :key="intern.stage_id"
                    class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
                >
                    <!-- Intern Name -->
                    <h2 class="text-sm font-semibold text-gray-900">
                        {{ internName(intern) }}
                    </h2>

                    <!-- Tasks -->
                    <p class="mt-1 text-xs text-gray-500">
                        {{ intern.completed_tasks }}/{{ intern.total_tasks }}
                        tasks completed
                    </p>

                    <!-- Progress Bar -->
                    <div
                        class="mt-4 h-2 w-full overflow-hidden rounded-full bg-gray-200"
                    >
                        <div
                            class="h-full rounded-full transition-all duration-300"
                            :class="progressClass(intern.progress)"
                            :style="{ width: `${intern.progress}%` }"
                        ></div>
                    </div>

                    <!-- Percentage -->
                    <p
                        class="mt-2 text-sm font-semibold"
                        :class="progressTextClass(intern.progress)"
                    >
                        {{ intern.progress }}% complete
                    </p>

                    <!-- Evaluation available only at 100% -->
                    <div
                        v-if="intern.progress === 100"
                        class="mt-5 border-t border-gray-100 pt-4"
                    >
                        <div
                            class="mb-3 flex items-center gap-2 text-xs text-emerald-600"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            Internship tasks completed
                        </div>

                        <Link
                            :href="`/encadrant/evaluations?stage_id=${intern.stage_id}`"
                            class="inline-flex w-full items-center justify-center
                                   gap-2 rounded-lg bg-[#17629b] px-4 py-2.5
                                   text-sm font-semibold text-white
                                   transition hover:bg-[#124f7e]"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 2l3 6 6 .9-4.5 4.4
                                       1 6.2L12 16.6
                                       6.5 19.5l1-6.2L3 8.9
                                       9 8z"
                                />
                            </svg>

                            Evaluate Intern
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div
                v-else
                class="rounded-xl border border-gray-200 bg-white
                       px-6 py-16 text-center shadow-sm"
            >
                <p class="text-sm text-gray-500">
                    No intern progress available.
                </p>
            </div>

        </div>
    </EncadrantLayout>
</template>
