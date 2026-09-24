<script setup>
import { computed, ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'

const props = defineProps({
    stages: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            total: 0,
            from: 0,
            to: 0,
        }),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
})

const search = ref(props.filters.search ?? '')
const status = ref(props.filters.statut ?? '')

const statusLabels = {
    en_cours: 'Active',
    termine: 'Completed',
    annule: 'Cancelled',
}

const statusLabel = (value) =>
    statusLabels[value] ?? value ?? 'Unknown'

const statusClasses = (value) => {
    switch (value) {
        case 'en_cours':
            return 'bg-[#e8f6ee] text-[#3e9663]'
        case 'termine':
            return 'bg-[#e9f1f8] text-[#3e7195]'
        case 'annule':
            return 'bg-[#fbecec] text-[#bd5b5b]'
        default:
            return 'bg-[#eef2f5] text-[#718491]'
    }
}

const stats = computed(() => {
    const currentPage = props.stages.data ?? []

    return [
        {
            label: 'Total Internships',
            value: props.stages.total ?? 0,
            detail: 'All registered internships',
            icon: 'briefcase',
        },
        {
            label: 'Active on this page',
            value: currentPage.filter(stage => stage.statut === 'en_cours').length,
            detail: 'Currently in progress',
            icon: 'check',
        },
        {
            label: 'Completed on this page',
            value: currentPage.filter(stage => stage.statut === 'termine').length,
            detail: 'Completed internships',
            icon: 'graduation',
        },
        {
            label: 'Cancelled on this page',
            value: currentPage.filter(stage => stage.statut === 'annule').length,
            detail: 'Cancelled internships',
            icon: 'alert',
        },
    ]
})

const applyFilters = () => {
    router.get(
        route('admin.stages.index'),
        {
            search: search.value || undefined,
            statut: status.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

const clearFilters = () => {
    search.value = ''
    status.value = ''

    router.get(route('admin.stages.index'), {}, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}

const formatDate = (value) => {
    if (!value) return '—'

    const [year, month, day] = String(value).slice(0, 10).split('-')
    if (!year || !month || !day) return '—'

    return `${day}/${month}/${year}`
}

const getInternName = (stage) =>
    stage?.candidature?.stagiaire?.user?.nom_complet ?? 'Not assigned'

const getCompanyName = (stage) =>
    stage?.candidature?.offre_de_stage?.entreprise?.user?.nom_complet
    ?? stage?.candidature?.offreDeStage?.entreprise?.user?.nom_complet
    ?? 'Not available'

const getSupervisorName = (stage) =>
    stage?.encadrant?.user?.nom_complet ?? 'Not assigned'

const goToPage = (url) => {
    if (!url) return

    router.get(url, {}, {
        preserveState: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Internships" />

    <AdminLayout>
        <div class="w-full">
            <header class="mb-5">
                <h1 class="text-[22px] font-bold text-[#20394b]">
                    Internships
                </h1>
                <p class="mt-1 text-[11px] text-[#8799a7]">
                    Monitor and manage internship placements across InternHub.
                </p>
            </header>

            <section class="mb-[18px] grid grid-cols-1 gap-[14px] sm:grid-cols-2 xl:grid-cols-4">
                <StatCard
                    v-for="stat in stats"
                    :key="stat.label"
                    v-bind="stat"
                />
            </section>

            <DashboardCard>
                <div class="mb-4 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-[14px] font-bold text-[#294355]">
                            All Internships
                        </h2>
                        <p class="mt-1 text-[9px] text-[#91a0ab]">
                            Manage placements and their current status.
                        </p>
                    </div>

                    <span class="rounded-full bg-[#edf4f8] px-3 py-1 text-[9px] font-bold text-[#47748e]">
                        {{ stages.total ?? 0 }} total
                    </span>
                </div>

                <form
                    class="mb-5 flex flex-wrap items-center gap-2"
                    @submit.prevent="applyFilters"
                >
                    <input
                        v-model="search"
                        type="search"
                        placeholder="Search internship or intern..."
                        class="min-h-[38px] w-full rounded-lg border border-[#dce5eb] px-3 text-[10px] text-[#3f596b] sm:w-[280px]"
                    />

                    <select
                        v-model="status"
                        class="min-h-[38px] rounded-lg border border-[#dce5eb] bg-white px-3 text-[10px] text-[#526b7c]"
                    >
                        <option value="">All statuses</option>
                        <option value="en_cours">Active</option>
                        <option value="termine">Completed</option>
                        <option value="annule">Cancelled</option>
                    </select>

                    <button
                        type="submit"
                        class="min-h-[38px] rounded-lg bg-[#174966] px-4 text-[10px] font-semibold text-white"
                    >
                        Apply
                    </button>

                    <button
                        type="button"
                        class="min-h-[38px] rounded-lg border border-[#dce5eb] px-4 text-[10px] font-semibold text-[#617888]"
                        @click="clearFilters"
                    >
                        Clear
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table
                        v-if="stages.data?.length"
                        class="w-full min-w-[850px] text-left text-[10px]"
                    >
                        <thead class="border-y border-[#e7edf1] bg-[#f8fafc] text-[#7d909e]">
                            <tr>
                                <th class="px-3 py-3 font-semibold">Internship</th>
                                <th class="px-3 py-3 font-semibold">Intern</th>
                                <th class="px-3 py-3 font-semibold">Company</th>
                                <th class="px-3 py-3 font-semibold">Supervisor</th>
                                <th class="px-3 py-3 font-semibold">Period</th>
                                <th class="px-3 py-3 font-semibold">Status</th>
                                <th class="px-3 py-3 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="stage in stages.data"
                                :key="stage.id"
                                class="border-b border-[#edf1f4] hover:bg-[#fafcfd]"
                            >
                                <td class="px-3 py-4 font-semibold text-[#294355]">
                                    {{ stage.sujet || 'Untitled internship' }}
                                </td>

                                <td class="px-3 py-4 text-[#435c6d]">
                                    {{ getInternName(stage) }}
                                </td>

                                <td class="px-3 py-4 text-[#435c6d]">
                                    {{ getCompanyName(stage) }}
                                </td>

                                <td class="px-3 py-4 text-[#435c6d]">
                                    {{ getSupervisorName(stage) }}
                                </td>

                                <td class="px-3 py-4 text-[#435c6d]">
                                    {{ formatDate(stage.date_debut) }}
                                    <span class="block text-[9px] text-[#95a3ad]">
                                        to {{ formatDate(stage.date_fin) }}
                                    </span>
                                </td>

                                <td class="px-3 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-[9px] font-bold"
                                        :class="statusClasses(stage.statut)"
                                    >
                                        {{ statusLabel(stage.statut) }}
                                    </span>
                                </td>

                                <td class="px-3 py-4 text-right">
                                    <Link
                                        :href="route('admin.stages.show', stage.id)"
                                        class="font-semibold text-[#276b90] hover:underline"
                                    >
                                        View
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div v-else class="px-5 py-14 text-center">
                        <h3 class="text-[13px] font-bold text-[#334f61]">
                            No internships found
                        </h3>
                        <p class="mt-1 text-[10px] text-[#92a1ac]">
                            There are no internships matching your filters.
                        </p>
                    </div>
                </div>

                <div
                    v-if="stages.links?.length > 3"
                    class="mt-5 flex flex-wrap items-center justify-between gap-3"
                >
                    <p class="text-[10px] text-[#8a9ba7]">
                        Showing {{ stages.from ?? 0 }}–{{ stages.to ?? 0 }}
                        of {{ stages.total ?? 0 }}
                    </p>

                    <div class="flex flex-wrap gap-1">
                        <button
                            v-for="(link, index) in stages.links"
                            :key="index"
                            type="button"
                            :disabled="!link.url"
                            class="min-h-[30px] min-w-[30px] rounded-md border border-[#dce5eb] px-2 text-[10px] disabled:opacity-40"
                            :class="link.active
                                ? 'border-[#174966] bg-[#174966] text-white'
                                : 'bg-white text-[#647b8b]'"
                            @click="goToPage(link.url)"
                            v-html="link.label"
                        />
                    </div>
                </div>
            </DashboardCard>
        </div>
    </AdminLayout>
</template>
