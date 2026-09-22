<script setup>
import { Head } from '@inertiajs/vue3'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import SavedOpportunityCard from '@/Components/Stagiaire/Favoris/SavedOpportunityCard.vue'
import SavedOpportunityHeader from '@/Components/Stagiaire/Favoris/SavedOpportunityHeader.vue'
import SavedOpportunityEmptyState from '@/Components/Stagiaire/Favoris/SavedOpportunityEmptyState.vue'
import SavedOpportunityPagination from '@/Components/Stagiaire/Favoris/SavedOpportunityPagination.vue'

defineProps({
    favoris: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            current_page: 1,
            last_page: 1,
            total: 0,
        }),
    },
})
</script>

<template>
    <Head title="Saved Opportunities" />

    <StagiaireLayout>
        <div class="min-h-screen bg-[#F4F7F9]">
            <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <!-- Header -->
                <SavedOpportunityHeader
                    :total="favoris.total"
                />

                <!-- Empty state -->
                <SavedOpportunityEmptyState
                    v-if="favoris.data.length === 0"
                />

                <!-- Saved opportunities -->
                <div
                    v-else
                    class="grid grid-cols-1 gap-5 lg:grid-cols-2"
                >
                    <SavedOpportunityCard
                        v-for="offre in favoris.data"
                        :key="offre.id"
                        :offre="offre"
                    />
                </div>

                <!-- Pagination -->
                <SavedOpportunityPagination
                    v-if="favoris.links && favoris.links.length > 3"
                    :links="favoris.links"
                />

            </div>
        </div>
    </StagiaireLayout>
</template>