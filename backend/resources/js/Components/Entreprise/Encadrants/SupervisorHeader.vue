<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    total: {
        type: Number,
        default: 0,
    },
    createUrl: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <div
        class="flex flex-col gap-4
               sm:flex-row sm:items-center
               sm:justify-between"
    >
        <!-- LEFT -->
        <div>
            <div class="flex items-center gap-2">
                <h1
                    class="text-2xl font-bold tracking-tight
                           text-[#16425B]"
                >
                    Company Supervisors
                </h1>

                <span
                    class="rounded-full bg-[#E8F1F5]
                           px-2.5 py-1
                           text-[10px] font-bold
                           text-[#3A7CA5]"
                >
                    {{ total }}
                </span>
            </div>

            <p class="mt-1 text-xs text-slate-400">
                Team leads supervising your interns.
            </p>
        </div>

        <!-- RIGHT -->
        <Link
            :href="createUrl"
            class="inline-flex w-fit items-center
                   justify-center gap-2
                   rounded-xl bg-[#16425B]
                   px-4 py-2.5
                   text-xs font-semibold text-white
                   shadow-sm transition
                   hover:bg-[#12364B]"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            Add Supervisor
        </Link>
    </div>
</template>