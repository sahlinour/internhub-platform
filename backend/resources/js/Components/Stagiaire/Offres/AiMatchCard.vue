<script setup>
defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const match = 94
</script>

<template>
    <section
        class="overflow-hidden rounded-xl border border-blue-100 bg-gradient-to-r from-blue-50 to-white p-4"
    >
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100">
                        <svg
                            class="h-4 w-4 text-blue-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9.75 17L12 19.25 14.25 17M12 2v2m6.364.636l-1.414 1.414M20 12h-2M5.636 4.636L7.05 6.05M4 12H2m4.636 5.364l-1.414 1.414"
                            />
                        </svg>
                    </div>

                    <h2 class="text-xs font-bold text-slate-800">
                        AI Match Analysis
                    </h2>
                </div>

                <p class="mt-3 max-w-xl text-[10px] leading-5 text-slate-500">
                    Votre profil semble correspondre aux compétences
                    demandées dans cette offre. Mettez en avant vos projets
                    pertinents dans votre candidature.
                </p>
            </div>

            <div
                class="shrink-0 rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-600"
            >
                {{ match }}% match
            </div>
        </div>

        <!-- Progress -->
        <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-slate-200">
            <div
                class="h-full rounded-full bg-emerald-500 transition-all"
                :style="{ width: `${match}%` }"
            ></div>
        </div>
    </section>
</template>