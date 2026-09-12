<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

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

const editForm = useForm({
    nom_complet: '',
    email: '',
    telephone: '',
    poste: '',
    specialite: '',
    departement: '',
    ville_id: '',
})

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

const openEditModal = (user) => {
    selectedEncadrant.value = user

    editForm.nom_complet = user?.nom_complet ?? ''
    editForm.email = user?.email ?? ''
    editForm.telephone = user?.telephone ?? ''
    editForm.poste = user?.encadrant?.poste ?? ''
    editForm.specialite = user?.encadrant?.specialite ?? ''
    editForm.departement = user?.encadrant?.departement ?? ''
    editForm.ville_id = user?.ville_id ?? ''

    editForm.clearErrors()
    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    selectedEncadrant.value = null

    editForm.reset()
    editForm.clearErrors()
}

const submitEdit = () => {
    if (!selectedEncadrant.value) {
        return
    }

    editForm.put(
        appRoute(
            'entreprise.encadrants.update',
            selectedEncadrant.value.id
        ),
        {
            preserveScroll: true,
            onSuccess: () => {
                closeEditModal()
            },
        }
    )
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
    <EntrepriseLayout>
        <Head title="Company Supervisors" />

        <div class="space-y-6">

            <!-- HEADER -->
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-slate-900"
                    >
                        Company Supervisors
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Team leads supervising your interns
                    </p>
                </div>

                <Link
                    :href="appRoute('entreprise.encadrants.create')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#17253f] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#213451]"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 5v14M5 12h14"
                        />
                    </svg>

                    Add Company Supervisor
                </Link>
            </div>

            <!-- SEARCH -->
            <div class="max-w-md">
                <div class="relative">
                    <svg
                        class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            cx="11"
                            cy="11"
                            r="8"
                            stroke-width="2"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-width="2"
                            d="m21 21-4.35-4.35"
                        />
                    </svg>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search supervisors..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                    />
                </div>
            </div>

            <!-- SUPERVISOR CARDS -->
            <div
                v-if="filteredEncadrants.length"
                class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3"
            >
                <div
                    v-for="user in filteredEncadrants"
                    :key="user.id"
                    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md"
                >
                    <!-- PROFILE -->
                    <div class="flex items-start gap-3">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#16537a] text-sm font-bold text-white"
                        >
                            {{ getInitials(user) }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3
                                class="truncate text-sm font-semibold text-slate-900"
                            >
                                {{ user.nom_complet }}
                            </h3>

                            <p
                                class="mt-1 truncate text-xs text-slate-500"
                            >
                                {{ getSubtitle(user) }}
                            </p>
                        </div>
                    </div>

                    <!-- CONTACT -->
                    <div class="mt-5 space-y-3">
                        <div>
                            <p
                                class="text-[11px] font-medium uppercase tracking-wide text-slate-400"
                            >
                                Email
                            </p>

                            <p
                                class="mt-1 truncate text-sm text-slate-700"
                            >
                                {{ user.email }}
                            </p>
                        </div>

                        <div v-if="user.telephone">
                            <p
                                class="text-[11px] font-medium uppercase tracking-wide text-slate-400"
                            >
                                Phone
                            </p>

                            <p class="mt-1 text-sm text-slate-700">
                                {{ user.telephone }}
                            </p>
                        </div>
                    </div>

                    <!-- PROFESSIONAL DETAILS -->
                    <div
                        v-if="
                            user.encadrant?.poste ||
                            user.encadrant?.specialite ||
                            user.encadrant?.departement
                        "
                        class="mt-4 flex flex-wrap gap-2"
                    >
                        <span
                            v-if="user.encadrant?.poste"
                            class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-medium text-slate-600"
                        >
                            {{ user.encadrant.poste }}
                        </span>

                        <span
                            v-if="user.encadrant?.specialite"
                            class="rounded-full bg-sky-50 px-2.5 py-1 text-[11px] font-medium text-sky-700"
                        >
                            {{ user.encadrant.specialite }}
                        </span>

                        <span
                            v-if="user.encadrant?.departement"
                            class="rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-medium text-indigo-700"
                        >
                            {{ user.encadrant.departement }}
                        </span>
                    </div>

                    <!-- FOOTER -->
                    <div
                        class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4"
                    >
                        <div class="min-w-0">
                            <p
                                class="text-[11px] font-medium uppercase tracking-wide text-slate-400"
                            >
                                City
                            </p>

                            <p
                                class="mt-1 truncate text-xs font-medium text-slate-600"
                            >
                                {{ user.ville?.nom ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="flex shrink-0 items-center gap-2">
                            <button
                                type="button"
                                @click="openEditModal(user)"
                                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-[#17253f] hover:text-[#17253f]"
                            >
                                Edit
                            </button>

                            <button
                                type="button"
                                @click="deleteEncadrant(user)"
                                class="rounded-lg border border-red-100 bg-white px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-50"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EMPTY STATE -->
            <div
                v-else
                class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm"
            >
                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100"
                >
                    <svg
                        class="h-6 w-6 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m13-8a4 4 0 1 0 0-8"
                        />
                    </svg>
                </div>

                <h3
                    class="mt-4 text-sm font-semibold text-slate-900"
                >
                    No company supervisors found
                </h3>

                <p
                    class="mx-auto mt-2 max-w-sm text-sm text-slate-500"
                >
                    Create a supervisor account so they can access
                    InternHub and supervise interns.
                </p>

                <Link
                    :href="appRoute('entreprise.encadrants.create')"
                    class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-[#17253f] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#213451]"
                >
                    <span class="text-base leading-none">+</span>

                    Add Company Supervisor
                </Link>
            </div>

        </div>

        <!-- EDIT MODAL -->
        <div
            v-if="showEditModal"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/40 p-4 backdrop-blur-sm"
            @click.self="closeEditModal"
        >
            <div
                class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl"
            >
                <!-- MODAL HEADER -->
                <div
                    class="flex items-center justify-between border-b border-slate-200 px-6 py-5"
                >
                    <div>
                        <h2
                            class="text-lg font-bold text-slate-900"
                        >
                            Edit Company Supervisor
                        </h2>

                        <p
                            class="mt-1 text-sm text-slate-500"
                        >
                            Update supervisor information
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="closeEditModal"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- EDIT FORM -->
                <form
                    @submit.prevent="submitEdit"
                    class="p-6"
                >
                    <div
                        class="grid grid-cols-1 gap-5 md:grid-cols-2"
                    >
                        <!-- NAME -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Full Name
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="editForm.nom_complet"
                                type="text"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="editForm.errors.nom_complet"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ editForm.errors.nom_complet }}
                            </p>
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Email
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="editForm.email"
                                type="email"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="editForm.errors.email"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ editForm.errors.email }}
                            </p>
                        </div>

                        <!-- PHONE -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Phone
                            </label>

                            <input
                                v-model="editForm.telephone"
                                type="text"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="editForm.errors.telephone"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ editForm.errors.telephone }}
                            </p>
                        </div>

                        <!-- POSITION -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Position
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="editForm.poste"
                                type="text"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="editForm.errors.poste"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ editForm.errors.poste }}
                            </p>
                        </div>

                        <!-- SPECIALITY -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Speciality
                            </label>

                            <input
                                v-model="editForm.specialite"
                                type="text"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="editForm.errors.specialite"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ editForm.errors.specialite }}
                            </p>
                        </div>

                        <!-- DEPARTMENT -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Department
                            </label>

                            <input
                                v-model="editForm.departement"
                                type="text"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="editForm.errors.departement"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ editForm.errors.departement }}
                            </p>
                        </div>

                        <!-- CITY ID -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                City ID
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="editForm.ville_id"
                                type="number"
                                min="1"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="editForm.errors.ville_id"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ editForm.errors.ville_id }}
                            </p>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div
                        class="mt-7 flex justify-end gap-3 border-t border-slate-100 pt-5"
                    >
                        <button
                            type="button"
                            @click="closeEditModal"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            :disabled="editForm.processing"
                            class="rounded-xl bg-[#17253f] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#213451] disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            {{
                                editForm.processing
                                    ? 'Saving...'
                                    : 'Save Changes'
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </EntrepriseLayout>
</template>
