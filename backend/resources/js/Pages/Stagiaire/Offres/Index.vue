<script setup>
import { Head, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

import OffreCard from '@/Components/Stagiaire/Offres/OffreCard.vue'
import OffreFilters from '@/Components/Stagiaire/Offres/OffreFilters.vue'
import OffreSearch from '@/Components/Stagiaire/Offres/OffreSearch.vue'
import OffrePagination from '@/Components/Stagiaire/Offres/OffrePagination.vue'
import OffreEmptyState from '@/Components/Stagiaire/Offres/OffreEmptyState.vue'

const props = defineProps({
    offres: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            total: 0,
        }),
    },

    villes: {
        type: Array,
        default: () => [],
    },

    filters: {
        type: Object,
        default: () => ({
            search: '',
            location: 'all',
            duration: 'all',
            workType: [],
            skills: '',
        }),
    },
})

const search = reactive({
    value: props.filters.search ?? '',
})

const applyFilters = (filters) => {
    router.get(
        route('offres.index'),
        {
            location: filters.location,
            duration: filters.duration,
            workType: filters.workType,
            skills: filters.skills,
            search: search.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

const applySearch = (value) => {
    search.value = value

    router.get(
        route('offres.index'),
        {
            search: search.value,
            location: props.filters.location ?? 'all',
            duration: props.filters.duration ?? 'all',
            workType: props.filters.workType ?? [],
            skills: props.filters.skills ?? '',
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}
</script>

<template>
    <Head title="Internship Offers" />

    <StagiaireLayout>
        <div class="w-full">

            <!-- SEARCH -->
            <div class="mb-5">
                <OffreSearch
                    :model-value="search.value"
                    @update:model-value="applySearch"
                />
            </div>

            <!-- CONTENT -->
            <div
                class="grid items-start gap-6
                       lg:grid-cols-[260px_minmax(0,1fr)]"
            >

                <!-- FILTERS -->
                <OffreFilters
                    :villes="villes"
                    @filter="applyFilters"
                />

                <!-- OFFERS -->
                <main class="min-w-0">

                    <!-- RESULTS HEADER -->
                    <div
                        class="mb-4 flex flex-wrap items-center
                               justify-between gap-3"
                    >
                        <div>
                            <h2 class="text-base font-bold text-[#16425B]">
                                Internship Opportunities
                            </h2>

                            <p class="mt-1 text-xs text-slate-400">
                                {{ offres.total ?? offres.data?.length ?? 0 }}
                                offer(s) found
                            </p>
                        </div>
                    </div>

                    <!-- CARDS -->
                    <div
                        v-if="offres.data?.length"
                        class="grid gap-4 xl:grid-cols-2"
                    >
                        <OffreCard
                            v-for="offre in offres.data"
                            :key="offre.id"
                            :offre="offre"
                        />
                    </div>

                    <!-- EMPTY -->
                    <OffreEmptyState v-else />

                    <!-- PAGINATION -->
                    <OffrePagination
                        v-if="offres.links?.length"
                        :links="offres.links"
                    />
                </main>
            </div>
        </div>
    </StagiaireLayout>
</template>