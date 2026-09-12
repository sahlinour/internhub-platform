<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'
import StatCard from '@/Components/Entreprise/StatCard.vue'

const props = defineProps({
    offres: {
        type: Array,
        default: () => [],
    },
})

const showEditModal = ref(false)
const editingOffer = ref(null)

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}

const form = useForm({
    titre: '',
    description: '',
    duree: '',
    date_limite: '',
    statut: 'active',
})

const stats = computed(() => ({
    total: props.offres.length,
    active: props.offres.filter(
        offre => offre.statut === 'active'
    ).length,
    inactive: props.offres.filter(
        offre => offre.statut === 'inactive'
    ).length,
    closed: props.offres.filter(
        offre => offre.statut === 'closed'
    ).length,
}))

const openEditModal = (offre) => {
    editingOffer.value = offre

    form.clearErrors()

    form.titre = offre.titre ?? ''
    form.description = offre.description ?? ''
    form.duree = offre.duree ?? ''
    form.date_limite = offre.date_limite
        ? String(offre.date_limite).substring(0, 10)
        : ''
    form.statut = offre.statut ?? 'active'

    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    editingOffer.value = null

    form.reset()
    form.clearErrors()
    form.statut = 'active'
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
    const confirmed = window.confirm(
        'Are you sure you want to delete this internship?'
    )

    if (!confirmed) {
        return
    }

    router.delete(
        appRoute(
            'entreprise.offres.destroy',
            id
        ),
        {
            preserveScroll: true,
        }
    )
}

const formatDate = (date) => {
    if (!date) {
        return '—'
    }

    return new Intl.DateTimeFormat(
        'en-GB',
        {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        }
    ).format(new Date(date))
}

const statusClass = (status) => {
    switch (status) {
        case 'active':
            return 'bg-emerald-50 text-emerald-600'

        case 'inactive':
            return 'bg-amber-50 text-amber-600'

        case 'closed':
            return 'bg-red-50 text-red-500'

        default:
            return 'bg-slate-100 text-slate-500'
    }
}
</script>

<template>
    <Head title="Internships" />

    <EntrepriseLayout>
        <!-- PAGE HEADER -->
        <div
            class="mb-6 flex flex-col gap-4
                   sm:flex-row
                   sm:items-center
                   sm:justify-between"
        >
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Internships
                </h1>

                <p class="mt-1 text-sm text-slate-400">
                    Manage your posted internship listings
                </p>
            </div>

            <Link
                :href="appRoute('entreprise.offres.create')"
                class="inline-flex
                       items-center
                       justify-center
                       gap-2
                       rounded-xl
                       bg-[#102F42]
                       px-5 py-3
                       text-xs
                       font-semibold
                       text-white
                       shadow-sm
                       transition
                       hover:bg-[#174E6D]"
            >
                <span class="text-base">+</span>

                Post New Internship
            </Link>
        </div>

        <!-- STATS -->
        <div
            class="grid grid-cols-1
                   gap-4
                   sm:grid-cols-2
                   xl:grid-cols-4"
        >
            <StatCard
                title="Total Postings"
                :value="stats.total"
                icon="briefcase"
                icon-bg="bg-blue-50"
                icon-color="text-[#2d7da0]"
            />

            <StatCard
                title="Active"
                :value="stats.active"
                icon="check"
                icon-bg="bg-emerald-50"
                icon-color="text-emerald-500"
            />

            <StatCard
                title="Inactive"
                :value="stats.inactive"
                icon="briefcase"
                icon-bg="bg-amber-50"
                icon-color="text-amber-500"
            />

            <StatCard
                title="Closed"
                :value="stats.closed"
                icon="briefcase"
                icon-bg="bg-red-50"
                icon-color="text-red-500"
            />
        </div>

        <!-- TABLE -->
        <div
            class="mt-6 overflow-hidden
                   rounded-2xl
                   border border-slate-200
                   bg-white
                   shadow-sm"
        >
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] table-fixed">
                    <thead>
                        <tr
                            class="border-b
                                   border-slate-200
                                   bg-slate-50/80"
                        >
                            <th
                                class="w-[38%]
                                       px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       tracking-wide
                                       text-slate-500"
                            >
                                Internship
                            </th>

                            <th
                                class="w-[16%]
                                       px-4 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       tracking-wide
                                       text-slate-500"
                            >
                                Duration
                            </th>

                            <th
                                class="w-[18%]
                                       px-4 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       tracking-wide
                                       text-slate-500"
                            >
                                Deadline
                            </th>

                            <th
                                class="w-[13%]
                                       px-4 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       tracking-wide
                                       text-slate-500"
                            >
                                Status
                            </th>

                            <th
                                class="w-[15%]
                                       px-6 py-4
                                       text-right
                                       text-xs
                                       font-semibold
                                       uppercase
                                       tracking-wide
                                       text-slate-500"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="offre in offres"
                            :key="offre.id"
                            class="transition
                                   duration-150
                                   hover:bg-slate-50/70"
                        >
                            <!-- INTERNSHIP -->
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10
                                               shrink-0
                                               items-center
                                               justify-center
                                               rounded-xl
                                               bg-[#edf7fb]
                                               text-[#2d7da0]"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            class="h-5 w-5"
                                        >
                                            <rect
                                                x="3"
                                                y="7"
                                                width="18"
                                                height="13"
                                                rx="2"
                                            />

                                            <path
                                                d="M8 7V5
                                                   a2 2 0 0 1 2-2h4
                                                   a2 2 0 0 1 2 2v2"
                                            />
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p
                                            class="truncate
                                                   text-sm
                                                   font-semibold
                                                   text-slate-800"
                                        >
                                            {{ offre.titre }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- DURATION -->
                            <td class="px-4 py-5">
                                <span
                                    class="inline-flex
                                           items-center
                                           rounded-full
                                           bg-blue-50
                                           px-3 py-1.5
                                           text-xs
                                           font-medium
                                           text-[#2d7da0]"
                                >
                                    {{ offre.duree ?? '—' }}
                                </span>
                            </td>

                            <!-- DEADLINE -->
                            <td
                                class="px-4 py-5
                                       text-sm
                                       font-medium
                                       text-slate-600"
                            >
                                {{ formatDate(offre.date_limite) }}
                            </td>

                            <!-- STATUS -->
                            <td class="px-4 py-5">
                                <span
                                    class="inline-flex
                                           items-center
                                           rounded-full
                                           px-3 py-1.5
                                           text-xs
                                           font-semibold
                                           capitalize"
                                    :class="statusClass(offre.statut)"
                                >
                                    <span
                                        class="mr-1.5
                                               h-1.5 w-1.5
                                               rounded-full
                                               bg-current"
                                    />

                                    {{ offre.statut ?? '—' }}
                                </span>
                            </td>

                            <!-- ACTIONS -->
                            <td class="px-6 py-5">
                                <div
                                    class="flex
                                           items-center
                                           justify-end
                                           gap-2"
                                >
                                    <button
                                        type="button"
                                        @click="openEditModal(offre)"
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               rounded-lg
                                               border
                                               border-slate-200
                                               bg-white
                                               px-3.5 py-2
                                               text-xs
                                               font-semibold
                                               text-slate-600
                                               transition
                                               hover:border-[#63A9C6]
                                               hover:bg-[#f0f8fb]
                                               hover:text-[#174E6D]"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        @click="deleteOffer(offre.id)"
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               rounded-lg
                                               border
                                               border-red-100
                                               bg-red-50
                                               px-3.5 py-2
                                               text-xs
                                               font-semibold
                                               text-red-500
                                               transition
                                               hover:border-red-200
                                               hover:bg-red-100"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- EMPTY STATE -->
                        <tr v-if="offres.length === 0">
                            <td
                                colspan="5"
                                class="px-6 py-20 text-center"
                            >
                                <div
                                    class="mx-auto
                                           flex h-14 w-14
                                           items-center
                                           justify-center
                                           rounded-2xl
                                           bg-slate-50
                                           text-slate-400"
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        class="h-6 w-6"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    >
                                        <rect
                                            x="3"
                                            y="7"
                                            width="18"
                                            height="13"
                                            rx="2"
                                        />

                                        <path
                                            d="M8 7V5
                                               a2 2 0 0 1 2-2h4
                                               a2 2 0 0 1 2 2v2"
                                        />
                                    </svg>
                                </div>

                                <p
                                    class="mt-4
                                           text-sm
                                           font-semibold
                                           text-slate-700"
                                >
                                    No internships posted yet
                                </p>

                                <p
                                    class="mt-1
                                           text-xs
                                           text-slate-400"
                                >
                                    Create your first internship opportunity.
                                </p>

                                <Link
                                    :href="appRoute('entreprise.offres.create')"
                                    class="mt-5
                                           inline-flex
                                           items-center
                                           justify-center
                                           rounded-lg
                                           bg-[#102F42]
                                           px-4 py-2.5
                                           text-xs
                                           font-semibold
                                           text-white
                                           transition
                                           hover:bg-[#174E6D]"
                                >
                                    + Post Internship
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div
            v-if="showEditModal"
            class="fixed inset-0
                   z-[100]
                   flex items-center
                   justify-center
                   bg-slate-950/40
                   px-4"
            @click.self="closeEditModal"
        >
            <div
                class="max-h-[90vh]
                       w-full
                       max-w-xl
                       overflow-y-auto
                       rounded-2xl
                       bg-white
                       p-6
                       shadow-2xl"
            >
                <!-- MODAL HEADER -->
                <div
                    class="flex
                           items-start
                           justify-between"
                >
                    <div>
                        <h2
                            class="text-lg
                                   font-bold
                                   text-slate-800"
                        >
                            Edit Internship
                        </h2>

                        <p
                            class="mt-1
                                   text-sm
                                   text-slate-400"
                        >
                            Update this internship opportunity.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="closeEditModal"
                        class="flex h-8 w-8
                               items-center
                               justify-center
                               rounded-lg
                               text-slate-400
                               transition
                               hover:bg-slate-100
                               hover:text-slate-700"
                    >
                        ✕
                    </button>
                </div>

                <!-- FORM -->
                <form
                    class="mt-6 space-y-4"
                    @submit.prevent="submitEdit"
                >
                    <!-- TITLE -->
                    <div>
                        <label
                            for="titre"
                            class="mb-1.5
                                   block
                                   text-xs
                                   font-semibold
                                   text-slate-600"
                        >
                            Internship Title
                        </label>

                        <input
                            id="titre"
                            v-model="form.titre"
                            type="text"
                            class="w-full
                                   rounded-lg
                                   border
                                   border-slate-200
                                   px-3 py-2.5
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   transition
                                   focus:border-[#63A9C6]
                                   focus:ring-2
                                   focus:ring-[#63A9C6]/10"
                            placeholder="e.g. Frontend Developer Internship"
                        />

                        <p
                            v-if="form.errors.titre"
                            class="mt-1
                                   text-xs
                                   text-red-500"
                        >
                            {{ form.errors.titre }}
                        </p>
                    </div>

                    <!-- DESCRIPTION -->
                    <div>
                        <label
                            for="description"
                            class="mb-1.5
                                   block
                                   text-xs
                                   font-semibold
                                   text-slate-600"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="5"
                            class="w-full
                                   resize-none
                                   rounded-lg
                                   border
                                   border-slate-200
                                   px-3 py-2.5
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   transition
                                   focus:border-[#63A9C6]
                                   focus:ring-2
                                   focus:ring-[#63A9C6]/10"
                            placeholder="Describe the internship..."
                        />

                        <p
                            v-if="form.errors.description"
                            class="mt-1
                                   text-xs
                                   text-red-500"
                        >
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1
                               gap-4
                               sm:grid-cols-2"
                    >
                        <!-- DURATION -->
                        <div>
                            <label
                                for="duree"
                                class="mb-1.5
                                       block
                                       text-xs
                                       font-semibold
                                       text-slate-600"
                            >
                                Duration
                            </label>

                            <input
                                id="duree"
                                v-model="form.duree"
                                type="text"
                                class="w-full
                                       rounded-lg
                                       border
                                       border-slate-200
                                       px-3 py-2.5
                                       text-sm
                                       text-slate-700
                                       outline-none
                                       focus:border-[#63A9C6]
                                       focus:ring-2
                                       focus:ring-[#63A9C6]/10"
                                placeholder="e.g. 3 months"
                            />

                            <p
                                v-if="form.errors.duree"
                                class="mt-1
                                       text-xs
                                       text-red-500"
                            >
                                {{ form.errors.duree }}
                            </p>
                        </div>

                        <!-- DEADLINE -->
                        <div>
                            <label
                                for="date_limite"
                                class="mb-1.5
                                       block
                                       text-xs
                                       font-semibold
                                       text-slate-600"
                            >
                                Application Deadline
                            </label>

                            <input
                                id="date_limite"
                                v-model="form.date_limite"
                                type="date"
                                class="w-full
                                       rounded-lg
                                       border
                                       border-slate-200
                                       px-3 py-2.5
                                       text-sm
                                       text-slate-700
                                       outline-none
                                       focus:border-[#63A9C6]
                                       focus:ring-2
                                       focus:ring-[#63A9C6]/10"
                            />

                            <p
                                v-if="form.errors.date_limite"
                                class="mt-1
                                       text-xs
                                       text-red-500"
                            >
                                {{ form.errors.date_limite }}
                            </p>
                        </div>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label
                            for="statut"
                            class="mb-1.5
                                   block
                                   text-xs
                                   font-semibold
                                   text-slate-600"
                        >
                            Status
                        </label>

                        <select
                            id="statut"
                            v-model="form.statut"
                            class="w-full
                                   rounded-lg
                                   border
                                   border-slate-200
                                   bg-white
                                   px-3 py-2.5
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   focus:border-[#63A9C6]
                                   focus:ring-2
                                   focus:ring-[#63A9C6]/10"
                        >
                            <option value="active">
                                Active
                            </option>

                            <option value="inactive">
                                Inactive
                            </option>

                            <option value="closed">
                                Closed
                            </option>
                        </select>

                        <p
                            v-if="form.errors.statut"
                            class="mt-1
                                   text-xs
                                   text-red-500"
                        >
                            {{ form.errors.statut }}
                        </p>
                    </div>

                    <!-- BUTTONS -->
                    <div
                        class="flex
                               justify-end
                               gap-3
                               border-t
                               border-slate-100
                               pt-5"
                    >
                        <button
                            type="button"
                            @click="closeEditModal"
                            class="rounded-lg
                                   border
                                   border-slate-200
                                   px-4 py-2.5
                                   text-xs
                                   font-semibold
                                   text-slate-600
                                   transition
                                   hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-lg
                                   bg-[#102F42]
                                   px-5 py-2.5
                                   text-xs
                                   font-semibold
                                   text-white
                                   transition
                                   hover:bg-[#174E6D]
                                   disabled:cursor-not-allowed
                                   disabled:opacity-50"
                        >
                            <span v-if="form.processing">
                                Saving...
                            </span>

                            <span v-else>
                                Save Changes
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </EntrepriseLayout>
</template>
