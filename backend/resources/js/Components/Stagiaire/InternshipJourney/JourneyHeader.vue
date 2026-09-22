<script setup>
import { computed } from 'vue'

const props = defineProps({
    stage: {
        type: Object,
        default: null,
    },
    currentWeek: {
        type: Number,
        default: 0,
    },
    totalWeeks: {
        type: Number,
        default: 0,
    },
    progress: {
        type: Number,
        default: 0,
    },
    isOnTrack: {
        type: Boolean,
        default: false,
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

const statusLabel = computed(() => {
    if (!props.stage) return ''

    return props.isOnTrack
        ? 'On Track'
        : props.stage.statut
})
</script>

<template>
    <section
        class="relative mb-6 overflow-hidden rounded-2xl
               bg-gradient-to-r from-[#16425B] to-[#2F6690]
               px-6 py-6 text-white
               shadow-[0_8px_25px_rgba(22,66,91,0.12)]"
    >

        <div
            class="absolute -right-10 -top-14
                   h-36 w-36 rounded-full
                   bg-white/[0.06]"
        ></div>

        <div
            class="absolute -bottom-16 right-24
                   h-32 w-32 rounded-full
                   bg-[#81C3D7]/10"
        ></div>

        <div class="relative">

            <div
                class="mb-4 flex flex-col
                       justify-between gap-4
                       md:flex-row md:items-start"
            >

                <div>
                    <p
                        class="mb-1 text-[9px] font-bold
                               uppercase tracking-[1.5px]
                               text-[#81C3D7]"
                    >
                        Internship Journey
                    </p>

                    <h1
                        class="text-[25px] font-bold
                               tracking-[-0.4px]"
                    >
                        {{ stage?.sujet ?? 'Internship Journey' }}
                    </h1>

                    <p
                        v-if="stage"
                        class="mt-1 text-[11px]
                               text-white/65"
                    >
                        {{ formatDate(stage.date_debut) }}
                        —
                        {{ formatDate(stage.date_fin) }}
                    </p>
                </div>

                <div
                    v-if="stage"
                    class="shrink-0 text-left md:text-right"
                >
                    <p
                        class="text-[10px] font-medium
                               text-white/55"
                    >
                        Internship Progress
                    </p>

                    <p
                        class="mt-0.5 text-[17px]
                               font-bold"
                    >
                        Week {{ currentWeek }}
                        of {{ totalWeeks }}
                    </p>

                    <span
                        class="mt-1 inline-flex
                               items-center gap-1.5
                               text-[10px] font-semibold
                               text-[#81C3D7]"
                    >
                        <span
                            class="h-1.5 w-1.5
                                   rounded-full bg-[#81C3D7]"
                        ></span>

                        {{ statusLabel }}
                    </span>
                </div>

            </div>

            <div v-if="stage">

                <div
                    class="mb-1.5 flex items-center
                           justify-between"
                >
                    <span
                        class="text-[10px] font-medium
                               text-white/60"
                    >
                        Overall Progress
                    </span>

                    <span
                        class="text-[11px] font-bold"
                    >
                        {{ progress }}%
                    </span>
                </div>

                <div
                    class="h-1.5 overflow-hidden
                           rounded-full bg-white/15"
                >
                    <div
                        class="h-full rounded-full
                               bg-[#81C3D7]
                               transition-all duration-500"
                        :style="{
                            width: `${progress}%`
                        }"
                    ></div>
                </div>
            </div>
        </div>
    </section>
</template>