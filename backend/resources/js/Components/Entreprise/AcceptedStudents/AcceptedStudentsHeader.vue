<script setup>
defineProps({
    total: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <div>
        <div class="flex items-center gap-2">
            <h1
                class="text-2xl font-bold tracking-tight text-[#16425B]"
            >
                Accepted Students
            </h1>

            <span
                class="rounded-full bg-[#E8F1F5]
                       px-2.5 py-1
                       text-[10px] font-semibold
                       text-[#3A7CA5]"
            >
                {{ total }}
            </span>
        </div>

        <p class="mt-1 text-xs text-slate-400">
            Students accepted for your internship offers.
        </p>
    </div>
</template>