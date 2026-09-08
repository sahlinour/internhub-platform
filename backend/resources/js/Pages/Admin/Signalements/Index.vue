<script setup>
import { computed, ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import SearchInput from '@/Components/Admin/SearchInput.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    signalements: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            total: 0,
        }),
    },

    filters: {
        type: Object,
        default: () => ({}),
    },

    stats: {
        type: Object,
        default: () => ({
            total: 0,
            pending: 0,
            removed: 0,
            dismissed: 0,
        }),
    },
})

const search = ref(props.filters?.search ?? '')

const statCards = computed(() => [
    {
        label: 'Total Reports',
        value: props.stats?.total ?? 0,
        detail: 'All reported listings',
        icon: 'alert',
    },
    {
        label: 'Pending Review',
        value: props.stats?.pending ?? 0,
        detail: 'Waiting for review',
        icon: 'clock',
    },
    {
        label: 'Removed',
        value: props.stats?.removed ?? 0,
        detail: 'Listings removed',
        icon: 'alert',
    },
    {
        label: 'Dismissed',
        value: props.stats?.dismissed ?? 0,
        detail: 'Reports dismissed',
        icon: 'check',
    },
])

const searchReports = () => {
    router.get(
        route('admin.signalements.index'),
        {
            search: search.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

const formatDate = (date) => {
    if (!date) return '—'

    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}

const reporterName = (report) => {
    return (
        report?.emetteur?.nom_complet
        ?? 'Unknown user'
    )
}

const offerTitle = (report) => {
    return (
        report?.offre_de_stage?.titre
        ?? report?.offreDeStage?.titre
        ?? 'Unknown internship offer'
    )
}

const companyName = (report) => {
    return (
        report?.offre_de_stage?.entreprise?.user?.nom_complet
        ?? report?.offreDeStage?.entreprise?.user?.nom_complet
        ?? 'Unknown company'
    )
}

const updateStatus = (report, status) => {
    router.patch(
        route('admin.signalements.updateStatus', report.id),
        {
            statut: status,
        },
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Reported Listings" />

    <AdminLayout>
        <div class="w-full">

            <!-- ================= HEADER ================= -->

            <header class="mb-5">
                <div>
                    <h1
                        class="mb-[5px]
                               text-[22px] font-bold
                               text-[#20394b]"
                    >
                        Reported Listings
                    </h1>

                    <p
                        class="m-0 text-[11px]
                               text-[#8798a6]"
                    >
                        Review internship offers reported by users.
                    </p>
                </div>
            </header>

            <!-- ================= STATS ================= -->

            <section
                class="mb-[18px]
                       grid grid-cols-4 gap-[14px]
                       max-[1100px]:grid-cols-2
                       max-[700px]:grid-cols-1"
            >
                <StatCard
                    v-for="stat in statCards"
                    :key="stat.label"
                    v-bind="stat"
                    class="min-w-0"
                />
            </section>

            <!-- ================= REPORTS ================= -->

            <DashboardCard>

                <!-- TOOLBAR -->

                <div
                    class="mb-5 flex
                           items-center justify-between
                           gap-5
                           max-[700px]:flex-col
                           max-[700px]:items-stretch"
                >
                    <div>
                        <h2
                            class="mb-1
                                   text-[14px] font-bold
                                   text-[#294355]"
                        >
                            All Reports
                        </h2>

                        <p
                            class="m-0
                                   text-[10px]
                                   text-[#8f9faa]"
                        >
                            {{ signalements.total ?? 0 }} reports
                        </p>
                    </div>

                    <SearchInput
                        v-model="search"
                        placeholder="Search reported listings..."
                        @search="searchReports"
                    />
                </div>

                <!-- ================= REPORT LIST ================= -->

                <div
                    v-if="signalements.data?.length"
                    class="flex flex-col gap-[14px]"
                >
                    <article
                        v-for="report in signalements.data"
                        :key="report.id"
                        class="rounded-[11px]
                               border border-[#e3e9ed]
                               bg-white p-4
                               shadow-[0_2px_8px_rgba(30,60,80,0.03)]"
                    >

                        <!-- REPORT TOP -->

                        <div
                            class="mb-3
                                   flex items-start justify-between
                                   gap-5
                                   max-[700px]:flex-col"
                        >
                            <div class="min-w-0">

                                <h3
                                    class="mb-[5px]
                                           text-[11px] font-bold
                                           text-[#294355]"
                                >
                                    {{ offerTitle(report) }}

                                    <span
                                        class="font-semibold
                                               text-[#738895]"
                                    >
                                        · {{ companyName(report) }}
                                    </span>
                                </h3>

                                <p
                                    class="m-0
                                           text-[9px]
                                           text-[#8c9ca7]"
                                >
                                    Reported by

                                    <strong
                                        class="font-bold
                                               text-[#607685]"
                                    >
                                        {{ reporterName(report) }}
                                    </strong>

                                    <span class="mx-[5px]">
                                        ·
                                    </span>

                                    {{
                                        formatDate(
                                            report.date_signalement
                                        )
                                    }}
                                </p>
                            </div>

                            <StatusBadge
                                :status="report.statut"
                            />
                        </div>

                        <!-- ================= REASON ================= -->

                        <div
                            class="flex min-h-11
                                   items-center gap-[9px]
                                   rounded-lg
                                   bg-[#fceaea]
                                   px-3 py-[10px]
                                   text-[10px]
                                   text-[#b95757]"
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
                                <path d="M5 5v14" />
                                <path d="M5 5h10l-1 4 1 4H5" />
                            </svg>

                            <span>
                                {{
                                    report.raison
                                    ?? 'No report reason provided.'
                                }}
                            </span>
                        </div>

                        <!-- ================= ACTIONS ================= -->

                        <div
                            class="mt-3
                                   flex items-center gap-2
                                   max-[700px]:flex-col
                                   max-[700px]:items-stretch"
                        >

                            <!-- DISMISS -->

                            <button
                                type="button"
                                class="inline-flex min-h-[34px]
                                       items-center justify-center
                                       rounded-[7px]
                                       border border-[#dce5ea]
                                       bg-white
                                       px-3
                                       text-[9px] font-bold
                                       text-[#526c7c]
                                       transition
                                       hover:bg-[#f5f8fa]
                                       max-[700px]:w-full"
                                @click="
                                    updateStatus(
                                        report,
                                        'dismissed'
                                    )
                                "
                            >
                                Dismiss
                            </button>

                            <!-- REMOVE -->

                            <button
                                type="button"
                                class="inline-flex min-h-[34px]
                                       items-center justify-center
                                       rounded-[7px]
                                       border border-[#f0d4d4]
                                       bg-white
                                       px-3
                                       text-[9px] font-bold
                                       text-[#c45454]
                                       transition
                                       hover:bg-[#fff3f3]
                                       max-[700px]:w-full"
                                @click="
                                    updateStatus(
                                        report,
                                        'removed'
                                    )
                                "
                            >
                                Remove Listing
                            </button>

                        </div>

                    </article>
                </div>

                <!-- ================= EMPTY STATE ================= -->

                <div
                    v-else
                    class="flex flex-col
                           items-center
                           px-5 py-[60px]
                           text-center"
                >
                    <div
                        class="mb-3
                               flex h-[54px] w-[54px]
                               items-center justify-center
                               rounded-[14px]
                               bg-[#edf4f8]
                               text-[#447893]"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            width="25"
                            height="25"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="M10.3 2.9 1.8 17a2 2 0 0 0
                                1.7 3h17a2 2 0 0 0 1.7-3
                                L13.7 2.9a2 2 0 0 0-3.4 0Z"
                            />

                            <path d="M12 9v4" />
                            <path d="M12 17h.01" />
                        </svg>
                    </div>

                    <h3
                        class="mb-[5px]
                               text-[13px] font-bold
                               text-[#334f61]"
                    >
                        No reports found
                    </h3>

                    <p
                        class="m-0
                               text-[10px]
                               text-[#92a1ac]"
                    >
                        There are currently no reported internship offers.
                    </p>
                </div>

            </DashboardCard>

        </div>
    </AdminLayout>
</template>
