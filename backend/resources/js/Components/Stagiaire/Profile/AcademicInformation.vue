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
        <div
            class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-4"
        >
            <!-- Icon -->
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E8F1F5] text-[#2F6690]"
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

            <!-- Title -->
            <div>
                <h3
                    class="text-sm font-semibold text-[#16425B] sm:text-base"
                >
                    Academic Information
                </h3>

                <p class="mt-0.5 text-xs text-slate-500">
                    Your education and academic background
                </p>
            </div>
        </div>

        <!-- Information -->
        <div
            class="grid grid-cols-1 divide-y divide-slate-100 sm:grid-cols-3 sm:divide-x sm:divide-y-0"
        >
            <!-- University -->
            <div class="py-3 sm:px-5 sm:py-1 first:sm:pl-0">
                <p
                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                >
                    University
                </p>

                <p
                    class="mt-1.5 text-sm font-semibold text-slate-800"
                >
                    {{ stagiaire.stagiaire?.universite || 'Not provided' }}
                </p>
            </div>

            <!-- Field of study -->
            <div class="py-3 sm:px-5 sm:py-1">
                <p
                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                >
                    Field of study
                </p>

                <p
                    class="mt-1.5 text-sm font-semibold text-slate-800"
                >
                    {{ stagiaire.stagiaire?.filiere || 'Not provided' }}
                </p>
            </div>

            <!-- Academic level -->
            <div class="py-3 sm:pl-5 sm:py-1">
                <p
                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                >
                    Academic level
                </p>

                <p
                    class="mt-1.5 text-sm font-semibold text-slate-800"
                >
                    {{ stagiaire.stagiaire?.niveau || 'Not provided' }}
                </p>
            </div>
        </div>
    </section>
</template>