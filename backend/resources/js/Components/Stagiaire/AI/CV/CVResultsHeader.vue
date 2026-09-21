<script setup>
defineProps({
    count: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <div
        class="mb-3 mt-7 flex items-end justify-between"
    >

        <div>
            <p
                class="text-[9px] font-bold uppercase tracking-[1px] text-[#3A7CA5]"
            >
                AI recommendations
            </p>

            <h2
                class="mt-1 text-[18px] font-bold text-[#16425B]"
            >
                Internship matches
            </h2>
        </div>

        <span
            class="rounded-full bg-[#E8F1F5] px-3 py-1.5 text-[9px] font-bold text-[#2F6690]"
        >
            Top {{ count }}
        </span>

    </div>
</template>