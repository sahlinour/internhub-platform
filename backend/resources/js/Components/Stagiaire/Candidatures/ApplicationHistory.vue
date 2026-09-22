<script setup>
import ApplicationTable from './ApplicationTable.vue'

defineProps({
    candidatures: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <h2 class="text-sm font-bold text-[#16425B]">
                Application History
            </h2>

            <p class="mt-0.5 text-xs text-slate-400">
                Track the status and details of your applications.
            </p>
        </div>

        <ApplicationTable :candidatures="candidatures" />
    </section>
</template>
