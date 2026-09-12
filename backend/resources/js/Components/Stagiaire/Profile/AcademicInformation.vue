<script setup>
defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <section
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
    >
        <!-- Header -->
        <div class="mb-5 flex items-center gap-3">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F1F5] text-[#2F6690]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 14l9-5-9-5-9 5 9 5z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 12.5V16c0 1.105 3.134 3 7 3s7-1.895 7-3v-3.5"
                    />
                </svg>
            </div>

            <div>
                <h3 class="font-semibold text-[#16425B]">
                    Academic Information
                </h3>

                <p class="text-xs text-[#64748B]">
                    Your education and academic background
                </p>
            </div>
        </div>

        <!-- Information -->
        <div class="space-y-4">

            <div>
                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#64748B]"
                >
                    University
                </p>

                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ stagiaire.stagiaire?.universite || 'Not provided' }}
                </p>
            </div>

            <div>
                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#64748B]"
                >
                    Field of study
                </p>

                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ stagiaire.stagiaire?.filiere || 'Not provided' }}
                </p>
            </div>

            <div>
                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#64748B]"
                >
                    Academic level
                </p>

                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ stagiaire.stagiaire?.niveau || 'Not provided' }}
                </p>
            </div>
        </div>
    </section>
</template>