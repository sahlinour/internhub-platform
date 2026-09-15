<script setup>
defineProps({
    offre: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <section
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7"
    >
        <!-- HEADER -->
        <div class="flex items-center gap-3">
            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center
                       text-[#2F6690]"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M4 5.5A2.5 2.5 0 016.5 3H20v17H6.5A2.5 2.5 0 014 17.5v-12Z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M8 7h8M8 11h8M8 15h5"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-bold text-[#16425B]">
                    Internship Description
                </h2>

                <p class="mt-0.5 text-xs text-slate-400">
                    Details about this internship opportunity
                </p>
            </div>
        </div>

        <!-- DIVIDER -->
        <div class="my-5 border-t border-slate-100"></div>

        <!-- DESCRIPTION -->
        <div
            v-if="offre.description"
            class="whitespace-pre-line text-sm leading-7 text-slate-600"
        >
            {{ offre.description }}
        </div>

        <!-- EMPTY STATE -->
        <div
            v-else
            class="rounded-xl border border-dashed border-slate-200
                   bg-slate-50 px-5 py-6 text-center"
        >
            <svg
                class="mx-auto h-7 w-7 text-slate-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.7"
                    d="M4 5.5A2.5 2.5 0 016.5 3H20v17H6.5A2.5 2.5 0 014 17.5v-12Z"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.7"
                    d="M8 9h8M8 13h5"
                />
            </svg>

            <p class="mt-2 text-sm text-slate-400">
                No detailed description is available for this internship.
            </p>
        </div>
    </section>
</template>
