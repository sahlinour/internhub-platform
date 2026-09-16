<script setup>
import { Head, router } from '@inertiajs/vue3'
import { computed, ref, nextTick } from 'vue'

import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

import SupervisorHeader from '@/Components/Entreprise/Encadrants/SupervisorHeader.vue'
import SupervisorSearch from '@/Components/Entreprise/Encadrants/SupervisorSearch.vue'
import SupervisorGrid from '@/Components/Entreprise/Encadrants/SupervisorGrid.vue'
import SupervisorEditModal from '@/Components/Entreprise/Encadrants/SupervisorEditModal.vue'

const props = defineProps({
    encadrants: {
        type: Array,
        default: () => [],
    },
})

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}

const search = ref('')
const showEditModal = ref(false)
const selectedEncadrant = ref(null)
const editModal = ref(null)

const filteredEncadrants = computed(() => {
    const term = search.value.trim().toLowerCase()

    if (!term) {
        return props.encadrants
    }

    return props.encadrants.filter((user) => {
        const values = [
            user?.nom_complet,
            user?.email,
            user?.telephone,
            user?.encadrant?.poste,
            user?.encadrant?.specialite,
            user?.encadrant?.departement,
            user?.ville?.nom,
        ]

        return values.some((value) =>
            String(value ?? '')
                .toLowerCase()
                .includes(term)
        )
    })
})

const getInitials = (user) => {
    const name = user?.nom_complet ?? 'Supervisor'

    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((word) => word.charAt(0).toUpperCase())
        .join('')
}

const getSubtitle = (user) => {
    return (
        user?.encadrant?.departement ||
        user?.encadrant?.specialite ||
        user?.encadrant?.poste ||
        'Supervisor'
    )
}

const openEditModal = async (user) => {
    selectedEncadrant.value = user
    showEditModal.value = true

    await nextTick()

    editModal.value?.initializeForm(user)
}

const closeEditModal = () => {
    showEditModal.value = false
    selectedEncadrant.value = null
}

const deleteEncadrant = (user) => {
    const confirmed = window.confirm(
        `Are you sure you want to delete ${user.nom_complet}?`
    )

    if (!confirmed) {
        return
    }

    router.delete(
        appRoute(
            'entreprise.encadrants.destroy',
            user.id
        ),
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Company Supervisors" />

    <EntrepriseLayout>
        <main class="min-h-screen bg-[#F4F7F9]">
            <div
                class="mx-auto max-w-7xl
                       px-4 py-6
                       sm:px-6 lg:px-8"
            >
                <SupervisorHeader
                    :total="encadrants.length"
                    :create-url="
                        appRoute(
                            'entreprise.encadrants.create'
                        )
                    "
                />
                <section
                    class="mt-6 overflow-hidden
                           rounded-2xl border
                           border-slate-200
                           bg-white shadow-sm"
                >
                    <div
                        class="flex flex-col gap-3
                               border-b border-slate-100
                               bg-white px-5 py-3.5
                               sm:flex-row
                               sm:items-center
                               sm:justify-between
                               sm:px-6"
                    >
                        <div>
                            <h2
                                class="text-sm font-bold
                                       text-[#16425B]"
                            >
                                Supervisors
                            </h2>
                            <p
                                class="mt-0.5 text-[10px]
                                       text-slate-400"
                            >
                                Manage the supervisors
                                assigned to your company.
                            </p>
                        </div>

                        <SupervisorSearch
                            v-model="search"
                        />
                    </div>

                    <div class="p-4 sm:p-5">
                        <SupervisorGrid
                            :supervisors="filteredEncadrants"
                            :get-initials="getInitials"
                            :get-subtitle="getSubtitle"
                            @edit="openEditModal"
                            @delete="deleteEncadrant"
                        />
                    </div>
                </section>
            </div>
        </main>

        <SupervisorEditModal
            ref="editModal"
            :show="showEditModal"
            :user="selectedEncadrant"
            :update-url="
                (id) =>
                    appRoute(
                        'entreprise.encadrants.update',
                        id
                    )
            "
            @close="closeEditModal"
        />
    </EntrepriseLayout>
</template>