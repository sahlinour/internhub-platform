<script setup>
const props = defineProps({
    stage: {
        type: Object,
        required: true,
    },
    tasks: {
        type: Array,
        default: () => [],
    },
    documents: {
        type: Array,
        default: () => [],
    },
    evaluation: {
        type: Object,
        default: null,
    },
})

const formatDate = (date) => {
    if (!date) return '-'

    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    })
}
</script>

<template>
    <section
        class="rounded-xl border border-slate-100
               bg-white p-5
               shadow-[0_3px_12px_rgba(15,23,42,0.04)]"
    >

        <div class="mb-5">

            <p
                class="text-[9px] font-bold uppercase
                       tracking-[1.4px] text-[#3A7CA5]"
            >
                Your internship
            </p>

            <h2
                class="mt-1 text-[17px] font-bold
                       text-[#16425B]"
            >
                Internship Timeline
            </h2>

            <p
                class="mt-1 text-[10px]
                       text-[#64748B]"
            >
                Follow the main milestones of your
                internship.
            </p>

        </div>

        <div class="space-y-0">

            <!-- Internship Accepted -->
            <div class="flex gap-4">

                <div class="flex flex-col items-center">

                    <div
                        class="flex h-8 w-8 shrink-0
                               items-center justify-center
                               rounded-full
                               bg-[#e8f1f5]
                               text-[#2f6690]"
                    >
                        ✓
                    </div>

                    <div
                        class="h-full min-h-[55px]
                               w-px bg-[#e2edf2]"
                    ></div>

                </div>

                <div class="pb-6">

                    <h3
                        class="text-[12px] font-semibold
                               text-[#16425B]"
                    >
                        Internship Accepted
                    </h3>

                    <p
                        class="mt-0.5 text-[9px]
                               text-[#64748B]"
                    >
                        Application accepted
                    </p>

                    <p
                        v-if="stage.candidature?.date_postulation"
                        class="mt-1 text-[9px]
                               font-medium text-[#3A7CA5]"
                    >
                        Applied:
                        {{ formatDate(
                            stage.candidature.date_postulation
                        ) }}
                    </p>

                </div>

            </div>

            <!-- First Day -->
            <div class="flex gap-4">

                <div class="flex flex-col items-center">

                    <div
                        class="flex h-8 w-8 shrink-0
                               items-center justify-center
                               rounded-full
                               bg-[#e8f1f5]
                               text-[#2f6690]"
                    >
                        2
                    </div>

                    <div
                        class="h-full min-h-[55px]
                               w-px bg-[#e2edf2]"
                    ></div>

                </div>

                <div class="pb-6">

                    <h3
                        class="text-[12px] font-semibold
                               text-[#16425B]"
                    >
                        First Day
                    </h3>

                    <p
                        class="mt-0.5 text-[9px]
                               text-[#64748B]"
                    >
                        Internship officially started
                    </p>

                    <p
                        class="mt-1 text-[9px]
                               font-medium text-[#3A7CA5]"
                    >
                        {{ formatDate(stage.date_debut) }}
                    </p>

                </div>

            </div>

            <!-- Supervisor & Company -->
            <div class="flex gap-4">

                <div class="flex flex-col items-center">

                    <div
                        class="flex h-8 w-8 shrink-0
                               items-center justify-center
                               rounded-full
                               bg-[#e8f1f5]
                               text-[#2f6690]"
                    >
                        3
                    </div>

                    <div
                        class="h-full min-h-[55px]
                               w-px bg-[#e2edf2]"
                    ></div>

                </div>

                <div class="pb-6">

                    <h3
                        class="text-[12px] font-semibold
                               text-[#16425B]"
                    >
                        Supervisor & Company Assigned
                    </h3>

                    <p
                        class="mt-0.5 text-[9px]
                               text-[#64748B]"
                    >
                        {{ stage.encadrant?.user?.nom_complet ?? '—' }}
                    </p>

                    <p
                        class="mt-1 text-[9px]
                               font-medium text-[#3A7CA5]"
                    >
                        {{ formatDate(stage.date_debut) }}
                    </p>

                </div>

            </div>

            <!-- Weekly Progress -->
            <div class="flex gap-4">

                <div class="flex flex-col items-center">

                    <div
                        class="flex h-8 w-8 shrink-0
                               items-center justify-center
                               rounded-full
                               bg-[#2f6690]
                               text-[11px] font-bold
                               text-white"
                    >
                        4
                    </div>

                    <div
                        class="h-full min-h-[55px]
                               w-px bg-[#e2edf2]"
                    ></div>

                </div>

                <div class="pb-6">

                    <h3
                        class="text-[12px] font-semibold
                               text-[#16425B]"
                    >
                        Weekly Progress
                    </h3>

                    <p
                        class="mt-0.5 text-[9px]
                               text-[#64748B]"
                    >
                        {{ tasks.length }} task(s)
                        assigned to this internship
                    </p>

                    <p
                        class="mt-1 text-[9px]
                               font-medium text-[#3A7CA5]"
                    >
                        Current
                    </p>

                </div>

            </div>

            <!-- Final Evaluation -->
            <div class="flex gap-4">

                <div class="flex flex-col items-center">

                    <div
                        class="flex h-8 w-8 shrink-0
                               items-center justify-center
                               rounded-full"
                        :class="evaluation
                            ? 'bg-[#e9f7ef] text-[#459d69]'
                            : 'bg-[#eef5f8] text-[#64748b]'"
                    >
                        5
                    </div>

                    <div
                        class="h-full min-h-[55px]
                               w-px bg-[#e2edf2]"
                    ></div>

                </div>

                <div class="pb-6">

                    <h3
                        class="text-[12px] font-semibold
                               text-[#16425B]"
                    >
                        Final Evaluation
                    </h3>

                    <p
                        class="mt-0.5 text-[9px]
                               text-[#64748B]"
                    >
                        {{
                            evaluation
                                ? `Overall score: ${evaluation.note_global}/20`
                                : 'Not available yet'
                        }}
                    </p>

                    <p
                        v-if="evaluation"
                        class="mt-1 text-[9px]
                               font-medium text-[#3A7CA5]"
                    >
                        {{ formatDate(
                            evaluation.date_evaluation
                        ) }}
                    </p>

                </div>

            </div>

            <!-- Completion -->
            <div class="flex gap-4">

                <div
                    class="flex h-8 w-8 shrink-0
                           items-center justify-center
                           rounded-full"
                    :class="stage.statut === 'Terminée'
                        ? 'bg-[#e9f7ef] text-[#459d69]'
                        : 'bg-[#eef5f8] text-[#64748b]'"
                >
                    ✓
                </div>

                <div>

                    <h3
                        class="text-[12px] font-semibold
                               text-[#16425B]"
                    >
                        Internship Completed
                    </h3>

                    <p
                        class="mt-0.5 text-[9px]
                               text-[#64748B]"
                    >
                        Expected completion date
                    </p>

                    <p
                        class="mt-1 text-[9px]
                               font-medium text-[#3A7CA5]"
                    >
                        {{ formatDate(stage.date_fin) }}
                    </p>

                </div>

            </div>

        </div>
    </section>
</template>