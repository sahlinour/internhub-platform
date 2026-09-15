<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
})
</script>

<template>
    <section
        class="overflow-hidden rounded-2xl bg-[#16425B] px-5 py-6 text-white shadow-sm sm:px-7"
    >
        <div
            class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between"
        >
            <!-- Welcome content -->
            <div>
                <p class="mb-2 text-sm text-[#B9D9E8]">
                    Welcome to your internship space
                </p>

                <div class="flex items-center gap-3">
                    <!-- Hand icon -->
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10"
                    >
                        <svg
                            class="h-6 w-6 text-[#81C3D7]"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path
                                d="M8 13V5.5a1.5 1.5 0 0 1 3 0V12"
                            />
                            <path
                                d="M11 12V4.5a1.5 1.5 0 0 1 3 0V12"
                            />
                            <path
                                d="M14 12V6.5a1.5 1.5 0 0 1 3 0V13"
                            />
                            <path
                                d="M17 13V9.5a1.5 1.5 0 0 1 3 0V15"
                            />
                            <path
                                d="M20 15c0 4-2.5 6-6 6h-2.5C8 21 6 19 4.5 16.5L3 14a1.5 1.5 0 0 1 2.6-1.5L8 15"
                            />
                        </svg>
                    </div>

                    <h1
                        class="text-2xl font-bold tracking-tight sm:text-3xl"
                    >
                        Hello<span v-if="user?.nom_complet">, {{ user.nom_complet }}</span>
                    </h1>
                </div>

                <p class="mt-3 max-w-xl text-sm leading-6 text-[#D8ECF4]">
                    Track your applications, discover new opportunities, and
                    manage your internship journey from your personal space.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-3">
                <Link
                    :href="route('stagiaire.candidatures.index')"
                    class="rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#16425B] transition hover:bg-slate-100"
                >
                    My Applications
                </Link>

                <Link
                    :href="route('offres.index')"
                    class="rounded-lg border border-white/30 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10"
                >
                    Browse Offers
                </Link>
            </div>
        </div>
    </section>
</template>
