<script setup>
import InternshipStatCard from './InternshipStatCard.vue'

defineProps({
    stats: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <div
        class="flex w-full gap-3 overflow-x-auto pb-1.5
               [&::-webkit-scrollbar]:h-1.5
               [&::-webkit-scrollbar-thumb]:rounded-full
               [&::-webkit-scrollbar-thumb]:bg-slate-200
               [&::-webkit-scrollbar-track]:bg-transparent"
    >
        <InternshipStatCard
            title="Total Postings"
            :value="stats.total"
            icon="briefcase"
            color="blue"
        />

        <InternshipStatCard
            title="Open"
            :value="stats.ouverte"
            icon="check"
            color="green"
        />

        <InternshipStatCard
            title="Pending"
            :value="stats.en_attente"
            icon="briefcase"
            color="amber"
        />

        <InternshipStatCard
            title="Closed"
            :value="stats.fermee"
            icon="briefcase"
            color="red"
        />
    </div>
</template>