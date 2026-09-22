<script setup>
defineProps({
    total: {
        type: Number,
        default: 0,
    },
    displayed: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <div
        class="rounded-xl border
               border-slate-200 bg-white
               px-5 py-4 shadow-sm"
    >
        <div
            class="flex items-center
                   justify-between gap-4"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-9 w-9
                           items-center justify-center
                           rounded-lg bg-[#E8F1F5]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-[#3A7CA5]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1m-2 6H3v-2a4 4 0 014-4h4a4 4 0 014 4v2m-4-10a4 4 0 11-8 0 4 4 0 018 0zm9 0a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                </div>

                <div>
                    <p
                        class="text-[10px] font-semibold
                               uppercase tracking-wide
                               text-slate-400"
                    >
                        Total applicants
                    </p>

                    <p
                        class="mt-0.5 text-lg font-bold
                               text-[#16425B]"
                    >
                        {{ total }}
                    </p>
                </div>

            </div>

            <p
                class="text-[10px] text-slate-400"
            >
                {{ displayed }} displayed
            </p>

        </div>
    </div>
</template>