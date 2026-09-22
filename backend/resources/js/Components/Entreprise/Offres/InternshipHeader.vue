<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    createUrl: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[#16425B]">
                Internships
            </h1>

            <p class="mt-1 text-xs text-slate-500">
                Manage your posted internship listings
            </p>
        </div>

        <Link
            :href="createUrl"
            class="inline-flex shrink-0 items-center justify-center gap-2
                   rounded-xl bg-[#102F42] px-4 py-2.5
                   text-xs font-semibold text-white shadow-sm
                   transition hover:bg-[#174E6D]"
        >
            <span class="text-base leading-none">+</span>
            Post New Internship
        </Link>
    </div>
</template>