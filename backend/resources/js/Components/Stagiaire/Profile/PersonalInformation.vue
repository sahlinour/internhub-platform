<script setup>
defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },
})

const formatDate = (date) => {
    if (!date) {
        return 'Not provided'
    }

    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    })
}
</script>

<template>
    <section
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
    >
        <!-- Header -->
        <div
            class="mb-6 flex items-center justify-between border-b border-slate-100 pb-4"
        >
            <div class="flex items-center gap-3">
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
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z"
                        />
                    </svg>
                </div>

                <!-- Title -->
                <div>
                    <h3 class="text-sm font-semibold text-[#16425B] sm:text-base">
                        Personal Information
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Your basic personal details
                    </p>
                </div>
            </div>
        </div>

        <!-- Information grid -->
        <div
            class="grid grid-cols-1 divide-y divide-slate-100 sm:grid-cols-3 sm:divide-x sm:divide-y-0"
        >
            <!-- Full name -->
            <div class="py-3 sm:px-5 sm:py-1 first:sm:pl-0">
                <p
                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                >
                    Full name
                </p>

                <p
                    class="mt-1.5 text-sm font-semibold text-slate-800"
                >
                    {{ stagiaire.nom_complet || 'Not provided' }}
                </p>
            </div>

            <!-- Date of birth -->
            <div class="py-3 sm:px-5 sm:py-1">
                <p
                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                >
                    Date of birth
                </p>

                <p
                    class="mt-1.5 text-sm font-semibold text-slate-800"
                >
                    {{ formatDate(stagiaire.stagiaire?.date_naissance) }}
                </p>
            </div>

            <!-- City -->
            <div class="py-3 sm:pl-5 sm:py-1">
                <p
                    class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                >
                    City
                </p>

                <p
                    class="mt-1.5 text-sm font-semibold text-slate-800"
                >
                    {{ stagiaire.ville?.nom || 'Not provided' }}
                </p>
            </div>
        </div>
    </section>
</template>