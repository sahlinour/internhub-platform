<script setup>
import ApplicationStatCard from './ApplicationStatCard.vue'
import SortDropdown from './Sortdropdown.vue'

defineProps({
    stats: {
        type: Object,
        required: true,
    },

    sortBy: {
        type: String,
        default: 'recently_updated',
    },
})

const emit = defineEmits(['update:sortBy'])
</script>

<template>
    <section>
        <!-- Header -->
        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-[#16425B]">
                    Applications
                </h1>

                <p class="mt-1 text-xs text-slate-500">
                    Track and manage your applications
                </p>
            </div>

            <SortDropdown
                :model-value="sortBy"
                @update:model-value="emit('update:sortBy', $event)"
            />
        </div>

        <!-- Statistics -->
        <div
            class="flex w-full gap-3 overflow-x-auto pb-1.5
                   [&::-webkit-scrollbar]:h-1.5
                   [&::-webkit-scrollbar-thumb]:rounded-full
                   [&::-webkit-scrollbar-thumb]:bg-slate-200
                   [&::-webkit-scrollbar-track]:bg-transparent"
        >
            <ApplicationStatCard
                title="Applied"
                :value="stats.applied"
                icon="document"
                color="blue"
            />

            <ApplicationStatCard
                title="Under Review"
                :value="stats.under_review"
                icon="clock"
                color="amber"
            />

            <ApplicationStatCard
                title="Interview"
                :value="stats.interview"
                icon="calendar"
                color="sky"
            />

            <ApplicationStatCard
                title="Offer"
                :value="stats.offer"
                icon="check"
                color="green"
            />

            <ApplicationStatCard
                title="Rejected"
                :value="stats.rejected"
                icon="x"
                color="red"
            />
        </div>
    </section>
</template>