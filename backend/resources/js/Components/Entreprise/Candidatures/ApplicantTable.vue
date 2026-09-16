<script setup>
import ApplicantRow from './ApplicantRow.vue'

defineProps({
    applications: {
        type: Array,
        default: () => [],
    },
})

defineEmits(['update-status'])
</script>

<template>
    <div class="w-full">

        <!-- DESKTOP -->
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full min-w-[900px] text-left">

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
                            Applicant
                        </th>

                        <th class="px-5 py-3">
                            Internship
                        </th>

                        <th class="px-5 py-3">
                            Applied
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
                    <ApplicantRow
                        v-for="candidature in applications"
                        :key="candidature.id"
                        :candidature="candidature"
                        @update-status="
                            (candidature, statut) =>
                                $emit(
                                    'update-status',
                                    candidature,
                                    statut
                                )
                        "
                    />

                    <!-- EMPTY -->
                    <tr v-if="!applications.length">
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
                                            d="M17 20h5v-2a4 4 0 00-4-4h-1m-2 6H3v-2a4 4 0 014-4h4a4 4 0 014 4v2m-4-10a4 4 0 11-8 0 4 4 0 018 0zm9 0a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                </div>

                                <p
                                    class="mt-3 text-xs
                                           font-semibold
                                           text-[#16425B]"
                                >
                                    No applicants found
                                </p>

                                <p
                                    class="mt-1 text-[10px]
                                           text-slate-400"
                                >
                                    No applications match
                                    the selected filters.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <!-- MOBILE -->
        <div
            class="divide-y divide-slate-100
                   md:hidden"
        >
            <ApplicantRow
                v-for="candidature in applications"
                :key="candidature.id"
                :candidature="candidature"
                @update-status="
                    (candidature, statut) =>
                        $emit(
                            'update-status',
                            candidature,
                            statut
                        )
                "
            />

            <div
                v-if="!applications.length"
                class="px-5 py-12 text-center"
            >
                <p
                    class="text-xs font-semibold
                           text-[#16425B]"
                >
                    No applicants found
                </p>

                <p
                    class="mt-1 text-[10px]
                           text-slate-400"
                >
                    No applications match
                    the selected filters.
                </p>
            </div>
        </div>

    </div>
</template>