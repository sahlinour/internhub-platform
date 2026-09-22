<script setup>
import { computed } from 'vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const description = computed(() => {
    return props.offre?.description?.trim() || null
})
</script>

<template>
    <section
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
    >
        <div class="flex items-start gap-3">
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
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6.586a2 2 0 01.414.086A2 2 0 0115 3.5L19.5 8a2 2 0 01.5 1.414V19a2 2 0 01-2 2z"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-bold text-[#16425B]">
                    Overview
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    About this internship opportunity
                </p>
            </div>
        </div>

        <div class="my-5 border-t border-slate-100"></div>

        <div
            v-if="description"
            class="whitespace-pre-line text-sm leading-7 text-slate-600"
        >
            {{ description }}
        </div>

        <div
            v-else
            class="rounded-xl bg-slate-50 px-4 py-5 text-center text-sm text-slate-400"
        >
            No overview is available for this internship.
        </div>
    </section>
</template>
