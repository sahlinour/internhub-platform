<script setup>
import { computed, ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import Icon from '@/Components/Admin/Icon.vue'

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

const search = ref(props.filters?.search ?? '')
const status = ref(props.filters?.statut ?? '')

/* =========================
   STATISTICS
========================= */

const totalStages = computed(() =>
    props.stages?.total ?? 0
)

const activeStages = computed(() =>
    (props.stages?.data ?? []).filter(
        stage => stage.statut === 'En cours'
    ).length
)

const completedStages = computed(() =>
    (props.stages?.data ?? []).filter(
        stage => stage.statut === 'Terminée'
    ).length
)

const cancelledStages = computed(() =>
    (props.stages?.data ?? []).filter(
        stage => stage.statut === 'Annulée'
    ).length
)

const stats = computed(() => [
    {
        label: 'Total Internships',
        value: totalStages.value,
        detail: 'All registered internships',
        icon: 'briefcase',
    },
    {
        label: 'Active',
        value: activeStages.value,
        detail: 'Currently in progress',
        icon: 'check',
    },
    {
        label: 'Completed',
        value: completedStages.value,
        detail: 'Completed internships',
        icon: 'graduation',
    },
    {
        label: 'Cancelled',
        value: cancelledStages.value,
        detail: 'Cancelled internships',
        icon: 'alert',
    },
])

/* =========================
   FILTERS
========================= */

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

    router.get(
        route('admin.stages.index'),
        {},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

/* =========================
   HELPERS
========================= */

const formatDate = (date) => {
    if (!date) {
        return '—'
    }

    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric',
    }).format(new Date(date))
}

const getInternName = (stage) => {
    return (
        stage?.candidature?.stagiaire?.user?.nom_complet
        ?? 'Not assigned'
    )
}

const getCompanyName = (stage) => {
    return (
        stage?.candidature?.offre_de_stage?.entreprise?.user?.nom_complet
        ?? stage?.candidature?.offreDeStage?.entreprise?.user?.nom_complet
        ?? 'Not available'
    )
}

const getSupervisorName = (stage) => {
    return (
        stage?.encadrant?.user?.nom_complet
        ?? 'Not assigned'
    )
}

const statusLabel = (stageStatus) => {
    if (stageStatus === 'En cours') {
        return 'Active'
    }

    if (stageStatus === 'Terminée') {
        return 'Completed'
    }

    if (stageStatus === 'Annulée') {
        return 'Cancelled'
    }

    return stageStatus || 'Unknown'
}

const statusClasses = (stageStatus) => {
    if (stageStatus === 'En cours') {
        return 'bg-[#e8f6ee] text-[#3e9663]'
    }

    if (stageStatus === 'Terminée') {
        return 'bg-[#e9f1f8] text-[#3e7195]'
    }

    if (stageStatus === 'Annulée') {
        return 'bg-[#fbecec] text-[#bd5b5b]'
    }

    return 'bg-[#eef2f5] text-[#718491]'
}



/* =========================
   PAGINATION
========================= */

const goToPage = (url) => {
    if (!url) {
        return
    }

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
    <Head title="Internships" />

    <AdminLayout>
        <div class="w-full">

            <!-- =========================
                 HEADER
            ========================== -->
            <header
                class="mb-5 flex items-center
                       justify-between gap-5
                       max-[700px]:flex-col
                       max-[700px]:items-start"
            >
                <div>
                    <h1
                        class="mb-[5px]
                               text-[22px] font-bold
                               text-[#20394b]"
                    >
                        Internships
                    </h1>

                    <p
                        class="m-0 text-[11px]
                               text-[#8799a7]"
                    >
                        Monitor and manage internship placements across InternHub.
                    </p>
                </div>


            </header>

            <!-- =========================
                 STATS
            ========================== -->
            <section
                class="mb-[18px]
                       grid grid-cols-4 gap-[14px]
                       max-[1100px]:grid-cols-2
                       max-[700px]:grid-cols-1"
            >
                <StatCard
                    v-for="stat in stats"
                    :key="stat.label"
                    v-bind="stat"
                />
            </section>

            <!-- =========================
                 INTERNSHIPS CARD
            ========================== -->
            <DashboardCard>

                <!-- CARD HEADER -->
                <div
                    class="mb-4 flex items-center
                           justify-between gap-[15px]
                           max-[700px]:items-start"
                >
                    <div>
                        <h2
                            class="mb-1 text-[14px]
                                   font-bold text-[#294355]"
                        >
                            All Internships
                        </h2>

                        <p
                            class="m-0 text-[9px]
                                   text-[#91a0ab]"
                        >
                            Manage internship placements and their current status.
                        </p>
                    </div>

                    <span
                        class="shrink-0 rounded-full
                               bg-[#edf4f8]
                               px-[10px] py-1.5
                               text-[9px] font-bold
                               text-[#47748e]"
                    >
                        {{ stages.total ?? 0 }} total
                    </span>
                </div>

                <!-- =========================
                     FILTERS
                ========================== -->
                <form
                    class="mb-4 flex items-center
                           gap-[9px]
                           max-[700px]:flex-col
                           max-[700px]:items-stretch"
                    @submit.prevent="applyFilters"
                >
                    <!-- SEARCH -->
                    <div
                        class="flex h-[38px]
                               w-[280px]
                               items-center gap-2
                               rounded-lg
                               border border-[#dce5eb]
                               bg-white px-[11px]
                               text-[#91a1ad]
                               focus-within:border-[#6694ad]
                               focus-within:ring-[3px]
                               focus-within:ring-[#326d8b]/10
                               max-[700px]:w-full"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            width="16"
                            height="16"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="shrink-0"
                        >
                            <circle
                                cx="11"
                                cy="11"
                                r="7"
                            />

                            <path d="m20 20-3.5-3.5" />
                        </svg>

                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search internship or intern..."
                            class="w-full
                                   border-0 bg-transparent
                                   p-0 text-[10px]
                                   text-[#3f596b]
                                   outline-none ring-0
                                   placeholder:text-[#9aa9b4]
                                   focus:border-0
                                   focus:ring-0"
                        />
                    </div>

                    <!-- STATUS -->
                    <select
                        v-model="status"
                        class="h-[38px]
                               rounded-lg
                               border border-[#dce5eb]
                               bg-white px-[11px]
                               text-[10px]
                               text-[#526b7c]
                               outline-none
                               focus:border-[#6694ad]
                               focus:ring-[3px]
                               focus:ring-[#326d8b]/10"
                    >
                        <option value="">
                            All statuses
                        </option>

                        <option value="En cours">
                            Active
                        </option>

                        <option value="Terminée">
                            Completed
                        </option>

                        <option value="Annulée">
                            Cancelled
                        </option>
                    </select>

                    <!-- APPLY -->
                    <button
                        type="submit"
                        class="h-[38px]
                               rounded-lg
                               border border-[#174966]
                               bg-[#174966]
                               px-[15px]
                               text-[10px]
                               font-semibold
                               text-white
                               transition
                               hover:bg-[#123e57]"
                    >
                        Apply
                    </button>

                    <!-- CLEAR -->
                    <button
                        v-if="search || status"
                        type="button"
                        class="h-[38px]
                               rounded-lg
                               border border-[#dce5eb]
                               bg-white px-[15px]
                               text-[10px]
                               font-semibold
                               text-[#687f8f]
                               transition
                               hover:bg-[#f8fafb]"
                        @click="clearFilters"
                    >
                        Clear
                    </button>
                </form>

                <!-- =========================
                     TABLE
                ========================== -->
                <div class="w-full overflow-x-auto">

                    <table
                        v-if="stages.data?.length"
                        class="w-full
                               min-w-[1100px]
                               border-collapse"
                    >
                        <!-- TABLE HEADER -->
                        <thead class="bg-[#f8fafc]">
                            <tr>
                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left
                                           text-[9px] font-semibold
                                           text-[#7d909e]"
                                >
                                    Internship
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left
                                           text-[9px] font-semibold
                                           text-[#7d909e]"
                                >
                                    Intern
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left
                                           text-[9px] font-semibold
                                           text-[#7d909e]"
                                >
                                    Company
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left
                                           text-[9px] font-semibold
                                           text-[#7d909e]"
                                >
                                    Supervisor
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left
                                           text-[9px] font-semibold
                                           text-[#7d909e]"
                                >
                                    Period
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left
                                           text-[9px] font-semibold
                                           text-[#7d909e]"
                                >
                                    Status
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-right
                                           text-[9px] font-semibold
                                           text-[#7d909e]"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <!-- TABLE BODY -->
                        <tbody>
                            <tr
                                v-for="stage in stages.data"
                                :key="stage.id"
                                class="transition-colors
                                       hover:bg-[#fafcfd]"
                            >
                                <!-- INTERNSHIP -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-[10px] py-[13px]
                                           align-middle"
                                >
                                    <div
                                        class="flex min-w-[205px]
                                               items-center gap-[10px]"
                                    >
                                        <div
                                            class="flex
                                                   h-[34px] w-[34px]
                                                   shrink-0
                                                   items-center
                                                   justify-center
                                                   rounded-lg
                                                   bg-[#e8f2f7]
                                                   text-[#276b90]"
                                        >
                                            <Icon
                                                name="briefcase"
                                                :size="16"
                                            />
                                        </div>

                                        <div class="min-w-0">
                                            <strong
                                                class="mb-[3px]
                                                       block
                                                       max-w-[200px]
                                                       overflow-hidden
                                                       text-ellipsis
                                                       whitespace-nowrap
                                                       text-[10px]
                                                       font-bold
                                                       text-[#294355]"
                                            >
                                                {{
                                                    stage.sujet
                                                    || 'Untitled internship'
                                                }}
                                            </strong>

                                            <span
                                                class="text-[8px]
                                                       text-[#97a5af]"
                                            >
                                                Internship #{{ stage.id }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- INTERN -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-[10px] py-[13px]
                                           align-middle"
                                >
                                    <div
                                        class="flex min-w-[140px]
                                               items-center gap-[7px]"
                                    >
                                        <div
                                            class="flex
                                                   h-[27px] w-[27px]
                                                   shrink-0
                                                   items-center
                                                   justify-center
                                                   rounded-full
                                                   bg-[#e6f0f5]
                                                   text-[9px]
                                                   font-bold
                                                   text-[#346c89]"
                                        >
                                            {{
                                                getInternName(stage)
                                                    .charAt(0)
                                                    .toUpperCase()
                                            }}
                                        </div>

                                        <span
                                            class="text-[10px]
                                                   text-[#435c6d]"
                                        >
                                            {{ getInternName(stage) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- COMPANY -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-[10px] py-[13px]
                                           text-[10px]
                                           text-[#435c6d]"
                                >
                                    {{ getCompanyName(stage) }}
                                </td>

                                <!-- SUPERVISOR -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-[10px] py-[13px]
                                           text-[10px]
                                           text-[#435c6d]"
                                >
                                    {{ getSupervisorName(stage) }}
                                </td>

                                <!-- PERIOD -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-[10px] py-[13px]"
                                >
                                    <div class="min-w-[115px]">
                                        <strong
                                            class="mb-0.5 block
                                                   text-[9px]
                                                   font-semibold
                                                   text-[#425c6d]"
                                        >
                                            {{ formatDate(stage.date_debut) }}
                                        </strong>

                                        <span
                                            class="text-[8px]
                                                   text-[#95a3ad]"
                                        >
                                            to
                                            {{ formatDate(stage.date_fin) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- STATUS -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-[10px] py-[13px]"
                                >
                                    <span
                                        class="inline-flex
                                               items-center gap-[5px]
                                               whitespace-nowrap
                                               rounded-full
                                               px-2 py-[5px]
                                               text-[8px]
                                               font-bold"
                                        :class="
                                            statusClasses(
                                                stage.statut
                                            )
                                        "
                                    >
                                        <span
                                            class="h-[5px] w-[5px]
                                                   rounded-full
                                                   bg-current"
                                        ></span>

                                        {{
                                            statusLabel(
                                                stage.statut
                                            )
                                        }}
                                    </span>
                                </td>


                            </tr>
                        </tbody>
                    </table>

                    <!-- =========================
                         EMPTY STATE
                    ========================== -->
                    <div
                        v-else
                        class="flex flex-col
                               items-center
                               px-5 py-[55px]
                               text-center"
                    >
                        <div
                            class="mb-3 flex
                                   h-[50px] w-[50px]
                                   items-center
                                   justify-center
                                   rounded-full
                                   bg-[#edf4f8]
                                   text-[#447893]"
                        >
                            <Icon
                                name="briefcase"
                                :size="24"
                            />
                        </div>

                        <h3
                            class="mb-[5px]
                                   text-[13px]
                                   font-bold
                                   text-[#334f61]"
                        >
                            No internships found
                        </h3>

                        <p
                            class="mb-[15px]
                                   text-[10px]
                                   text-[#92a1ac]"
                        >
                            There are currently no internships matching your filters.
                        </p>

                        <div
                            class="flex items-center
                                   justify-center gap-2
                                   max-[500px]:flex-col"
                        >
                            <button
                                v-if="search || status"
                                type="button"
                                class="rounded-[7px]
                                       border
                                       border-[#dce5eb]
                                       bg-white
                                       px-[13px] py-2
                                       text-[9px]
                                       font-semibold
                                       text-[#617888]
                                       transition
                                       hover:bg-[#f8fafb]"
                                @click="clearFilters"
                            >
                                Clear filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- =========================
                     PAGINATION
                ========================== -->
                <div
                    v-if="stages.links?.length > 3"
                    class="flex items-center
                           justify-between
                           gap-[15px]
                           pt-[15px]
                           max-[700px]:flex-col
                           max-[700px]:items-start"
                >
                    <div
                        class="text-[9px]
                               text-[#8a9ba7]"
                    >
                        Showing

                        <strong
                            class="text-[#4b6475]"
                        >
                            {{ stages.from ?? 0 }}
                        </strong>

                        –

                        <strong
                            class="text-[#4b6475]"
                        >
                            {{ stages.to ?? 0 }}
                        </strong>

                        of

                        <strong
                            class="text-[#4b6475]"
                        >
                            {{ stages.total ?? 0 }}
                        </strong>
                    </div>

                    <div
                        class="flex flex-wrap gap-1"
                    >
                        <button
                            v-for="link in stages.links"
                            :key="link.label"
                            type="button"
                            :disabled="!link.url"
                            class="h-[29px]
                                   min-w-[29px]
                                   rounded-md
                                   border
                                   border-[#dce5eb]
                                   bg-white
                                   px-2
                                   text-[9px]
                                   text-[#647b8b]
                                   transition
                                   hover:bg-[#f5f9fb]
                                   disabled:cursor-default
                                   disabled:opacity-40"
                            :class="
                                link.active
                                    ? '!border-[#174966] !bg-[#174966] !text-white'
                                    : ''
                            "
                            @click="
                                goToPage(
                                    link.url
                                )
                            "
                            v-html="link.label"
                        />
                    </div>
                </div>

            </DashboardCard>
        </div>
    </AdminLayout>
</template>
