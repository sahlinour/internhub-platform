<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import ApplicationHeader from '@/Components/Stagiaire/Candidatures/ApplicationHeader.vue'
import ApplicationHistory from '@/Components/Stagiaire/Candidatures/ApplicationHistory.vue'
import ApplicationPagination from '@/Components/Stagiaire/Candidatures/ApplicationPagination.vue'

const props = defineProps({
    candidatures: {
        type: Object,
        required: true,
    },

    stats: {
        type: Object,
        default: () => ({
            applied: 0,
            under_review: 0,
            interview: 0,
            offer: 0,
            rejected: 0,
        }),
    },

    sortBy: {
        type: String,
        default: 'recently_updated',
    },
})

const sortBy = ref(props.sortBy)

watch(sortBy, (value) => {
    router.get(
        route('stagiaire.candidatures.index'),
        { sort: value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
})
</script>

<template>
    <StagiaireLayout>
        <main class="min-h-screen bg-[#F4F7F9]">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <ApplicationHeader
                    v-model:sort-by="sortBy"
                    :stats="stats"
                />

                <ApplicationHistory
                    :candidatures="candidatures.data"
                />

                <ApplicationPagination
                    :links="candidatures.links"
                />
            </div>
        </main>
    </StagiaireLayout>
</template>