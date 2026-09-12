<script setup>
defineProps({
    total: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <div class="mb-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-[22px] font-bold text-[#16425B]">
                        Saved Opportunities
                    </h1>

                    <span
                        class="flex h-6 min-w-6 items-center justify-center
                               rounded-full bg-[#2F6690] px-2
                               text-[10px] font-bold text-white"
                    >
                        {{ total }}
                    </span>
                </div>

                <p class="mt-1 text-[12px] text-slate-500">
                    Keep track of internship opportunities you want to explore.
                </p>
            </div>
        </div>
    </div>
</template>