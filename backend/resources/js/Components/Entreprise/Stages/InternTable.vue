<script setup>
import { computed } from 'vue'
import InternTableRow from '@/Components/Entreprise/Stages/InternTableRow.vue'

const props = defineProps({
    stages: {
        type: Array,
        default: () => [],
    },

    getStudentName: {
        type: Function,
        required: true,
    },

    getStudentEmail: {
        type: Function,
        required: true,
    },

    getInternshipTitle: {
        type: Function,
        required: true,
    },

    getSupervisorName: {
        type: Function,
        required: true,
    },

    getInitials: {
        type: Function,
        required: true,
    },

    formatDate: {
        type: Function,
        required: true,
    },

    getTimeline: {
        type: Function,
        required: true,
    },

    getTimelinePercentage: {
        type: Function,
        required: true,
    },
})

const emit = defineEmits([
    'delete',
])
const validStages = computed(() => {
    return props.stages.filter((stage) => stage !== null)
})
</script>

<template>
    <div class="w-full">

        <!-- DESKTOP -->
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full min-w-[1050px] text-left">

                <thead
                    class="border-b border-slate-100
                           bg-slate-50/60"
                >
                    <tr
                        class="text-[10px] font-semibold
                               uppercase tracking-wide
                               text-slate-400"
                    >
                        <th class="px-5 py-3">
                            Intern
                        </th>

                        <th class="px-5 py-3">
                            Internship
                        </th>

                        <th class="px-5 py-3">
                            Supervisor
                        </th>

                        <th class="px-5 py-3">
                            Start Date
                        </th>

                        <th class="px-5 py-3">
                            End Date
                        </th>

                        <th class="px-5 py-3">
                            Timeline
                        </th>

                        <th class="px-5 py-3 text-right">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <InternTableRow
                        v-for="(stage, index) in validStages"
                        :key="stage.id ?? `stage-${index}`"
                        :stage="stage"
                        :get-student-name="getStudentName"
                        :get-student-email="getStudentEmail"
                        :get-internship-title="getInternshipTitle"
                        :get-supervisor-name="getSupervisorName"
                        :get-initials="getInitials"
                        :format-date="formatDate"
                        :get-timeline="getTimeline"
                        :get-timeline-percentage="getTimelinePercentage"
                        @delete="emit('delete', $event)"
                    />

                    <!-- EMPTY -->
                    <tr v-if="validStages.length === 0">
                        <td
                            colspan="7"
                            class="px-5 py-12 text-center"
                        >
                            <div
                                class="flex flex-col
                                       items-center
                                       justify-center"
                            >
                                <div
                                    class="flex h-10 w-10
                                           items-center
                                           justify-center
                                           rounded-full
                                           bg-[#F4F7F9]"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-slate-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17 20h5V4H2v16h5m10 0v-2a5 5 0 00-10 0v2m10 0H7m8-11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                </div>

                                <p
                                    class="mt-3 text-xs
                                           font-semibold
                                           text-[#16425B]"
                                >
                                    No current interns
                                </p>

                                <p
                                    class="mt-1 text-[10px]
                                           text-slate-400"
                                >
                                    Internships will appear here
                                    after they are created from
                                    accepted applications.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- MOBILE -->
        <div
            class="divide-y divide-slate-100 md:hidden"
        >
            <InternTableRow
                v-for="(stage, index) in validStages"
                :key="stage.id ?? `stage-mobile-${index}`"
                :stage="stage"
                :get-student-name="getStudentName"
                :get-student-email="getStudentEmail"
                :get-internship-title="getInternshipTitle"
                :get-supervisor-name="getSupervisorName"
                :get-initials="getInitials"
                :format-date="formatDate"
                :get-timeline="getTimeline"
                :get-timeline-percentage="getTimelinePercentage"
                @delete="emit('delete', $event)"
            />

            <div
                v-if="validStages.length === 0"
                class="px-5 py-12 text-center"
            >
                <div
                    class="flex flex-col
                           items-center
                           justify-center"
                >
                    <div
                        class="flex h-10 w-10
                               items-center
                               justify-center
                               rounded-full
                               bg-[#F4F7F9]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-slate-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M17 20h5V4H2v16h5m10 0v-2a5 5 0 00-10 0v2m10 0H7m8-11a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </div>

                    <p
                        class="mt-3 text-xs font-semibold
                               text-[#16425B]"
                    >
                        No current interns
                    </p>

                    <p
                        class="mt-1 text-[10px]
                               text-slate-400"
                    >
                        Internships will appear here after
                        they are created from accepted applications.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>