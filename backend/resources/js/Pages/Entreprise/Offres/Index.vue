<script setup>
import { Head, router, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'
import InternshipHeader from '@/Components/Entreprise/Offres/InternshipHeader.vue'
import InternshipStats from '@/Components/Entreprise/Offres/InternshipStats.vue'
import InternshipTable from '@/Components/Entreprise/Offres/InternshipTable.vue'
import InternshipEditModal from '@/Components/Entreprise/Offres/InternshipEditModal.vue'

const props = defineProps({
    offres: {
        type: Array,
        default: () => [],
    },
})

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}
const showEditModal = ref(false)
const editingOffer = ref(null)
const form = useForm({
    titre: '',
    description: '',
    duree: '',
    date_limite: '',
    statut: 'active',
})
const stats = computed(() => {
    const offres = props.offres || []
    return {
        total: offres.length,
        active: offres.filter(
            (offre) => offre.statut === 'active'
        ).length,
        inactive: offres.filter(
            (offre) => offre.statut === 'inactive'
        ).length,
        closed: offres.filter(
            (offre) => offre.statut === 'closed'
        ).length,
    }
})

const openEditModal = (offre) => {
    editingOffer.value = offre
    form.titre = offre.titre ?? ''
    form.description = offre.description ?? ''
    form.duree = offre.duree ?? ''
    form.date_limite = offre.date_limite ?? ''
    form.statut = offre.statut ?? 'active'

    form.clearErrors()
    showEditModal.value = true
}
const closeEditModal = () => {
    showEditModal.value = false
    editingOffer.value = null
    form.reset()
    form.clearErrors()
}
const submitEdit = () => {
    if (!editingOffer.value) {
        return
    }
    form.put(
        appRoute(
            'entreprise.offres.update',
            editingOffer.value.id
        ),
        {
            preserveScroll: true,

            onSuccess: () => {
                closeEditModal()
            },
        }
    )
}
const deleteOffer = (id) => {
    if (!confirm('Are you sure you want to delete this internship?')) {
        return
    }
    router.delete(
        appRoute('entreprise.offres.destroy', id),
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Internships" />

    <EntrepriseLayout>
        <InternshipEditModal
            :show="showEditModal"
            :offre="editingOffer"
            :form="form"
            @close="closeEditModal"
            @submit="submitEdit"
        />
        <main class="min-h-screen bg-[#F4F7F9]">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- HEADER -->
            <InternshipHeader
                :create-url="appRoute('entreprise.offres.create')"
            />
           <!-- STATISTICS -->
            <InternshipStats
                :stats="stats"
            />

            <section
                class="mt-10 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
            >
                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <h2 class="text-sm font-bold text-[#16425B]">
                        Internship Listings
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-400">
                        Manage the internships published by your company.
                    </p>
                </div>
                <InternshipTable
                    :offres="offres"
                    @edit="openEditModal"
                    @delete="deleteOffer"
                />
            </section>
         </div>
        </main>
    </EntrepriseLayout>
</template>