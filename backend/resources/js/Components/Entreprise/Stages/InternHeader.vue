<script setup>
defineProps({
    total: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <div
        class="flex flex-col gap-4
               sm:flex-row sm:items-center
               sm:justify-between"
    >
        <!-- LEFT : TITLE -->
        <div>
            <div class="flex items-center gap-2">
                <h1
                    class="text-2xl font-bold tracking-tight
                           text-[#16425B]"
                >
                    Current Interns
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
                Track your active internships,
                supervisors and internship progress.
            </p>
        </div>

        <!-- RIGHT : STAT -->
        <div
            class="flex w-fit items-center gap-3
                   rounded-xl border border-slate-200
                   bg-white px-5 py-4 shadow-sm"
        >
            <div
                class="flex h-9 w-9 items-center justify-center
                       rounded-lg bg-[#E8F1F5]
                       text-[#3A7CA5]"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17 20h5V4H2v16h5m10 0v-2a5 5 0 00-10 0v2m10 0H7m8-11a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                </svg>
            </div>

            <div>
                <p
                    class="text-[10px] font-semibold
                           uppercase tracking-wide
                           text-slate-400"
                >
                    Active Interns
                </p>

                <p
                    class="mt-0.5 text-lg font-bold
                           text-[#16425B]"
                >
                    {{ total }}
                </p>
            </div>
        </div>
    </div>
</template>