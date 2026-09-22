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
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615A2.25 2.25 0 012.25 6.993V6.75"
                    />
                </svg>
            </div>

            <!-- Title -->
            <div>
                <h3
                    class="text-sm font-semibold text-[#16425B] sm:text-base"
                >
                    Contact Information
                </h3>

                <p class="mt-0.5 text-xs text-slate-500">
                    Your contact details and online profiles
                </p>
            </div>
        </div>

        <!-- Information -->
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <!-- Email -->
            <div
                class="rounded-xl border border-slate-100 bg-[#F8FAFB] p-4"
            >
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
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

                    <div class="min-w-0">
                        <p
                            class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                        >
                            Email
                        </p>

                        <p
                            class="mt-1.5 break-all text-sm font-semibold text-slate-800"
                        >
                            {{ stagiaire.email || 'Not provided' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Phone -->
            <div
                class="rounded-xl border border-slate-100 bg-[#F8FAFB] p-4"
            >
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372a1.5 1.5 0 00-1.08-1.44l-4.423-1.263a1.5 1.5 0 00-1.709.648l-.97 1.455a12.035 12.035 0 01-5.425-5.425l1.455-.97a1.5 1.5 0 00.648-1.709L9.083 5.496a1.5 1.5 0 00-1.44-1.08H6.25A2.25 2.25 0 004 6.666V6.75"
                            />
                        </svg>
                    </div>

                    <div>
                        <p
                            class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                        >
                            Phone
                        </p>

                        <p
                            class="mt-1.5 text-sm font-semibold text-slate-800"
                        >
                            {{ stagiaire.telephone || 'Not provided' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- City -->
            <div
                class="rounded-xl border border-slate-100 bg-[#F8FAFB] p-4"
            >
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 10.5-7.5 10.5S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"
                            />
                        </svg>
                    </div>

                    <div>
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
            </div>

            <!-- LinkedIn -->
            <div
                class="rounded-xl border border-slate-100 bg-[#F8FAFB] p-4"
            >
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16 8a6 6 0 016 6v6h-4v-6a2 2 0 00-4 0v6h-4v-6a6 6 0 016-6z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2 9h4v11H2z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 4.5a2 2 0 110 4 2 2 0 010-4z"
                            />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p
                            class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                        >
                            LinkedIn
                        </p>

                        <p
                            class="mt-1.5 break-all text-sm font-semibold text-slate-800"
                        >
                            {{ stagiaire.stagiaire?.linkedin_url || 'Not provided' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Portfolio -->
            <div
                class="rounded-xl border border-slate-100 bg-[#F8FAFB] p-4 sm:col-span-2"
            >
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#2F6690]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21a9 9 0 100-18 9 9 0 000 18z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.6 9h16.8M3.6 15h16.8M12 3c2.25 2.48 3.5 5.46 3.5 9s-1.25 6.52-3.5 9c-2.25-2.48-3.5-6.52-3.5-9S9.75 5.48 12 3z"
                            />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p
                            class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"
                        >
                            Portfolio
                        </p>

                        <p
                            class="mt-1.5 break-all text-sm font-semibold text-slate-800"
                        >
                            {{ stagiaire.stagiaire?.portfolio_url || 'Not provided' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>