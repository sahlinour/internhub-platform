<script setup>
import { Head, router } from '@inertiajs/vue3'
import { computed } from 'vue'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'
import ApplicantHeader from '@/Components/Entreprise/Candidatures/ApplicantHeader.vue'
import ApplicantFilters from '@/Components/Entreprise/Candidatures/ApplicantFilters.vue'
import ApplicantSummary from '@/Components/Entreprise/Candidatures/ApplicantSummary.vue'
import ApplicantTable from '@/Components/Entreprise/Candidatures/ApplicantTable.vue'

const props = defineProps({
    candidatures: {
        type: Object,
        required: true,
    },
    offres: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({
            statut: '',
            offre_id: '',
        }),
    },
})

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}
const applications = computed(() => {
    return props.candidatures?.data ?? []
})
const totalApplicants = computed(() => {
    return (
        props.candidatures?.total ??
        applications.value.length
    )
})
const paginationLinks = computed(() => {
    return props.candidatures?.links ?? []
})
const changeInternship = (event) => {
    const offreId = event.target.value
    router.get(
        appRoute('entreprise.candidatures.index'),
        {
            offre_id: offreId || undefined,
            statut: props.filters?.statut || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}
const changeStatusFilter = (event) => {
    const statut = event.target.value
    router.get(
        appRoute('entreprise.candidatures.index'),
        {
            offre_id: props.filters?.offre_id || undefined,
            statut: statut || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}
const updateStatus = (candidature, statut) => {
    router.patch(
        appRoute(
            'entreprise.candidatures.updateStatus',
            candidature.id
        ),
        {
            statut,
        },
        {
            preserveScroll: true,
        }
    )
}
const visitPage = (url) => {
    if (!url) return
    router.get(
        url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <EntrepriseLayout>
        <Head title="Applicants" />
        <main class="min-h-screen bg-[#F4F7F9]">
            <div
                class="mx-auto max-w-7xl
                       px-4 py-6
                       sm:px-6
                       lg:px-8"
            >
                <div
                    class="flex flex-col gap-4
                           xl:flex-row
                           xl:items-center
                           xl:justify-between"
                >
                    <ApplicantHeader
                        :total="totalApplicants"
                    />
                    <ApplicantFilters
                        :offres="offres"
                        :filters="filters"
                        @status-change="changeStatusFilter"
                        @offer-change="changeInternship"
                    />
                </div>
                <div class="mt-8">
                    <ApplicantSummary
                        :total="totalApplicants"
                        :displayed="applications.length"
                    />
                </div>
                <section
                    class="mt-10 overflow-hidden
                           rounded-2xl
                           border border-slate-200
                           bg-white
                           shadow-sm"
                >
                    <div
                        class="border-b border-slate-100
                               px-5 py-4
                               sm:px-6"
                    >
                        <h2
                            class="text-sm font-bold
                                   text-[#16425B]"
                        >
                            Applicants
                        </h2>

                        <p
                            class="mt-0.5 text-xs
                                   text-slate-400"
                        >
                            Manage applications received
                            for your internships.
                        </p>
                    </div>

                    <!-- TABLE -->

                    <ApplicantTable
                        :applications="applications"
                        @update-status="updateStatus"
                    />
                </section>
                <div
                    v-if="paginationLinks.length > 3"
                    class="mt-4 flex flex-col gap-3
                           border-t border-slate-200
                           px-2 py-4
                           sm:flex-row
                           sm:items-center
                           sm:justify-between"
                >
                    <p
                        class="text-[10px]
                               text-slate-400"
                    >
                        Showing
                        {{ candidatures.from ?? 0 }}
                        to
                        {{ candidatures.to ?? 0 }}
                        of
                        {{ candidatures.total ?? 0 }}
                        applicants
                    </p>

                    <div
                        class="flex flex-wrap gap-1"
                    >
                        <button
                            v-for="(link, index) in paginationLinks"
                            :key="index"
                            type="button"
                            :disabled="!link.url"
                            @click="visitPage(link.url)"
                            class="min-w-9 rounded-lg
                                   border px-3 py-2
                                   text-xs transition"
                            :class="[
                                link.active
                                    ? 'border-[#16425B] bg-[#16425B] text-white'
                                    : 'border-slate-200 bg-white text-slate-600 hover:border-[#81C3D7] hover:bg-[#E8F1F5]',

                                !link.url
                                    ? 'cursor-not-allowed opacity-40'
                                    : '',
                            ]"
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>
        </main>
    </EntrepriseLayout>
</template>