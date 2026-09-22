<script setup>
import { router } from '@inertiajs/vue3'
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import ApplicationOverview from '@/Components/Stagiaire/Candidatures/ApplicationOverview.vue';
import ApplicationTimeline from '@/Components/Stagiaire/Candidatures/ApplicationTimeline.vue'

defineProps({
    candidature: {
        type: Object,
        required: true,
    },
})

const goBack = () => {
    router.visit(route('stagiaire.candidatures.index'))
}
</script>

<template>
    <StagiaireLayout>
        <main class="min-h-screen bg-[#F4F7F9]">
            <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">

                <!-- Back -->
                <button
                    type="button"
                    @click="goBack"
                    class="mb-5 inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#16425B]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M17 10a1 1 0 01-1 1H6.414l3.293 3.293a1 1 0 01-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L6.414 9H16a1 1 0 011 1z"
                            clip-rule="evenodd"
                        />
                    </svg>

                    Back to My Applications
                </button>

                <!-- Header -->
                <ApplicationOverview
                    :candidature="candidature"
                />

                <!-- Timeline -->
                <ApplicationTimeline
                    :candidature="candidature"
                />

            </div>
        </main>
    </StagiaireLayout>
</template>