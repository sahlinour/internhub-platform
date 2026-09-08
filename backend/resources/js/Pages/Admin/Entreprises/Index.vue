<script setup>
import { computed, ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'

const props = defineProps({
    entreprises: {
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
})

const search = ref(props.filters?.search ?? '')

/* =========================
   STATS
========================= */

const totalCompanies = computed(() => props.entreprises?.total ?? 0)

const activeCompanies = computed(() =>
    (props.entreprises?.data ?? []).filter(
        company => company.user?.etat === 'active'
    ).length
)

const pendingCompanies = computed(() =>
    (props.entreprises?.data ?? []).filter(
        company => company.user?.etat === 'pending'
    ).length
)

const blockedCompanies = computed(() =>
    (props.entreprises?.data ?? []).filter(
        company => company.user?.etat === 'block'
    ).length
)

const stats = computed(() => [
    {
        label: 'Total Companies',
        value: totalCompanies.value,
        detail: 'Registered companies',
        icon: 'company',
    },
    {
        label: 'Active',
        value: activeCompanies.value,
        detail: 'Active company accounts',
        icon: 'check',
    },
    {
        label: 'Pending',
        value: pendingCompanies.value,
        detail: 'Waiting for approval',
        icon: 'clock',
    },
    {
        label: 'Suspended',
        value: blockedCompanies.value,
        detail: 'Suspended accounts',
        icon: 'alert',
    },
])

/* =========================
   DELETE
========================= */

const deleteCompany = (id) => {
    if (!confirm('Are you sure you want to delete this company?')) {
        return
    }

    router.delete(
        route('admin.entreprises.destroy', id),
        {
            preserveScroll: true,
        }
    )
}

/* =========================
   SEARCH
========================= */

const applySearch = () => {
    router.get(
        route('admin.entreprises.index'),
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

const clearSearch = () => {
    search.value = ''

    router.get(
        route('admin.entreprises.index'),
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

const initials = (name) => {
    if (!name) return 'CO'

    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase()
}

const statusLabel = (etat) => {
    if (etat === 'active') return 'Active'
    if (etat === 'pending') return 'Pending'
    if (etat === 'block') return 'Suspended'

    return etat || 'Unknown'
}

const statusClasses = (etat) => {
    if (etat === 'active') {
        return 'bg-[#e8f6ee] text-[#3f9a65]'
    }

    if (etat === 'pending') {
        return 'bg-[#fff3dc] text-[#c28b2a]'
    }

    if (etat === 'block') {
        return 'bg-[#fceaea] text-[#c25d5d]'
    }

    return 'bg-[#edf2f5] text-[#6c8290]'
}
</script>

<template>
    <Head title="Companies" />

    <AdminLayout>
        <div class="w-full">

            <!-- ================= HEADER ================= -->

            <header
                class="mb-[18px] flex items-center justify-between gap-5
                       max-[700px]:flex-col
                       max-[700px]:items-start"
            >
                <div>
                    <h1
                        class="mb-[5px] text-[22px]
                               font-bold text-[#20394b]"
                    >
                        Companies
                    </h1>

                    <p class="m-0 text-[11px] text-[#8798a6]">
                        Manage companies registered on InternHub.
                    </p>
                </div>

                <Link
                    :href="route('admin.entreprises.create')"
                    class="inline-flex min-h-[39px]
                           items-center justify-center gap-[7px]
                           rounded-lg bg-[#174966]
                           px-[15px]
                           text-[10px] font-semibold text-white
                           no-underline transition
                           hover:-translate-y-px
                           hover:bg-[#123e57]
                           max-[700px]:w-full"
                >
                    <svg
                        viewBox="0 0 24 24"
                        width="15"
                        height="15"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                    >
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>

                    <span>Add Company</span>
                </Link>
            </header>

            <!-- ================= STATS ================= -->

            <section
                class="mb-[18px] grid grid-cols-4 gap-[14px]
                       max-[1100px]:grid-cols-2
                       max-[700px]:grid-cols-1"
            >
                <StatCard
                    v-for="stat in stats"
                    :key="stat.label"
                    v-bind="stat"
                />
            </section>

            <!-- ================= TABLE CARD ================= -->

            <DashboardCard>

                <!-- TOOLBAR -->

                <div
                    class="mb-[15px] flex items-center
                           justify-between gap-5
                           max-[700px]:flex-col
                           max-[700px]:items-start"
                >
                    <div>
                        <h2
                            class="mb-[3px] text-[13px]
                                   font-bold text-[#294355]"
                        >
                            All Companies
                        </h2>

                        <p class="m-0 text-[9px] text-[#91a0ab]">
                            View and manage company accounts.
                        </p>
                    </div>

                    <!-- SEARCH -->

                    <form
                        class="flex h-[38px] w-[260px]
                               items-center gap-2 rounded-lg
                               border border-[#dce5eb]
                               bg-white px-[10px]
                               text-[#91a1ad]
                               focus-within:border-[#6694ad]
                               focus-within:ring-[3px]
                               focus-within:ring-[#326d8b]/10
                               max-[700px]:w-full"
                        @submit.prevent="applySearch"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            width="15"
                            height="15"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            class="shrink-0"
                        >
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-3.5-3.5" />
                        </svg>

                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search companies..."
                            class="min-w-0 flex-1 border-0
                                   bg-transparent p-0
                                   text-[10px] text-[#40596b]
                                   outline-none ring-0
                                   placeholder:text-[#a0adb7]
                                   focus:border-0
                                   focus:outline-none
                                   focus:ring-0"
                        />

                        <button
                            v-if="search"
                            type="button"
                            class="border-0 bg-transparent
                                   text-[15px] leading-none
                                   text-[#8b9ca8]
                                   hover:text-[#40596b]"
                            @click="clearSearch"
                        >
                            ×
                        </button>
                    </form>
                </div>

                <!-- ================= TABLE ================= -->

                <div class="w-full overflow-x-auto">

                    <table
                        v-if="entreprises.data?.length"
                        class="w-full min-w-[800px]
                               border-collapse"
                    >
                        <thead class="bg-[#f8fafc]">
                            <tr>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left text-[9px]
                                           font-semibold text-[#7f909e]"
                                >
                                    Company
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left text-[9px]
                                           font-semibold text-[#7f909e]"
                                >
                                    Sector
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left text-[9px]
                                           font-semibold text-[#7f909e]"
                                >
                                    City
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left text-[9px]
                                           font-semibold text-[#7f909e]"
                                >
                                    Website
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left text-[9px]
                                           font-semibold text-[#7f909e]"
                                >
                                    Status
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e7edf1]
                                           px-[10px] py-[11px]
                                           text-left text-[9px]
                                           font-semibold text-[#7f909e]"
                                >
                                    Actions
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            <tr
                                v-for="company in entreprises.data"
                                :key="company.user_id"
                                class="transition-colors
                                       hover:bg-[#fafcfd]"
                            >

                                <!-- COMPANY -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[10px] py-3
                                           align-middle
                                           text-[10px] text-[#425c6d]"
                                >
                                    <div
                                        class="flex min-w-[180px]
                                               items-center gap-[9px]"
                                    >

                                        <div
                                            class="flex h-[31px] w-[31px]
                                                   shrink-0 items-center
                                                   justify-center
                                                   rounded-lg
                                                   bg-[#286d93]
                                                   text-[8px]
                                                   font-bold text-white"
                                        >
                                            {{
                                                initials(
                                                    company.user?.nom_complet
                                                )
                                            }}
                                        </div>

                                        <div class="min-w-0">

                                            <strong
                                                class="mb-0.5 block
                                                       max-w-[180px]
                                                       overflow-hidden
                                                       text-ellipsis
                                                       whitespace-nowrap
                                                       text-[10px]
                                                       font-bold
                                                       text-[#294355]"
                                            >
                                                {{
                                                    company.user?.nom_complet
                                                    ?? 'Unnamed company'
                                                }}
                                            </strong>

                                            <span
                                                class="block max-w-[180px]
                                                       overflow-hidden
                                                       text-ellipsis
                                                       whitespace-nowrap
                                                       text-[8px]
                                                       text-[#91a0ab]"
                                            >
                                                {{
                                                    company.user?.email
                                                    ?? 'No email'
                                                }}
                                            </span>

                                        </div>
                                    </div>
                                </td>

                                <!-- SECTOR -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[10px] py-3
                                           align-middle
                                           text-[10px] text-[#425c6d]"
                                >
                                    {{
                                        company.secteur
                                        || 'Not specified'
                                    }}
                                </td>

                                <!-- CITY -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[10px] py-3
                                           align-middle
                                           text-[10px] text-[#425c6d]"
                                >
                                    {{
                                        company.user?.ville?.nom
                                        ?? 'Not specified'
                                    }}
                                </td>

                                <!-- WEBSITE -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[10px] py-3
                                           align-middle
                                           text-[10px] text-[#425c6d]"
                                >
                                    <a
                                        v-if="company.site_web"
                                        :href="company.site_web"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-[9px]
                                               font-semibold
                                               text-[#2e7195]
                                               no-underline
                                               hover:underline"
                                    >
                                        Visit website
                                    </a>

                                    <span
                                        v-else
                                        class="text-[9px] text-[#91a0ab]"
                                    >
                                        Not available
                                    </span>
                                </td>

                                <!-- STATUS -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[10px] py-3
                                           align-middle"
                                >
                                    <span
                                        class="inline-flex min-w-[62px]
                                               items-center justify-center
                                               rounded-full
                                               px-[9px] py-[5px]
                                               text-[8px] font-bold"
                                        :class="
                                            statusClasses(
                                                company.user?.etat
                                            )
                                        "
                                    >
                                        {{
                                            statusLabel(
                                                company.user?.etat
                                            )
                                        }}
                                    </span>
                                </td>

                                <!-- ACTIONS -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[10px] py-3
                                           align-middle"
                                >
                                    <div
                                        class="flex items-center
                                               gap-1.5 whitespace-nowrap"
                                    >

                                        <!-- VIEW -->

                                        <Link
                                            :href="
                                                route(
                                                    'admin.entreprises.show',
                                                    company.user_id
                                                )
                                            "
                                            class="rounded-md border
                                                   border-[#dce5eb]
                                                   bg-white
                                                   px-2 py-1.5
                                                   text-[8px]
                                                   font-semibold
                                                   text-[#536f80]
                                                   no-underline
                                                   transition
                                                   hover:bg-[#f5f9fb]"
                                        >
                                            View
                                        </Link>

                                        <!-- EDIT -->

                                        <Link
                                            :href="
                                                route(
                                                    'admin.entreprises.edit',
                                                    company.user_id
                                                )
                                            "
                                            class="rounded-md border
                                                   border-[#dce5eb]
                                                   bg-white
                                                   px-2 py-1.5
                                                   text-[8px]
                                                   font-semibold
                                                   text-[#536f80]
                                                   no-underline
                                                   transition
                                                   hover:bg-[#f5f9fb]"
                                        >
                                            Edit
                                        </Link>

                                        <!-- DELETE -->

                                        <button
                                            type="button"
                                            class="rounded-md border
                                                   border-[#f0cccc]
                                                   bg-white
                                                   px-2 py-1.5
                                                   text-[8px]
                                                   font-semibold
                                                   text-[#c95858]
                                                   transition
                                                   hover:border-[#e5aaaa]
                                                   hover:bg-[#fff5f5]"
                                            @click="
                                                deleteCompany(
                                                    company.user_id
                                                )
                                            "
                                        >
                                            Delete
                                        </button>

                                    </div>
                                </td>

                            </tr>

                        </tbody>
                    </table>

                    <!-- ================= EMPTY STATE ================= -->

                    <div
                        v-else
                        class="flex flex-col items-center
                               px-5 py-[55px]
                               text-center"
                    >
                        <div
                            class="mb-3 flex h-[50px] w-[50px]
                                   items-center justify-center
                                   rounded-full
                                   bg-[#edf4f8]
                                   text-[#447893]"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                width="23"
                                height="23"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect
                                    x="3"
                                    y="3"
                                    width="18"
                                    height="18"
                                    rx="2"
                                />

                                <path d="M9 21V9h6v12" />

                                <path
                                    d="
                                        M7 6h.01
                                        M12 6h.01
                                        M17 6h.01
                                    "
                                />
                            </svg>
                        </div>

                        <h3
                            class="mb-[5px]
                                   text-[13px] font-bold
                                   text-[#334f61]"
                        >
                            No companies found
                        </h3>

                        <p class="m-0 text-[10px] text-[#92a1ac]">
                            No company accounts match your current search.
                        </p>

                        <button
                            v-if="search"
                            type="button"
                            class="mt-4 rounded-lg
                                   border border-[#dce5eb]
                                   bg-white px-3 py-2
                                   text-[9px] font-semibold
                                   text-[#536f80]
                                   transition
                                   hover:bg-[#f5f9fb]"
                            @click="clearSearch"
                        >
                            Clear search
                        </button>
                    </div>

                </div>

                <!-- ================= PAGINATION ================= -->

                <div
                    v-if="entreprises.links?.length > 3"
                    class="flex items-center
                           justify-between gap-[15px]
                           pt-[15px]
                           max-[700px]:flex-col
                           max-[700px]:items-start"
                >

                    <div class="text-[9px] text-[#8a9ba7]">
                        Showing

                        <strong>
                            {{ entreprises.from ?? 0 }}
                        </strong>

                        –

                        <strong>
                            {{ entreprises.to ?? 0 }}
                        </strong>

                        of

                        <strong>
                            {{ entreprises.total ?? 0 }}
                        </strong>
                    </div>

                    <div class="flex flex-wrap gap-1">

                        <button
                            v-for="link in entreprises.links"
                            :key="link.label"
                            type="button"
                            :disabled="!link.url"
                            class="h-[29px] min-w-[29px]
                                   rounded-md border
                                   border-[#dce5eb]
                                   bg-white px-2
                                   text-[9px] text-[#647b8b]
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
                                link.url &&
                                router.get(
                                    link.url,
                                    {},
                                    {
                                        preserveState: true,
                                        preserveScroll: true,
                                    }
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
