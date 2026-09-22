<script setup>
import { ref, onMounted } from 'vue'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import OfferHeader from '@/Components/Stagiaire/Offres/OfferHeader.vue'
import OfferDetails from '@/Components/Stagiaire/Offres/OfferAbout.vue'
import OfferSidebar from '@/Components/Stagiaire/Offres/OfferSidebar.vue'
import CompanyCard from '@/Components/Stagiaire/Offres/CompanyCard.vue'

import { matchCv } from '@/Pages/AI/cv/services/api'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },

    profile: {
        type: Object,
        default: () => ({
            has_cv: false,
            cv_url: null,
            university: null,
            field: null,
            level: null,
        }),
    },
})

const profileMatch = ref(0)
const matching = ref(false)
const matchError = ref('')

async function calculateProfileMatch() {
    if (!props.profile.has_cv || !props.profile.cv_url) {
        profileMatch.value = 0
        return
    }

    matching.value = true
    matchError.value = ''

    try {
        const response = await fetch(props.profile.cv_url)

        if (!response.ok) {
            throw new Error('Unable to load your CV.')
        }

        const blob = await response.blob()
        const file = new File(
            [blob],
            'cv.pdf',
            {
                type: blob.type || 'application/pdf',
            }
        )
        const data = await matchCv(file)
        const currentOffer = (data.offers ?? []).find(
            (offer) =>
                Number(offer.id) === Number(props.offre.id)
        )
        profileMatch.value = Number(
            currentOffer?.score ?? 0
        )

    } catch (error) {
        console.error('Profile match error:', error)

        matchError.value =
            error?.message ||
            'Unable to calculate your profile match.'

        profileMatch.value = 0

    } finally {
        matching.value = false
    }
}

onMounted(() => {
    calculateProfileMatch()
})
</script>

<template>
    <StagiaireLayout>
        <div class="min-h-screen bg-slate-50">
            <div
                class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8"
            >
                <OfferHeader :offre="offre" />
                <div
                    class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3"
                >
                    <main class="space-y-6 lg:col-span-2">
                        <OfferDetails
                            :offre="offre"
                        />
                        <CompanyCard
                            :offre="offre"
                        />
                    </main>
                    <aside>
                        <OfferSidebar
                            :offre="offre"
                            :profile-match="profileMatch"
                            :profile="profile"
                        />
                    </aside>
                </div>
            </div>
        </div>
    </StagiaireLayout>
</template>