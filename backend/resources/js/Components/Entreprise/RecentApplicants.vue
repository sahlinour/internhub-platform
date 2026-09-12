<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    applications: {
        type: Array,
        default: () => [],
    },
})

const candidatureRoute = () => {
    return route('entreprise.candidatures.index', undefined, false)
}

const statusClass = (status) => {
    const value = status?.toLowerCase()

    if (value === 'accepted' || value === 'acceptee') {
        return 'bg-emerald-50 text-emerald-600'
    }

    if (value === 'rejected' || value === 'refusee') {
        return 'bg-red-50 text-red-500'
    }

    if (value === 'interview' || value === 'entretien') {
        return 'bg-blue-50 text-blue-600'
    }

    return 'bg-amber-50 text-amber-600'
}
</script>

<template>
    <div
        class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm"
    >
        <div
            class="flex items-center justify-between border-b border-gray-100 px-5 py-4"
        >
            <div>
                <h2 class="text-[13px] font-semibold text-gray-800">
                    Recent Applications
                </h2>

                <p class="mt-1 text-[9px] text-gray-400">
                    Latest applications received
                </p>
            </div>

            <Link
                :href="candidatureRoute()"
                class="text-[9px] font-semibold text-[#2d7da0] transition hover:underline"
            >
                View all
            </Link>
        </div>

        <!-- Empty -->
        <div
            v-if="applications.length === 0"
            class="flex min-h-[220px] flex-col items-center justify-center px-5 text-center"
        >
            <div
                class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-50 text-gray-400"
            >
                <svg
                    viewBox="0 0 24 24"
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                >
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
            </div>

            <p class="mt-3 text-[11px] font-semibold text-gray-600">
                No applications yet
            </p>

            <p class="mt-1 text-[9px] text-gray-400">
                New applications will appear here.
            </p>
        </div>

        <!-- Applications -->
        <div v-else class="divide-y divide-gray-100">
            <div
                v-for="application in applications"
                :key="application.id"
                class="flex items-center justify-between gap-4 px-5 py-4 transition hover:bg-gray-50"
            >
                <div class="flex min-w-0 items-center gap-3">
                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#e8f3f7] text-[10px] font-bold text-[#286f8e]"
                    >
                        {{ application.initials ?? 'ST' }}
                    </div>

                    <div class="min-w-0">
                        <p
                            class="truncate text-[10px] font-semibold text-gray-700"
                        >
                            {{ application.name }}
                        </p>

                        <p class="mt-1 truncate text-[8px] text-gray-400">
                            {{ application.offer }}
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-4">
                    <span class="hidden text-[8px] text-gray-400 sm:block">
                        {{ application.date }}
                    </span>

                    <span
                        class="rounded-full px-2.5 py-1 text-[8px] font-medium"
                        :class="statusClass(application.status)"
                    >
                        {{ application.status ?? 'Pending' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
