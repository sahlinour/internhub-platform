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
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615A2.25 2.25 0 012.25 6.993V6.75"
                    />
                </svg>
            </div>

            <div>
                <h3 class="font-semibold text-[#16425B]">
                    Contact Information
                </h3>

                <p class="text-xs text-[#64748B]">
                    Your contact details
                </p>
            </div>
        </div>

        <!-- Information -->
        <div class="space-y-4">

            <!-- Email -->
            <div
                class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-[#F8FAFB] p-3"
            >
                <div class="min-w-0">
                    <p
                        class="text-xs font-medium uppercase tracking-wide text-[#64748B]"
                    >
                        Email
                    </p>

                    <p class="mt-1 break-all text-sm font-medium text-slate-800">
                        {{ stagiaire.email || 'Not provided' }}
                    </p>
                </div>

                <span
                    class="shrink-0 rounded-lg bg-[#E8F1F5] px-2 py-1 text-xs font-medium text-[#2F6690]"
                >
                    Email
                </span>
            </div>

            <!-- Phone -->
            <div
                class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-[#F8FAFB] p-3"
            >
                <div>
                    <p
                        class="text-xs font-medium uppercase tracking-wide text-[#64748B]"
                    >
                        Phone
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-800">
                        {{ stagiaire.telephone || 'Not provided' }}
                    </p>
                </div>

                <span
                    class="shrink-0 rounded-lg bg-[#E8F1F5] px-2 py-1 text-xs font-medium text-[#2F6690]"
                >
                    Phone
                </span>
            </div>

            <!-- City -->
            <div
                class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-[#F8FAFB] p-3"
            >
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

                <span
                    class="shrink-0 rounded-lg bg-[#E8F1F5] px-2 py-1 text-xs font-medium text-[#2F6690]"
                >
                    Location
                </span>
            </div>
        </div>
    </section>
</template>
