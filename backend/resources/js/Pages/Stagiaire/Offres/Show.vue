<script setup>
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import OfferHeader from '@/Components/Stagiaire/Offres/OfferHeader.vue'
import OfferDetails from '@/Components/Stagiaire/Offres/OfferAbout.vue'
import OfferRequirements from '@/Components/Stagiaire/Offres/OfferRequirements.vue'
import OfferSidebar from '@/Components/Stagiaire/Offres/OfferSidebar.vue'
import CompanyCard from '@/Components/Stagiaire/Offres/CompanyCard.vue'

defineProps({
    offre: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <StagiaireLayout>
        <div class="min-h-screen bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

                <!-- Header -->
                <OfferHeader :offre="offre" />

                <!-- Main content -->
                <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

                    <!-- Left -->
                    <main class="space-y-6 lg:col-span-2">

                        <OfferDetails :offre="offre" />

                        <OfferRequirements
                            v-if="
                                offre.competences ||
                                offre.competences_requises ||
                                offre.requirements ||
                                offre.prerequis
                            "
                            :offre="offre"
                        />

                        <CompanyCard :offre="offre" />

                    </main>

                    <!-- Right -->
                    <aside>
                        <OfferSidebar :offre="offre" />
                    </aside>

                </div>
            </div>
        </div>
    </StagiaireLayout>
</template>