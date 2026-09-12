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
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z"
                    />
                </svg>
            </div>

            <div>
                <h3 class="font-semibold text-[#16425B]">
                    Personal Information
                </h3>

                <p class="text-xs text-[#64748B]">
                    Your basic personal details
                </p>
            </div>
        </div>

        <!-- Information -->
        <div class="space-y-4">

            <div>
                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#64748B]"
                >
                    Full name
                </p>

                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ stagiaire.nom_complet || 'Not provided' }}
                </p>
            </div>

            <div>
                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#64748B]"
                >
                    Date of birth
                </p>

                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ formatDate(stagiaire.stagiaire?.date_naissance) }}
                </p>
            </div>

            <div>
                <p
                    class="text-xs font-medium uppercase tracking-wide text-[#64748B]"
                >
                    City
                </p>

                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ stagiaire.ville?.nom || 'Not provided' }}
                </p>
            </div>
        </div>
    </section>
</template>
