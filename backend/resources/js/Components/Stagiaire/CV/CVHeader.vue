<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    total: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <div class="mb-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-[22px] font-bold text-[#16425B]">
                        My CV
                    </h1>

                    <span
                        class="flex h-6 min-w-6 items-center justify-center
                               rounded-full bg-[#2F6690] px-2
                               text-[10px] font-bold text-white"
                    >
                        {{ total }}
                    </span>
                </div>

                <p class="mt-1 text-[12px] text-slate-500">
                    Manage and organize your professional CV versions.
                </p>
            </div>

            <Link
                :href="route('stagiaire.cv.create')"
                class="inline-flex rounded-lg bg-[#2F6690]
                       px-5 py-2.5 text-[10px] font-semibold text-white
                       transition hover:bg-[#16425B]"
            >
                + Upload New CV
            </Link>
        </div>
    </div>
</template>
