<script setup>
const emit = defineEmits(['reset'])
</script>

<template>
    <div
        class="rounded-2xl border border-[#E2E8F0] bg-white p-10 text-center shadow-[0_2px_12px_rgba(22,66,91,0.04)]"
    >

        <!-- Icon -->
        <div
            class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#E8F1F5] text-[#2F6690]"
        >
            <svg
                class="h-6 w-6"
                viewBox="0 0 24 24"
                fill="none"
            >
                <path
                    d="M9 12h6M9 16h4"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

                <path
                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M14 2v6h6"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
            </svg>
        </div>

        <h3
            class="mt-4 text-[16px] font-bold text-[#16425B]"
        >
            No matching offers found
        </h3>

        <p
            class="mx-auto mt-2 max-w-md text-[11px] leading-5 text-[#64748B]"
        >
            There are currently no internship offers matching
            the skills detected in your CV.
        </p>

        <button
            type="button"
            class="mt-5 rounded-lg bg-[#16425B] px-4 py-2.5 text-[11px] font-semibold text-white transition hover:bg-[#2F6690]"
            @click="emit('reset')"
        >
            Try another CV
        </button>

    </div>
</template>