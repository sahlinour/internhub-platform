<script setup>
defineProps({
    fileName: {
        type: String,
        default: '',
    },
})
</script>

<template>
    <section
        class="rounded-2xl border border-[#E2E8F0] bg-white p-10 shadow-[0_2px_12px_rgba(22,66,91,0.05)]"
    >
        <div class="mx-auto max-w-md text-center">

            <!-- Loading icon -->
            <div
                class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-[#E8F1F5]"
            >
                <div
                    class="h-7 w-7 animate-spin rounded-full border-[3px] border-[#81C3D7]/30 border-t-[#2F6690]"
                ></div>
            </div>

            <h2
                class="mt-5 text-[17px] font-bold text-[#16425B]"
            >
                Analyzing your CV...
            </h2>

            <p
                class="mt-2 text-[11px] leading-5 text-[#64748B]"
            >
                We're comparing your skills with available
                internship offers.
            </p>

            <!-- File -->
            <p
                class="mt-4 truncate rounded-lg bg-[#F4F7F9] px-3 py-2 text-[10px] text-[#64748B]"
            >
                {{ fileName }}
            </p>

        </div>
    </section>
</template>