<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    evaluations: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
        }),
    },

    selectedStage: {
        type: Object,
        default: null,
    },
})

const form = useForm({
    id_Stage: props.selectedStage?.id ?? null,
    type_evaluation: 'finale',
    note_technique: '',
    note_relationnelle: '',
    remarque_encadrant: '',
})

const internName = computed(() => {
    return (
        props.selectedStage?.intern?.nom_complet ??
        props.selectedStage?.candidature?.stagiaire?.user
            ?.nom_complet ??
        'Unknown intern'
    )
})

const initials = (name) => {
    if (!name) return 'IN'

    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part.charAt(0).toUpperCase())
        .join('')
}

const evaluationInternName = (evaluation) => {
    return (
        evaluation.stage?.candidature?.stagiaire?.user
            ?.nom_complet ??
        'Unknown intern'
    )
}

const evaluationType = (type) => {
    const types = {
        finale: 'Final Evaluation',
        'mi-parcours': 'Mid-term Evaluation',
    }

    return types[type] ?? type ?? 'Evaluation'
}

const globalNote = computed(() => {
    if (
        form.note_technique === '' ||
        form.note_relationnelle === ''
    ) {
        return null
    }

    const technical = Number(form.note_technique)
    const relational = Number(form.note_relationnelle)

    if (
        Number.isNaN(technical) ||
        Number.isNaN(relational)
    ) {
        return null
    }

    return ((technical + relational) / 2).toFixed(1)
})

const globalPercentage = computed(() => {
    if (globalNote.value === null) return 0

    const percentage =
        (Number(globalNote.value) / 20) * 100

    return Math.min(100, Math.max(0, percentage))
})

const submit = () => {
    form.post(route('encadrant.evaluations.store'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Evaluations" />

    <EncadrantLayout>
            <!-- Page header -->
            <div class="w-full p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-[#072B4E]">
                    Evaluations
                </h1>

                <p class="mt-1 text-sm text-[#507291]">
                    Evaluate your interns' performance.
                </p>
            </div>

            <!-- Evaluation form -->
            <div
                v-if="selectedStage"
                class="w-full overflow-hidden rounded-2xl border border-[#A9CEDB]/80 bg-white shadow-sm"
            >
                <div
                    class="h-1 bg-gradient-to-r from-[#072B4E] via-[#39719F] to-[#60ADC6]"
                ></div>

                <!-- Intern header -->
                <div
                    class="flex flex-col gap-4 border-b border-[#A9CEDB]/50 bg-[#F2F8FA]/60 px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#39719F] text-sm font-bold text-white"
                        >
                            {{ initials(internName) }}
                        </div>

                        <div>
                            <h2
                                class="text-base font-semibold text-[#072B4E]"
                            >
                                {{ internName }}
                            </h2>

                            <p class="mt-1 text-sm text-[#507291]">
                                {{
                                    selectedStage.sujet ??
                                    'Internship'
                                }}
                            </p>
                        </div>
                    </div>

                    <span
                        class="w-fit rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700"
                    >
                        100% completed
                    </span>
                </div>

                <!-- Form body -->
                <div class="p-6">
                    <!-- Task completion -->
                    <div
                        class="mb-6 flex items-center justify-between rounded-xl border border-[#A9CEDB]/60 bg-[#F2F8FA] px-4 py-3.5"
                    >
                        <div>
                            <p
                                class="text-xs font-medium text-[#507291]"
                            >
                                Task completion
                            </p>

                            <p
                                class="mt-1 text-sm font-semibold text-[#072B4E]"
                            >
                                {{
                                    selectedStage.completed_tasks ??
                                    0
                                }}
                                /
                                {{
                                    selectedStage.total_tasks ??
                                    0
                                }}
                                tasks completed
                            </p>
                        </div>

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-600"
                        >
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                    </div>

                    <form
                        class="space-y-6"
                        @submit.prevent="submit"
                    >
                        <!-- Evaluation type -->
                        <div>
                            <label
                                for="type_evaluation"
                                class="mb-2 block text-sm font-semibold text-[#072B4E]"
                            >
                                Evaluation Type
                            </label>

                            <select
                                id="type_evaluation"
                                v-model="form.type_evaluation"
                                class="block w-full rounded-xl border border-[#A9CEDB] bg-white px-4 py-3 text-sm text-[#072B4E] shadow-sm outline-none transition focus:border-[#39719F] focus:ring-2 focus:ring-[#60ADC6]/30"
                            >
                                <option value="finale">
                                    Final Evaluation
                                </option>

                                <option value="mi-parcours">
                                    Mid-term Evaluation
                                </option>
                            </select>

                            <p
                                v-if="
                                    form.errors.type_evaluation
                                "
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{
                                    form.errors.type_evaluation
                                }}
                            </p>
                        </div>

                        <!-- Scores -->
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Technical score -->
                            <div>
                                <label
                                    for="note_technique"
                                    class="mb-2 block text-sm font-semibold text-[#072B4E]"
                                >
                                    Technical Note
                                </label>

                                <div class="flex items-center gap-3">
                                    <input
                                        id="note_technique"
                                        v-model="
                                            form.note_technique
                                        "
                                        type="number"
                                        min="0"
                                        max="20"
                                        step="0.5"
                                        placeholder="0"
                                        required
                                        class="block min-w-0 flex-1 rounded-xl border border-[#A9CEDB] px-4 py-3 text-sm text-[#072B4E] shadow-sm outline-none transition placeholder:text-[#90BACA] focus:border-[#39719F] focus:ring-2 focus:ring-[#60ADC6]/30"
                                    />

                                    <span
                                        class="shrink-0 text-sm font-semibold text-[#6695AF]"
                                    >
                                        / 20
                                    </span>
                                </div>

                                <p
                                    v-if="
                                        form.errors.note_technique
                                    "
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{
                                        form.errors
                                            .note_technique
                                    }}
                                </p>
                            </div>

                            <!-- Relational score -->
                            <div>
                                <label
                                    for="note_relationnelle"
                                    class="mb-2 block text-sm font-semibold text-[#072B4E]"
                                >
                                    Relational Note
                                </label>

                                <div class="flex items-center gap-3">
                                    <input
                                        id="note_relationnelle"
                                        v-model="
                                            form.note_relationnelle
                                        "
                                        type="number"
                                        min="0"
                                        max="20"
                                        step="0.5"
                                        placeholder="0"
                                        required
                                        class="block min-w-0 flex-1 rounded-xl border border-[#A9CEDB] px-4 py-3 text-sm text-[#072B4E] shadow-sm outline-none transition placeholder:text-[#90BACA] focus:border-[#39719F] focus:ring-2 focus:ring-[#60ADC6]/30"
                                    />

                                    <span
                                        class="shrink-0 text-sm font-semibold text-[#6695AF]"
                                    >
                                        / 20
                                    </span>
                                </div>

                                <p
                                    v-if="
                                        form.errors
                                            .note_relationnelle
                                    "
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{
                                        form.errors
                                            .note_relationnelle
                                    }}
                                </p>
                            </div>
                        </div>

                        <!-- Global score -->
                        <div
                            class="rounded-xl border border-[#A9CEDB]/70 bg-[#F2F8FA] p-4"
                        >
                            <div
                                class="mb-3 flex items-center justify-between gap-4"
                            >
                                <div>
                                    <p
                                        class="text-sm font-semibold text-[#072B4E]"
                                    >
                                        Global Note
                                    </p>

                                    <p
                                        class="mt-0.5 text-xs text-[#6695AF]"
                                    >
                                        Automatically calculated
                                        from the two notes
                                    </p>
                                </div>

                                <div
                                    class="shrink-0 text-xl font-bold text-[#39719F]"
                                >
                                    {{ globalNote ?? '—' }}

                                    <span
                                        class="text-sm font-semibold text-[#6695AF]"
                                    >
                                        / 20
                                    </span>
                                </div>
                            </div>

                            <div
                                class="h-2.5 w-full overflow-hidden rounded-full bg-[#A9CEDB]/45"
                                role="progressbar"
                                :aria-valuenow="
                                    globalPercentage
                                "
                                aria-valuemin="0"
                                aria-valuemax="100"
                            >
                                <div
                                    class="h-full rounded-full bg-gradient-to-r from-[#39719F] to-[#60ADC6] transition-all duration-300"
                                    :style="{
                                        width: `${globalPercentage}%`,
                                    }"
                                ></div>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div>
                            <div
                                class="mb-2 flex items-center justify-between"
                            >
                                <label
                                    for="remarque_encadrant"
                                    class="text-sm font-semibold text-[#072B4E]"
                                >
                                    Comment
                                </label>

                                <span
                                    class="text-xs text-[#6695AF]"
                                >
                                    Optional
                                </span>
                            </div>

                            <textarea
                                id="remarque_encadrant"
                                v-model="
                                    form.remarque_encadrant
                                "
                                rows="5"
                                placeholder="Share detailed feedback about the intern's performance..."
                                class="block w-full resize-none rounded-xl border border-[#A9CEDB] px-4 py-3 text-sm text-[#072B4E] shadow-sm outline-none transition placeholder:text-[#90BACA] focus:border-[#39719F] focus:ring-2 focus:ring-[#60ADC6]/30"
                            ></textarea>

                            <p
                                v-if="
                                    form.errors
                                        .remarque_encadrant
                                "
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{
                                    form.errors
                                        .remarque_encadrant
                                }}
                            </p>
                        </div>

                        <!-- Backend error -->
                        <div
                            v-if="form.errors.id_Stage"
                            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                        >
                            {{ form.errors.id_Stage }}
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex flex-wrap items-center gap-3 border-t border-[#A9CEDB]/50 pt-5"
                        >
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex items-center justify-center rounded-xl bg-[#39719F] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#072B4E] focus:outline-none focus:ring-2 focus:ring-[#60ADC6]/40 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <svg
                                    v-if="!form.processing"
                                    class="mr-2 h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                {{
                                    form.processing
                                        ? 'Submitting...'
                                        : 'Submit Evaluation'
                                }}
                            </button>

                            <Link
                                :href="
                                    route(
                                        'encadrant.progress.index'
                                    )
                                "
                                class="rounded-xl border border-[#A9CEDB] bg-white px-6 py-3 text-sm font-semibold text-[#39719F] transition hover:border-[#39719F] hover:bg-[#F2F8FA] hover:text-[#072B4E]"
                            >
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Evaluated interns -->
           <div
              v-else
                class="w-full overflow-hidden rounded-2xl border border-[#A9CEDB]/80 bg-white shadow-sm">
                <div
                    class="h-1 bg-gradient-to-r from-[#072B4E] via-[#39719F] to-[#60ADC6]"
                ></div>

                <!-- List header -->
                <div
                    class="flex flex-col gap-3 border-b border-[#A9CEDB]/50 bg-[#F2F8FA]/50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <h2
                            class="text-base font-semibold text-[#072B4E]"
                        >
                            Evaluated Interns
                        </h2>

                        <p class="mt-1 text-sm text-[#507291]">
                            View evaluations you have submitted.
                        </p>
                    </div>

                    <span
                        class="w-fit rounded-full border border-[#A9CEDB] bg-white px-3 py-1.5 text-xs font-semibold text-[#39719F]"
                    >
                        {{ evaluations.data?.length ?? 0 }}
                        evaluations
                    </span>
                </div>

                <!-- Evaluation list -->
                <div
                    v-if="evaluations.data?.length"
                    class="divide-y divide-[#A9CEDB]/40"
                >
                    <article
                        v-for="evaluation in evaluations.data"
                        :key="evaluation.id"
                        class="px-6 py-5 transition hover:bg-[#F2F8FA]/60"
                    >
                        <div
                            class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between"
                        >
                            <!-- Intern information -->
                            <div
                                class="flex min-w-0 items-center gap-4"
                            >
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#39719F] text-sm font-bold text-white"
                                >
                                    {{
                                        initials(
                                            evaluationInternName(
                                                evaluation
                                            )
                                        )
                                    }}
                                </div>

                                <div class="min-w-0">
                                    <h3
                                        class="truncate text-sm font-semibold text-[#072B4E]"
                                    >
                                        {{
                                            evaluationInternName(
                                                evaluation
                                            )
                                        }}
                                    </h3>

                                    <p
                                        class="mt-1 truncate text-xs text-[#507291]"
                                    >
                                        {{
                                            evaluation.stage
                                                ?.sujet ??
                                            'Internship'
                                        }}
                                    </p>

                                    <span
                                        class="mt-2 inline-flex rounded-full border border-[#A9CEDB]/70 bg-[#F2F8FA] px-2.5 py-1 text-[11px] font-medium text-[#39719F]"
                                    >
                                        {{
                                            evaluationType(
                                                evaluation
                                                    .type_evaluation
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- Scores -->
                            <div
                                class="grid grid-cols-3 gap-4 rounded-xl border border-[#A9CEDB]/60 bg-[#F2F8FA] px-5 py-3 sm:min-w-[330px]"
                            >
                                <div>
                                    <p
                                        class="text-[11px] font-medium text-[#6695AF]"
                                    >
                                        Technical
                                    </p>

                                    <p
                                        class="mt-1 text-sm font-semibold text-[#072B4E]"
                                    >
                                        {{
                                            evaluation.note_technique
                                        }}

                                        <span
                                            class="text-xs text-[#6695AF]"
                                        >
                                            /20
                                        </span>
                                    </p>
                                </div>

                                <div
                                    class="border-l border-[#A9CEDB]/70 pl-4"
                                >
                                    <p
                                        class="text-[11px] font-medium text-[#6695AF]"
                                    >
                                        Relational
                                    </p>

                                    <p
                                        class="mt-1 text-sm font-semibold text-[#072B4E]"
                                    >
                                        {{
                                            evaluation
                                                .note_relationnelle
                                        }}

                                        <span
                                            class="text-xs text-[#6695AF]"
                                        >
                                            /20
                                        </span>
                                    </p>
                                </div>

                                <div
                                    class="border-l border-[#A9CEDB]/70 pl-4"
                                >
                                    <p
                                        class="text-[11px] font-medium text-[#6695AF]"
                                    >
                                        Global
                                    </p>

                                    <p
                                        class="mt-1 text-base font-bold text-[#39719F]"
                                    >
                                        {{
                                            evaluation.note_global
                                        }}

                                        <span
                                            class="text-xs font-medium text-[#6695AF]"
                                        >
                                            /20
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div
                            v-if="
                                evaluation.remarque_encadrant
                            "
                            class="mt-4 rounded-xl border border-[#A9CEDB]/50 bg-[#F2F8FA] px-4 py-3"
                        >
                            <p
                                class="mb-1 text-[10px] font-semibold uppercase tracking-wide text-[#60ADC6]"
                            >
                                Supervisor Comment
                            </p>

                            <p
                                class="text-sm leading-6 text-[#507291]"
                            >
                                {{
                                    evaluation
                                        .remarque_encadrant
                                }}
                            </p>
                        </div>

                        <p
                            v-if="evaluation.date_evaluation"
                            class="mt-3 text-xs text-[#6695AF]"
                        >
                            Evaluated:
                            {{ evaluation.date_evaluation }}
                        </p>
                    </article>
                </div>

                <!-- Empty state -->
                <div
                    v-else
                    class="px-6 py-16 text-center"
                >
                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#F2F8FA] text-[#39719F]"
                    >
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 2l3 6 6 .9-4.5 4.4 1 6.2L12 16.6 6.5 19.5l1-6.2L3 8.9 9 8z"
                            />
                        </svg>
                    </div>

                    <h3
                        class="mt-4 text-sm font-semibold text-[#072B4E]"
                    >
                        No evaluations yet
                    </h3>

                    <p class="mt-1 text-sm text-[#507291]">
                        Completed evaluations will appear here.
                    </p>

                    <Link
                        :href="
                            route(
                                'encadrant.progress.index'
                            )
                        "
                        class="mt-5 inline-flex rounded-xl bg-[#39719F] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#072B4E] focus:outline-none focus:ring-2 focus:ring-[#60ADC6]/40"
                    >
                        View Progress Tracking
                    </Link>
                </div>
            </div>

            <!-- Pagination -->
            <div
                v-if="
                    !selectedStage &&
                    evaluations.links?.length > 3
                "
                class="mt-6 flex w-full flex-wrap justify-center gap-1.5"
            >
                <Link
                    v-for="(link, index) in evaluations.links"
                    :key="`${link.label}-${index}`"
                    :href="link.url || '#'"
                    preserve-scroll
                    class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border px-3 py-2 text-sm font-medium transition"
                    :class="[
                        link.active
                            ? 'border-[#39719F] bg-[#39719F] text-white'
                            : 'border-[#A9CEDB] bg-white text-[#39719F] hover:border-[#60ADC6] hover:bg-[#F2F8FA] hover:text-[#072B4E]',

                        !link.url
                            ? 'pointer-events-none opacity-40'
                            : '',
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </EncadrantLayout>
</template>
