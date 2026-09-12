<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    percentage: {
        type: Number,
        default: 0,
    },

    items: {
        type: Array,
        default: () => [],
    },
});

function circumference() {
    return 2 * Math.PI * 38;
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-slate-800">
                Complétion du profil
            </h2>

            <span class="text-xs font-medium text-slate-400">
                Profil
            </span>
        </div>

        <div class="my-6 flex justify-center">
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
                        class="text-[#2F6690]"
                        :stroke-dasharray="circumference()"
                        :stroke-dashoffset="
                            circumference() -
                            (circumference() * Math.min(percentage, 100)) / 100
                        "
                    />
                </svg>

                <div
                    class="absolute inset-0 flex items-center justify-center"
                >
                    <span class="text-xl font-bold text-slate-700">
                        {{ percentage }}%
                    </span>
                </div>
            </div>
        </div>

        <div v-if="items.length" class="space-y-3">
            <div
                v-for="item in items"
                :key="item.label"
                class="flex items-center justify-between text-sm"
            >
                <div class="flex items-center gap-2">
                    <span
                        class="flex h-5 w-5 items-center justify-center rounded-full text-xs"
                        :class="
                            item.completed
                                ? 'bg-emerald-100 text-emerald-600'
                                : 'bg-slate-100 text-slate-400'
                        "
                    >
                        {{ item.completed ? '✓' : '○' }}
                    </span>

                    <span class="text-slate-600">
                        {{ item.label }}
                    </span>
                </div>
            </div>
        </div>

        <Link
            :href="route('stagiaire.profile.edit')"
            class="mt-5 block w-full rounded-lg bg-[#16425B] px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-[#2F6690]"
        >
            Compléter mon profil
        </Link>
    </section>
</template>