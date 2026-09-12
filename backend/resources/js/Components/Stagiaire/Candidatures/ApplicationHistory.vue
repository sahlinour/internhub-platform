<script setup>
import ApplicationTable from './ApplicationTable.vue'

defineProps({
    candidatures: {
        type: Array,
        default: () => [],
    },
})

const exportCsv = () => {
    window.location.href = route('stagiaire.candidatures.export')
}
</script>

<template>
    <section class="mt-8 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <!-- Header -->
        <div
            class="flex items-center justify-between border-b border-slate-100
                   px-4 py-4 sm:px-5"
        >
            <h2 class="text-sm font-bold text-slate-800">
                Application History
            </h2>

            <button
                type="button"
                @click="exportCsv"
                class="text-[11px] font-medium text-[#16425B]
                       transition hover:text-[#2F6690]"
            >
                Export CSV
            </button>
        </div>

        <ApplicationTable
            :candidatures="candidatures"
        />
    </section>
</template>