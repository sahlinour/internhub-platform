<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    evaluations: {
        type: Object,
        default: () => ({
            data: [],
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
    return props.selectedStage?.intern?.nom_complet ?? 'Unknown intern'
})

const initials = (name) => {
    if (!name) return 'IN'

    return name
        .split(' ')
        .filter(Boolean)
        .map(part => part[0])
        .slice(0, 2)
        .join('')
        .toUpperCase()
}

const evaluationInternName = (evaluation) => {
    return (
        evaluation.stage
            ?.candidature
            ?.stagiaire
            ?.user
            ?.nom_complet
        ?? 'Unknown intern'
    )
}

const evaluationType = (type) => {
    if (type === 'finale') {
        return 'Final Evaluation'
    }

    if (type === 'mi-parcours') {
        return 'Mid-term Evaluation'
    }

    return type
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

    return ((technical + relational) / 2).toFixed(1)
})

const globalPercentage = computed(() => {
    if (globalNote.value === null) {
        return 0
    }

    return (Number(globalNote.value) / 20) * 100
})

const submit = () => {
    form.post('/encadrant/evaluations', {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Evaluations" />

    <EncadrantLayout>
        <div class="p-6 lg:p-8">

            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    Evaluations
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Evaluate your interns' performance.
                </p>
            </div>

            <!-- ================================================= -->
            <!-- EVALUATION FORM -->
            <!-- Shown when coming from Progress Tracking -->
            <!-- ================================================= -->

            <div
                v-if="selectedStage"
                class="max-w-4xl overflow-hidden rounded-2xl
                       border border-gray-200 bg-white shadow-sm"
            >
                <!-- Intern Header -->
                <div
                    class="flex flex-col gap-4 border-b border-gray-100
                           px-6 py-5 sm:flex-row sm:items-center
                           sm:justify-between"
                >
                    <div class="flex items-center gap-4">

                        <!-- Avatar -->
                        <div
                            class="flex h-11 w-11 shrink-0
                                   items-center justify-center
                                   rounded-full bg-[#17629b]/10
                                   text-sm font-bold text-[#17629b]"
                        >
                            {{ initials(internName) }}
                        </div>

                        <div>
                            <h2
                                class="text-base font-semibold
                                       text-gray-900"
                            >
                                {{ internName }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                {{
                                    selectedStage.sujet
                                    ?? 'Internship'
                                }}
                            </p>
                        </div>
                    </div>

                    <span
                        class="w-fit rounded-full bg-emerald-50
                               px-3 py-1.5 text-xs font-semibold
                               text-emerald-700"
                    >
                        100% completed
                    </span>
                </div>

                <!-- Form Body -->
                <div class="p-6">

                    <!-- Task Completion -->
                    <div
                        class="mb-6 flex items-center justify-between
                               rounded-xl bg-gray-50 px-4 py-3.5"
                    >
                        <div>
                            <p
                                class="text-xs font-medium
                                       text-gray-500"
                            >
                                Task completion
                            </p>

                            <p
                                class="mt-1 text-sm font-semibold
                                       text-gray-800"
                            >
                                {{ selectedStage.completed_tasks }}
                                /
                                {{ selectedStage.total_tasks }}
                                tasks completed
                            </p>
                        </div>

                        <div
                            class="flex h-9 w-9 items-center
                                   justify-center rounded-full
                                   bg-emerald-100 text-emerald-600"
                        >
                            <svg
                                class="h-5 w-5"
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
                        </div>
                    </div>

                    <form
                        class="space-y-6"
                        @submit.prevent="submit"
                    >

                        <!-- Evaluation Type -->
                        <div>
                            <label
                                class="mb-2 block text-sm
                                       font-semibold text-gray-700"
                            >
                                Evaluation Type
                            </label>

                            <select
                                v-model="form.type_evaluation"
                                class="block w-full rounded-xl
                                       border border-gray-300 bg-white
                                       px-4 py-3 text-sm text-gray-800
                                       shadow-sm outline-none transition
                                       focus:border-[#17629b]
                                       focus:ring-2
                                       focus:ring-[#17629b]/10"
                            >
                                <option value="finale">
                                    Final Evaluation
                                </option>

                                <option value="mi-parcours">
                                    Mid-term Evaluation
                                </option>
                            </select>

                            <p
                                v-if="form.errors.type_evaluation"
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{ form.errors.type_evaluation }}
                            </p>
                        </div>

                        <!-- Notes -->
                        <div class="grid gap-6 md:grid-cols-2">

                            <!-- Technical Note -->
                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-semibold text-gray-700"
                                >
                                    Technical Note
                                </label>

                                <div class="flex items-center gap-3">
                                    <input
                                        v-model="form.note_technique"
                                        type="number"
                                        min="0"
                                        max="20"
                                        step="0.5"
                                        placeholder="0"
                                        required
                                        class="block min-w-0 flex-1
                                               rounded-xl border
                                               border-gray-300 px-4 py-3
                                               text-sm text-gray-800
                                               shadow-sm outline-none
                                               transition
                                               focus:border-[#17629b]
                                               focus:ring-2
                                               focus:ring-[#17629b]/10"
                                    />

                                    <span
                                        class="shrink-0 text-sm
                                               font-semibold text-gray-400"
                                    >
                                        / 20
                                    </span>
                                </div>

                                <p
                                    v-if="form.errors.note_technique"
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{ form.errors.note_technique }}
                                </p>
                            </div>

                            <!-- Relational Note -->
                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-semibold text-gray-700"
                                >
                                    Relational Note
                                </label>

                                <div class="flex items-center gap-3">
                                    <input
                                        v-model="form.note_relationnelle"
                                        type="number"
                                        min="0"
                                        max="20"
                                        step="0.5"
                                        placeholder="0"
                                        required
                                        class="block min-w-0 flex-1
                                               rounded-xl border
                                               border-gray-300 px-4 py-3
                                               text-sm text-gray-800
                                               shadow-sm outline-none
                                               transition
                                               focus:border-[#17629b]
                                               focus:ring-2
                                               focus:ring-[#17629b]/10"
                                    />

                                    <span
                                        class="shrink-0 text-sm
                                               font-semibold text-gray-400"
                                    >
                                        / 20
                                    </span>
                                </div>

                                <p
                                    v-if="form.errors.note_relationnelle"
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{ form.errors.note_relationnelle }}
                                </p>
                            </div>
                        </div>

                        <!-- Global Note -->
                        <div
                            class="rounded-xl border border-gray-100
                                   bg-gray-50 p-4"
                        >
                            <div
                                class="mb-3 flex items-center
                                       justify-between"
                            >
                                <div>
                                    <p
                                        class="text-sm font-semibold
                                               text-gray-700"
                                    >
                                        Global Note
                                    </p>

                                    <p
                                        class="mt-0.5 text-xs
                                               text-gray-400"
                                    >
                                        Automatically calculated
                                        from the two notes
                                    </p>
                                </div>

                                <div
                                    class="text-xl font-bold
                                           text-[#17629b]"
                                >
                                    {{ globalNote ?? '—' }}

                                    <span
                                        class="text-sm font-semibold
                                               text-gray-400"
                                    >
                                        / 20
                                    </span>
                                </div>
                            </div>

                            <div
                                class="h-2.5 w-full overflow-hidden
                                       rounded-full bg-gray-200"
                            >
                                <div
                                    class="h-full rounded-full
                                           bg-[#17629b]
                                           transition-all duration-300"
                                    :style="{
                                        width: `${globalPercentage}%`
                                    }"
                                ></div>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div>
                            <div
                                class="mb-2 flex items-center
                                       justify-between"
                            >
                                <label
                                    class="text-sm font-semibold
                                           text-gray-700"
                                >
                                    Comment
                                </label>

                                <span
                                    class="text-xs text-gray-400"
                                >
                                    Optional
                                </span>
                            </div>

                            <textarea
                                v-model="form.remarque_encadrant"
                                rows="5"
                                placeholder="Share detailed feedback about the intern's performance..."
                                class="block w-full resize-none
                                       rounded-xl border border-gray-300
                                       px-4 py-3 text-sm text-gray-800
                                       shadow-sm outline-none transition
                                       placeholder:text-gray-400
                                       focus:border-[#17629b]
                                       focus:ring-2
                                       focus:ring-[#17629b]/10"
                            ></textarea>

                            <p
                                v-if="form.errors.remarque_encadrant"
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{ form.errors.remarque_encadrant }}
                            </p>
                        </div>

                        <!-- Backend Error -->
                        <div
                            v-if="form.errors.id_Stage"
                            class="rounded-xl border border-red-100
                                   bg-red-50 px-4 py-3
                                   text-sm text-red-700"
                        >
                            {{ form.errors.id_Stage }}
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex items-center gap-3
                                   border-t border-gray-100 pt-5"
                        >
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex items-center
                                       justify-center rounded-xl
                                       bg-[#17629b] px-6 py-3
                                       text-sm font-semibold text-white
                                       shadow-sm transition
                                       hover:bg-[#124f7e]
                                       disabled:cursor-not-allowed
                                       disabled:opacity-50"
                            >
                                <svg
                                    v-if="!form.processing"
                                    class="mr-2 h-4 w-4"
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

                                {{
                                    form.processing
                                        ? 'Submitting...'
                                        : 'Submit Evaluation'
                                }}
                            </button>

                            <Link
                                href="/encadrant/progress"
                                class="rounded-xl border
                                       border-gray-300 bg-white
                                       px-6 py-3 text-sm font-medium
                                       text-gray-600 transition
                                       hover:bg-gray-50
                                       hover:text-gray-900"
                            >
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ================================================= -->
            <!-- EVALUATED INTERNS -->
            <!-- Shown when clicking Evaluations in sidebar -->
            <!-- ================================================= -->

            <div
                v-else
                class="max-w-5xl overflow-hidden rounded-2xl
                       border border-gray-200 bg-white shadow-sm"
            >
                <!-- List Header -->
                <div
                    class="flex flex-col gap-3 border-b
                           border-gray-100 px-6 py-5
                           sm:flex-row sm:items-center
                           sm:justify-between"
                >
                    <div>
                        <h2
                            class="text-base font-semibold
                                   text-gray-900"
                        >
                            Evaluated Interns
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            View evaluations you have submitted.
                        </p>
                    </div>

                    <span
                        class="w-fit rounded-full bg-[#17629b]/10
                               px-3 py-1.5 text-xs font-semibold
                               text-[#17629b]"
                    >
                        {{ evaluations.data?.length ?? 0 }}
                        evaluations
                    </span>
                </div>

                <!-- Evaluation List -->
                <div
                    v-if="evaluations.data?.length"
                    class="divide-y divide-gray-100"
                >
                    <div
                        v-for="evaluation in evaluations.data"
                        :key="evaluation.id"
                        class="px-6 py-5 transition
                               hover:bg-gray-50/70"
                    >
                        <div
                            class="flex flex-col gap-5
                                   lg:flex-row lg:items-center
                                   lg:justify-between"
                        >
                            <!-- Intern Information -->
                            <div
                                class="flex min-w-0 items-center gap-4"
                            >
                                <div
                                    class="flex h-11 w-11 shrink-0
                                           items-center justify-center
                                           rounded-full bg-[#17629b]/10
                                           text-sm font-bold
                                           text-[#17629b]"
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
                                        class="truncate text-sm
                                               font-semibold
                                               text-gray-900"
                                    >
                                        {{
                                            evaluationInternName(
                                                evaluation
                                            )
                                        }}
                                    </h3>

                                    <p
                                        class="mt-1 truncate
                                               text-xs text-gray-500"
                                    >
                                        {{
                                            evaluation.stage?.sujet
                                            ?? 'Internship'
                                        }}
                                    </p>

                                    <span
                                        class="mt-2 inline-flex
                                               rounded-full bg-gray-100
                                               px-2.5 py-1
                                               text-[11px] font-medium
                                               text-gray-600"
                                    >
                                        {{
                                            evaluationType(
                                                evaluation.type_evaluation
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- Scores -->
                            <div
                                class="grid grid-cols-3 gap-4
                                       rounded-xl bg-gray-50
                                       px-5 py-3
                                       sm:min-w-[330px]"
                            >
                                <!-- Technical -->
                                <div>
                                    <p
                                        class="text-[11px]
                                               font-medium text-gray-400"
                                    >
                                        Technical
                                    </p>

                                    <p
                                        class="mt-1 text-sm
                                               font-semibold text-gray-700"
                                    >
                                        {{ evaluation.note_technique }}

                                        <span
                                            class="text-xs
                                                   text-gray-400"
                                        >
                                            /20
                                        </span>
                                    </p>
                                </div>

                                <!-- Relational -->
                                <div
                                    class="border-l border-gray-200
                                           pl-4"
                                >
                                    <p
                                        class="text-[11px]
                                               font-medium text-gray-400"
                                    >
                                        Relational
                                    </p>

                                    <p
                                        class="mt-1 text-sm
                                               font-semibold text-gray-700"
                                    >
                                        {{
                                            evaluation.note_relationnelle
                                        }}

                                        <span
                                            class="text-xs
                                                   text-gray-400"
                                        >
                                            /20
                                        </span>
                                    </p>
                                </div>

                                <!-- Global -->
                                <div
                                    class="border-l border-gray-200
                                           pl-4"
                                >
                                    <p
                                        class="text-[11px]
                                               font-medium text-gray-400"
                                    >
                                        Global
                                    </p>

                                    <p
                                        class="mt-1 text-base
                                               font-bold text-[#17629b]"
                                    >
                                        {{ evaluation.note_global }}

                                        <span
                                            class="text-xs
                                                   font-medium
                                                   text-gray-400"
                                        >
                                            /20
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div
                            v-if="evaluation.remarque_encadrant"
                            class="mt-4 rounded-xl bg-gray-50
                                   px-4 py-3"
                        >
                            <p
                                class="mb-1 text-[10px]
                                       font-semibold uppercase
                                       tracking-wide text-gray-400"
                            >
                                Supervisor Comment
                            </p>

                            <p
                                class="text-sm leading-6
                                       text-gray-600"
                            >
                                {{
                                    evaluation.remarque_encadrant
                                }}
                            </p>
                        </div>

                        <!-- Evaluation Date -->
                        <p
                            v-if="evaluation.date_evaluation"
                            class="mt-3 text-xs text-gray-400"
                        >
                            Evaluated:
                            {{ evaluation.date_evaluation }}
                        </p>
                    </div>
                </div>

                <!-- No Evaluations -->
                <div
                    v-else
                    class="px-6 py-16 text-center"
                >
                    <div
                        class="mx-auto flex h-12 w-12
                               items-center justify-center
                               rounded-full bg-gray-100
                               text-gray-400"
                    >
                        <svg
                            class="h-6 w-6"
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
                    </div>

                    <h3
                        class="mt-4 text-sm font-semibold
                               text-gray-900"
                    >
                        No evaluations yet
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Completed evaluations will appear here.
                    </p>

                    <Link
                        href="/encadrant/progress"
                        class="mt-5 inline-flex rounded-xl
                               bg-[#17629b] px-5 py-2.5
                               text-sm font-semibold text-white
                               transition hover:bg-[#124f7e]"
                    >
                        View Progress Tracking
                    </Link>
                </div>
            </div>

        </div>
    </EncadrantLayout>
</template>
