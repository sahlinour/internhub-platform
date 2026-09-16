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
        <div class="flex items-center gap-3">
            <h1
                class="text-2xl font-bold tracking-tight
                       text-[#16425B]"
            >
                Applicants
            </h1>

            <span
                class="rounded-full bg-[#E8F1F5]
                       px-2.5 py-1 text-[10px]
                       font-semibold text-[#3A7CA5]"
            >
                {{ total }}
            </span>
        </div>

        <p
            class="mt-1 text-sm text-slate-500"
        >
            Review and manage applicants for your
            internship offers.
        </p>
    </div>
</template>