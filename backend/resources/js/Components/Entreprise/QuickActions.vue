<script setup>
import { Link } from '@inertiajs/vue3'

const entrepriseRoute = (name) => {
    return route(name, undefined, false)
}
</script>

<template>
    <div
        class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm"
    >
        <div>
            <h2 class="text-[13px] font-semibold text-gray-800">
                Quick Actions
            </h2>

            <p class="mt-1 text-[9px] text-gray-400">
                Common company actions
            </p>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3">
            <!-- Offers -->
            <Link
                :href="entrepriseRoute('entreprise.offres.index')"
                class="group flex min-h-[78px] flex-col items-center justify-center gap-2 rounded-xl border border-gray-100 bg-gray-50 px-3 py-3 text-center transition hover:border-[#63a9c6]/30 hover:bg-[#f0f8fb]"
            >
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-[#2d7da0] transition group-hover:bg-white"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                </div>

                <span
                    class="text-[9px] font-semibold text-gray-600 group-hover:text-[#174e6d]"
                >
                    Post Internship
                </span>
            </Link>

            <!-- Applicants -->
            <Link
                :href="entrepriseRoute('entreprise.candidatures.index')"
                class="group flex min-h-[78px] flex-col items-center justify-center gap-2 rounded-xl border border-gray-100 bg-gray-50 px-3 py-3 text-center transition hover:border-[#63a9c6]/30 hover:bg-[#f0f8fb]"
            >
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-500 transition group-hover:bg-white"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                </div>

                <span
                    class="text-[9px] font-semibold text-gray-600 group-hover:text-[#174e6d]"
                >
                    View Applicants
                </span>
            </Link>

            <!-- Supervisors -->
            <Link
                :href="entrepriseRoute('entreprise.encadrants.index')"
                class="group flex min-h-[78px] flex-col items-center justify-center gap-2 rounded-xl border border-gray-100 bg-gray-50 px-3 py-3 text-center transition hover:border-[#63a9c6]/30 hover:bg-[#f0f8fb]"
            >
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-500 transition group-hover:bg-white"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="12" cy="7" r="4" />
                        <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
                    </svg>
                </div>

                <span
                    class="text-[9px] font-semibold text-gray-600 group-hover:text-[#174e6d]"
                >
                    Supervisors
                </span>
            </Link>

            <!-- Profile -->
            <Link
                :href="entrepriseRoute('entreprise.profile.show')"
                class="group flex min-h-[78px] flex-col items-center justify-center gap-2 rounded-xl border border-gray-100 bg-gray-50 px-3 py-3 text-center transition hover:border-[#63a9c6]/30 hover:bg-[#f0f8fb]"
            >
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-50 text-orange-500 transition group-hover:bg-white"
                >
                    <svg
                        viewBox="0 0 24 24"
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 .6 1.7 1.7 0 0 0-.4 1.1V21H9.6v-.1A1.7 1.7 0 0 0 8.5 19.4a1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-.6-1 1.7 1.7 0 0 0-1.1-.4H3V9.6h.1A1.7 1.7 0 0 0 4.6 8.5a1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-.6 1.7 1.7 0 0 0 .4-1.1V3h4v.1A1.7 1.7 0 0 0 15.5 4.6a1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9c.2.38.4.7.6 1 .2.35.3.72.3 1.1v1.8c0 .38-.1.75-.3 1.1-.2.3-.4.62-.6 1Z"
                        />
                    </svg>
                </div>

                <span
                    class="text-[9px] font-semibold text-gray-600 group-hover:text-[#174e6d]"
                >
                    Company Profile
                </span>
            </Link>
        </div>
    </div>
</template>
