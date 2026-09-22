<script setup>
defineProps({
    stage: {
        type: Object,
        required: true,
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
</script>

<template>

    <!-- DESKTOP -->
    <tr
        class="hidden border-b border-slate-100
               last:border-0 transition
               hover:bg-[#F4F7F9]
               md:table-row"
    >

        <!-- INTERN -->
        <td class="px-5 py-4 align-top">
            <div class="flex items-center gap-3">

                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           rounded-full
                           bg-[#E8F1F5]
                           text-[10px] font-bold
                           text-[#16425B]"
                >
                    {{
                        getInitials(
                            getStudentName(stage)
                        )
                    }}
                </div>

                <div class="min-w-0">
                    <p
                        class="truncate text-xs
                               font-bold text-[#16425B]"
                    >
                        {{ getStudentName(stage) }}
                    </p>

                    <p
                        class="mt-0.5 truncate
                               text-[10px] text-slate-400"
                    >
                        {{ getStudentEmail(stage) }}
                    </p>
                </div>

            </div>
        </td>

        <!-- INTERNSHIP -->
        <td class="px-5 py-4 align-top">
            <p
                class="max-w-[190px] truncate
                       text-xs font-semibold
                       text-slate-700"
            >
                {{ getInternshipTitle(stage) }}
            </p>

            <p
                v-if="
                    stage?.sujet &&
                    stage.sujet !== getInternshipTitle(stage)
                "
                class="mt-1 max-w-[190px] truncate
                       text-[10px] text-slate-400"
            >
                {{ stage.sujet }}
            </p>
        </td>

        <!-- SUPERVISOR -->
        <td class="px-5 py-4 align-top">

            <span
                v-if="stage?.encadrant?.user"
                class="inline-flex items-center
                       rounded-full
                       bg-emerald-50
                       px-2.5 py-1
                       text-[10px] font-semibold
                       text-emerald-600"
            >
                {{ getSupervisorName(stage) }}
            </span>

            <span
                v-else
                class="inline-flex items-center
                       rounded-full
                       bg-amber-50
                       px-2.5 py-1
                       text-[10px] font-semibold
                       text-amber-600"
            >
                Not assigned
            </span>

        </td>

        <!-- START DATE -->
        <td
            class="whitespace-nowrap
                   px-5 py-4 align-top"
        >
            <span
                class="text-xs font-medium
                       text-slate-700"
            >
                {{ formatDate(stage?.date_debut) }}
            </span>
        </td>

        <!-- END DATE -->
        <td
            class="whitespace-nowrap
                   px-5 py-4 align-top"
        >
            <span
                class="text-xs font-medium
                       text-slate-700"
            >
                {{ formatDate(stage?.date_fin) }}
            </span>
        </td>

        <!-- TIMELINE -->
        <td class="min-w-[160px] px-5 py-4 align-top">

            <div
                class="flex items-center
                       justify-between gap-2"
            >
                <span
                    class="whitespace-nowrap
                           text-[10px] font-semibold
                           text-slate-600"
                >
                    {{ getTimeline(stage) }}
                </span>

                <span
                    class="text-[10px] font-medium
                           text-slate-400"
                >
                    {{ getTimelinePercentage(stage) }}%
                </span>
            </div>

            <div
                v-if="
                    stage?.date_debut &&
                    stage?.date_fin
                "
                class="mt-2 h-1.5 w-full
                       overflow-hidden rounded-full
                       bg-slate-100"
            >
                <div
                    class="h-full rounded-full
                           bg-[#3A7CA5]
                           transition-all"
                    :style="{
                        width:
                            getTimelinePercentage(stage) + '%',
                    }"
                ></div>
            </div>

        </td>

        <!-- ACTIONS -->
        <td
            class="whitespace-nowrap
                   px-5 py-4 text-right
                   align-top"
        >
            <button
                type="button"
                class="inline-flex items-center gap-1.5
                       rounded-lg
                       border border-red-100
                       bg-red-50
                       px-3 py-2
                       text-xs font-semibold
                       text-red-500
                       transition
                       hover:border-red-200
                       hover:bg-red-100"
                @click="emit('delete', stage)"
            >
                Delete
            </button>
        </td>

    </tr>

    <!-- MOBILE -->
    <article
        class="p-4 md:hidden"
    >

        <!-- TOP -->
        <div
            class="flex items-start
                   justify-between gap-3"
        >

            <div
                class="flex min-w-0
                       items-center gap-3"
            >
                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           rounded-full
                           bg-[#E8F1F5]
                           text-[10px] font-bold
                           text-[#16425B]"
                >
                    {{
                        getInitials(
                            getStudentName(stage)
                        )
                    }}
                </div>

                <div class="min-w-0">
                    <p
                        class="truncate text-xs
                               font-bold text-[#16425B]"
                    >
                        {{ getStudentName(stage) }}
                    </p>

                    <p
                        class="mt-0.5 truncate
                               text-[10px] text-slate-400"
                    >
                        {{ getStudentEmail(stage) }}
                    </p>
                </div>
            </div>

            <span
                v-if="stage?.encadrant?.user"
                class="shrink-0 rounded-full
                       bg-emerald-50
                       px-2.5 py-1
                       text-[10px] font-semibold
                       text-emerald-600"
            >
                Assigned
            </span>

            <span
                v-else
                class="shrink-0 rounded-full
                       bg-amber-50
                       px-2.5 py-1
                       text-[10px] font-semibold
                       text-amber-600"
            >
                Pending
            </span>

        </div>

        <!-- DETAILS -->
        <div
            class="mt-4 grid grid-cols-2 gap-2
                   rounded-xl bg-[#F4F7F9] p-3"
        >

            <div>
                <p
                    class="text-[9px] font-semibold
                           uppercase tracking-wide
                           text-slate-400"
                >
                    Internship
                </p>

                <p
                    class="mt-1 truncate
                           text-[10px] font-semibold
                           text-slate-700"
                >
                    {{ getInternshipTitle(stage) }}
                </p>
            </div>

            <div>
                <p
                    class="text-[9px] font-semibold
                           uppercase tracking-wide
                           text-slate-400"
                >
                    Supervisor
                </p>

                <p
                    class="mt-1 truncate
                           text-[10px] font-semibold
                           text-slate-700"
                >
                    {{ getSupervisorName(stage) }}
                </p>
            </div>

            <div>
                <p
                    class="text-[9px] font-semibold
                           uppercase tracking-wide
                           text-slate-400"
                >
                    Start
                </p>

                <p
                    class="mt-1 text-[10px]
                           font-medium text-slate-700"
                >
                    {{ formatDate(stage?.date_debut) }}
                </p>
            </div>

            <div>
                <p
                    class="text-[9px] font-semibold
                           uppercase tracking-wide
                           text-slate-400"
                >
                    End
                </p>

                <p
                    class="mt-1 text-[10px]
                           font-medium text-slate-700"
                >
                    {{ formatDate(stage?.date_fin) }}
                </p>
            </div>

            <div class="col-span-2">

                <div
                    class="flex items-center
                           justify-between"
                >
                    <p
                        class="text-[9px] font-semibold
                               uppercase tracking-wide
                               text-slate-400"
                    >
                        Timeline
                    </p>

                    <span
                        class="text-[10px]
                               font-semibold
                               text-[#3A7CA5]"
                    >
                        {{ getTimelinePercentage(stage) }}%
                    </span>
                </div>

                <p
                    class="mt-1 text-[10px]
                           font-medium text-slate-700"
                >
                    {{ getTimeline(stage) }}
                </p>

                <div
                    v-if="
                        stage?.date_debut &&
                        stage?.date_fin
                    "
                    class="mt-2 h-1.5 w-full
                           overflow-hidden rounded-full
                           bg-white"
                >
                    <div
                        class="h-full rounded-full
                               bg-[#3A7CA5]"
                        :style="{
                            width:
                                getTimelinePercentage(stage) + '%',
                        }"
                    ></div>
                </div>

            </div>

        </div>

        <!-- ACTIONS -->
        <div
            class="mt-3 flex justify-end gap-2"
        >
            <button
                type="button"
                class="inline-flex items-center gap-1.5
                       rounded-lg
                       border border-red-100
                       bg-red-50
                       px-3 py-2
                       text-xs font-semibold
                       text-red-500
                       transition
                       hover:border-red-200
                       hover:bg-red-100"
                @click="emit('delete', stage)"
            >
                Delete
            </button>
        </div>
    </article>
</template>