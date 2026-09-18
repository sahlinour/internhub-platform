<script setup>
import { computed } from 'vue'

const props = defineProps({
    weeklyTasks: {
        type: Array,
        default: () => [],
    },
})

const allTasks = computed(() => {
    return props.weeklyTasks.flatMap((week) => week.tasks ?? [])
})

const totalTasks = computed(() => allTasks.value.length)

const completedTasks = computed(() => {
    return allTasks.value.filter(
        (task) => task.statut === 'Terminée'
    ).length
})

const inProgressTasks = computed(() => {
    return allTasks.value.filter(
        (task) => task.statut === 'En cours'
    ).length
})

const pendingTasks = computed(() => {
    return allTasks.value.filter(
        (task) => task.statut === 'À faire'
    ).length
})
</script>

<template>
    <section
        class="mb-6 grid grid-cols-2 gap-4
               lg:grid-cols-4"
    >

        <!-- Total -->
        <div
            class="rounded-xl border border-slate-100
                   bg-white p-4
                   shadow-[0_3px_12px_rgba(15,23,42,0.04)]"
        >
            <p
                class="text-[9px] font-bold uppercase
                       tracking-[1.2px] text-[#64748B]"
            >
                Total Tasks
            </p>

            <p
                class="mt-2 text-[22px] font-bold
                       text-[#16425B]"
            >
                {{ totalTasks }}
            </p>
        </div>

        <!-- Pending -->
        <div
            class="rounded-xl border border-slate-100
                   bg-white p-4
                   shadow-[0_3px_12px_rgba(15,23,42,0.04)]"
        >
            <p
                class="text-[9px] font-bold uppercase
                       tracking-[1.2px] text-[#64748B]"
            >
                To Do
            </p>

            <p
                class="mt-2 text-[22px] font-bold
                       text-[#E8A33D]"
            >
                {{ pendingTasks }}
            </p>
        </div>

        <!-- In Progress -->
        <div
            class="rounded-xl border border-slate-100
                   bg-white p-4
                   shadow-[0_3px_12px_rgba(15,23,42,0.04)]"
        >
            <p
                class="text-[9px] font-bold uppercase
                       tracking-[1.2px] text-[#64748B]"
            >
                In Progress
            </p>

            <p
                class="mt-2 text-[22px] font-bold
                       text-[#3A7CA5]"
            >
                {{ inProgressTasks }}
            </p>
        </div>

        <!-- Completed -->
        <div
            class="rounded-xl border border-slate-100
                   bg-white p-4
                   shadow-[0_3px_12px_rgba(15,23,42,0.04)]"
        >
            <p
                class="text-[9px] font-bold uppercase
                       tracking-[1.2px] text-[#64748B]"
            >
                Completed
            </p>

            <p
                class="mt-2 text-[22px] font-bold
                       text-[#2F6690]"
            >
                {{ completedTasks }}
            </p>
        </div>

    </section>
</template>