<script setup>
import { Head, Link } from '@inertiajs/vue3'
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import CVHeader from '@/Components/Stagiaire/CV/CVHeader.vue'
import CVCard from '@/Components/Stagiaire/CV/CVCard.vue'
import CVEmptyState from '@/Components/Stagiaire/CV/CVEmptyState.vue'

defineProps({
    cvs: {
        type: Array,
        default: () => [],
    },
    stagiaire: {
        type: Object,
        default: null,
    },
})
</script>

<template>
    <Head title="My CV" />

    <StagiaireLayout>
        <div class="min-h-screen bg-[#f4f7fb]">
            <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <!-- Header with action button -->
                <CVHeader :total="cvs.length" />

                <!-- Empty state -->
                <CVEmptyState v-if="cvs.length === 0" />

                <!-- CV List -->
                <div
                    v-else
                    class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-3"
                >
                    <CVCard
                        v-for="cv in cvs"
                        :key="cv.id"
                        :cv="cv"
                    />
                </div>

            </div>
        </div>
    </StagiaireLayout>
</template>
