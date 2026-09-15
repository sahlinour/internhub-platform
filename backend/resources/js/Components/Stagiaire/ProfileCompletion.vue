<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    percentage: {
        type: Number,
        default: 0,
    },

    items: {
        type: Array,
        default: () => [],
    },
})

function circumference() {
    return 2 * Math.PI * 38
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <!-- Circular progress -->
        <div class="my-4 flex justify-center">
            <div class="relative h-28 w-28">
                <svg
                    class="h-28 w-28 -rotate-90"
                    viewBox="0 0 100 100"
                >
                    <circle
                        cx="50"
                        cy="50"
                        r="38"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="8"
                        class="text-slate-100"
                    />

                    <circle
                        cx="50"
                        cy="50"
                        r="38"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="8"
                        stroke-linecap="round"
                        class="text-[#2F6690] transition-all duration-500"
                        :stroke-dasharray="circumference()"
                        :stroke-dashoffset="
                            circumference() -
                            (circumference() *
                                Math.min(Math.max(percentage, 0), 100)) /
                                100
                        "
                    />
                </svg>

                <div
                    class="absolute inset-0 flex items-center justify-center"
                >
                    <span class="text-xl font-bold text-[#16425B]">
                        {{ percentage }}%
                    </span>
                </div>
            </div>
        </div>

        <!-- Profile fields -->
        <div
            v-if="items.length"
            class="space-y-2"
        >
            <div
                v-for="item in items"
                :key="item.label"
                class="flex items-center justify-between rounded-lg
                       border border-slate-100 bg-slate-50 px-3 py-2"
            >
                <div class="flex min-w-0 items-center gap-2">
                    <span
                        class="flex h-5 w-5 shrink-0 items-center justify-center
                               rounded-full text-xs font-semibold"
                        :class="
                            item.completed
                                ? 'bg-emerald-100 text-emerald-600'
                                : 'bg-slate-100 text-slate-400'
                        "
                    >
                        {{ item.completed ? '✓' : '○' }}
                    </span>

                    <span class="truncate text-sm text-slate-600">
                        {{ item.label }}
                    </span>
                </div>
            </div>
        </div>

        <div
            v-else
            class="rounded-lg border border-dashed border-slate-200
                   bg-slate-50 px-4 py-5 text-center"
        >
            <p class="text-sm text-slate-400">
                No profile information available.
            </p>
        </div>

        <!-- Edit profile -->
        <Link
            :href="route('stagiaire.profile.show')"
            class="mt-5 block w-full rounded-lg bg-[#16425B]
                   px-4 py-2.5 text-center text-sm font-semibold text-white
                   transition hover:bg-[#2F6690]"
        >
            Complete My Profile
        </Link>
    </section>
</template>
