<script setup>
import { ref } from 'vue'

defineProps({
    stage: {
        type: Object,
        default: null,
    },

    weeklyTasks: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['new-entry'])

const openWeeklyEntry = () => {
    emit('new-entry')
}
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
                class="flex flex-col
                       justify-between gap-4
                       md:flex-row md:items-center"
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
                        My Logbook
                    </h1>

                    <p
                        class="mt-1 max-w-[550px]
                               text-[11px] leading-5
                               text-white/65"
                    >
                        Keep track of your weekly internship activities
                        and progress.
                    </p>
                </div>

                <button
                type="button"
                class="shrink-0 rounded-lg
                    bg-white px-4 py-2.5
                    text-[10px] font-bold
                    text-[#16425B]
                    shadow-sm transition
                    hover:bg-[#E8F1F5]"
                @click="openWeeklyEntry"
            >
                + New Weekly Entry
            </button>

            </div>

        </div>
    </section>
</template>