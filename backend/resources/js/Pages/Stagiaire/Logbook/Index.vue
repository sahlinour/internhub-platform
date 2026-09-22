```vue
<script setup>
import { ref } from 'vue'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

import LogbookHeader from '@/Components/Stagiaire/Logbook/LogbookHeader.vue'
import LogbookStats from '@/Components/Stagiaire/Logbook/LogbookStats.vue'
import WeeklyEntryCard from '@/Components/Stagiaire/Logbook/WeeklyEntryCard.vue'
import WeeklyEntryModal from '@/Components/Stagiaire/Logbook/WeeklyEntryModal.vue'
import LogbookPagination from '@/Components/Stagiaire/Logbook/LogbookPagination.vue'

const props = defineProps({
    stage: {
        type: Object,
        default: null,
    },

    weeklyTasks: {
        type: Array,
        default: () => [],
    },

    availableTasks: {
        type: Array,
        default: () => [],
    },
    evaluation: {
        type: Object,
        default: null,
    },
})
const showWeeklyEntryModal = ref(false)
</script>

<template>
    <StagiaireLayout>

        <div class="min-h-screen bg-[#F4F7F9]">

            <main
                class="mx-auto max-w-[1400px]
                       px-6 py-6"
            >

                <!-- Header -->
                <LogbookHeader
                    :stage="stage"
                    :weekly-tasks="weeklyTasks"
                    @new-entry="showWeeklyEntryModal = true"
                />

                <!-- No active internship -->
                <section
                    v-if="!stage"
                    class="rounded-xl border border-slate-100
                           bg-white p-10 text-center
                           shadow-[0_3px_12px_rgba(15,23,42,0.04)]"
                >
                    <h2
                        class="text-[17px] font-bold
                               text-[#16425B]"
                    >
                        No active internship
                    </h2>

                    <p
                        class="mt-2 text-[11px]
                               text-[#64748B]"
                    >
                        You do not have an active internship
                        at the moment.
                    </p>
                </section>

                <!-- Logbook -->
                <template v-else>

                   
                    <!-- Weekly Entries -->
                    <section>
                        <!-- Entries -->
                        <div
                            v-if="weeklyTasks.length"
                            class="space-y-5"
                        >

                            <WeeklyEntryCard
                                v-for="week in weeklyTasks"
                                :key="week.week"
                                :week="week"
                                :evaluation="evaluation"
                            />

                        </div>

                        <!-- Empty state -->
                        <section
                            v-else
                            class="rounded-xl
                                   border border-dashed
                                   border-slate-200
                                   bg-white px-6 py-12
                                   text-center"
                        >
                            <div
                                class="mx-auto flex h-12 w-12
                                       items-center justify-center
                                       rounded-xl
                                       bg-[#E8F1F5]
                                       text-[#2F6690]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5Z"
                                    />
                                    <path d="M8 7h8" />
                                    <path d="M8 11h8" />
                                    <path d="M8 15h5" />
                                </svg>
                            </div>

                            <h3
                                class="mt-4 text-[14px]
                                       font-bold
                                       text-[#16425B]"
                            >
                                No weekly entries yet
                            </h3>

                            <p
                                class="mx-auto mt-1.5 max-w-[420px]
                                       text-[10px] leading-5
                                       text-[#64748B]"
                            >
                                Your weekly activities will appear
                                here when tasks are assigned to your
                                internship.
                            </p>
                        </section>

                    </section>

                    <!-- Pagination -->
                    <LogbookPagination
                        :links="[]"
                    />

                </template>

            </main>

        </div>

        <WeeklyEntryModal
            :stage="stage"
            :weekly-tasks="weeklyTasks"
            :available-tasks="availableTasks"
            :show="showWeeklyEntryModal"
            @close="showWeeklyEntryModal = false"
            @save="handleSaveWeeklyEntry"
        />
    </StagiaireLayout>
</template>
```
