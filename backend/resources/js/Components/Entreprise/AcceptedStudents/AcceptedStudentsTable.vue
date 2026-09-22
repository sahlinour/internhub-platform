<script setup>
import AcceptedStudentsRow from './AcceptedStudentsRow.vue'

defineProps({
    students: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <div class="w-full">
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full min-w-[900px] text-left">
                <thead
                    class="border-b border-slate-100
                           bg-slate-50/60"
                >
                    <tr
                        class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wide
                               text-slate-400"
                    >
                        <th class="px-5 py-3">
                            Student
                        </th>

                        <th class="px-5 py-3">
                            Internship
                        </th>

                        <th class="px-5 py-3">
                            Start Date
                        </th>

                        <th class="px-5 py-3">
                            Status
                        </th>

                        <th class="px-5 py-3 text-right">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <AcceptedStudentsRow
                        v-for="candidature in students"
                        :key="candidature.id"
                        :candidature="candidature"
                    />

                    <tr v-if="!students.length">
                        <td
                            colspan="5"
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
                                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 0 2 2 4-4"
                                        />
                                    </svg>
                                </div>
                                <p
                                    class="mt-3 text-xs
                                           font-semibold
                                           text-[#16425B]"
                                >
                                    No accepted students yet
                                </p>

                                <p
                                    class="mt-1 text-[10px]
                                           text-slate-400"
                                >
                                    Students will appear here
                                    once you accept their
                                    internship applications.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            class="divide-y divide-slate-100
                   md:hidden"
        >
            <AcceptedStudentsRow
                v-for="candidature in students"
                :key="candidature.id"
                :candidature="candidature"
            />

            <div
                v-if="!students.length"
                class="px-5 py-12 text-center"
            >
                <p
                    class="text-xs font-semibold
                           text-[#16425B]"
                >
                    No accepted students yet
                </p>

                <p
                    class="mt-1 text-[10px]
                           text-slate-400"
                >
                    Students will appear here
                    once you accept their
                    internship applications.
                </p>
            </div>
        </div>
    </div>
</template>