<script setup>
import { computed, ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'

const props = defineProps({
    stagiaires: {
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

const totalInterns = computed(() =>
    props.stagiaires?.total ?? 0
)

const activeInterns = computed(() =>
    (props.stagiaires?.data ?? []).filter(
        intern => intern.user?.etat === 'active'
    ).length
)

const suspendedInterns = computed(() =>
    (props.stagiaires?.data ?? []).filter(
        intern => intern.user?.etat === 'block'
    ).length
)

const pendingInterns = computed(() =>
    (props.stagiaires?.data ?? []).filter(
        intern => intern.user?.etat === 'pending'
    ).length
)

const stats = computed(() => [
    {
        label: 'Total Interns',
        value: totalInterns.value,
        detail: 'Registered interns',
        icon: 'users',
    },
    {
        label: 'Active',
        value: activeInterns.value,
        detail: 'Active accounts',
        icon: 'check',
    },
    {
        label: 'Suspended',
        value: suspendedInterns.value,
        detail: 'Blocked accounts',
        icon: 'alert',
    },
    {
        label: 'Pending',
        value: pendingInterns.value,
        detail: 'Waiting for activation',
        icon: 'user',
    },
])

/* =========================
   SEARCH
========================= */

const applySearch = () => {
    router.get(
        route('admin.stagiaires.index'),
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
        route('admin.stagiaires.index'),
        {},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

/* =========================
   DELETE
========================= */

const deleteIntern = (intern) => {
    const name =
        intern.user?.nom_complet ?? 'this intern'

    if (
        !window.confirm(
            `Are you sure you want to delete ${name}?`
        )
    ) {
        return
    }

    router.delete(
        route(
            'admin.stagiaires.destroy',
            intern.user_id
        ),
        {
            preserveScroll: true,
        }
    )
}

/* =========================
   HELPERS
========================= */

const initials = (name) => {
    if (!name) return 'IN'

    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase()
}

const statusLabel = (etat) => {
    if (etat === 'active') return 'Active'
    if (etat === 'block') return 'Suspended'
    if (etat === 'pending') return 'Pending'

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
    <Head title="Interns" />

    <AdminLayout>
        <div class="w-full">

            <!-- HEADER -->
            <header
                class="mb-[18px] flex items-center justify-between gap-5
                       max-[700px]:flex-col
                       max-[700px]:items-start"
            >
                <div>
                    <h1
                        class="mb-[5px]
                               text-[22px] font-bold
                               text-[#20394b]"
                    >
                        Interns
                    </h1>

                    <p
                        class="m-0 text-[11px]
                               text-[#8798a6]"
                    >
                        Manage all registered interns on the platform.
                    </p>
                </div>

                <!-- ADD INTERN -->
                <form
                    action="/admin/stagiaires/create"
                    method="GET"
                    class="max-[700px]:w-full"
                >
                    <button
                        type="submit"
                        class="inline-flex min-h-[40px]
                               cursor-pointer items-center
                               justify-center gap-2
                               rounded-lg bg-[#174966]
                               px-4
                               text-[10px] font-semibold
                               text-white
                               shadow-[0_4px_12px_rgba(23,73,102,0.14)]
                               transition
                               hover:-translate-y-px
                               hover:bg-[#123e57]
                               max-[700px]:w-full"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            width="16"
                            height="16"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>

                        Add Intern
                    </button>
                </form>
            </header>

            <!-- STATS -->
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

            <!-- TABLE CARD -->
            <DashboardCard>

                <!-- TOOLBAR -->
                <div
                    class="mb-[15px]
                           flex items-center
                           justify-between gap-5
                           max-[700px]:flex-col
                           max-[700px]:items-start"
                >
                    <div>
                        <h2
                            class="mb-[3px]
                                   text-[13px] font-bold
                                   text-[#294355]"
                        >
                            All Interns
                        </h2>

                        <p
                            class="m-0 text-[9px]
                                   text-[#91a0ab]"
                        >
                            {{ stagiaires.total ?? 0 }}
                            registered interns
                        </p>
                    </div>

                    <!-- SEARCH -->
                    <form
                        class="flex h-[38px] w-[260px]
                               items-center gap-2
                               rounded-lg
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
                            placeholder="Search interns..."
                            class="min-w-0 flex-1
                                   border-0 bg-transparent p-0
                                   text-[10px] text-[#40596b]
                                   outline-none ring-0
                                   placeholder:text-[#a0adb7]
                                   focus:border-0
                                   focus:ring-0"
                        />

                        <button
                            v-if="search"
                            type="button"
                            class="border-0
                                   bg-transparent
                                   text-[15px] leading-none
                                   text-[#8b9ca8]
                                   hover:text-[#40596b]"
                            @click="clearSearch"
                        >
                            ×
                        </button>
                    </form>
                </div>

                <!-- TABLE -->
                <div class="w-full overflow-x-auto">

                    <table
                        v-if="stagiaires.data?.length"
                        class="w-full min-w-[1050px]
                               border-collapse"
                    >
                        <thead class="bg-[#f8fafc]">
                            <tr>

                                <th class="border-y border-[#e7edf1] px-[10px] py-[11px] text-left text-[9px] font-semibold text-[#7f909e]">
                                    Intern
                                </th>

                                <th class="border-y border-[#e7edf1] px-[10px] py-[11px] text-left text-[9px] font-semibold text-[#7f909e]">
                                    University
                                </th>

                                <th class="border-y border-[#e7edf1] px-[10px] py-[11px] text-left text-[9px] font-semibold text-[#7f909e]">
                                    Field
                                </th>

                                <th class="border-y border-[#e7edf1] px-[10px] py-[11px] text-left text-[9px] font-semibold text-[#7f909e]">
                                    Level
                                </th>

                                <th class="border-y border-[#e7edf1] px-[10px] py-[11px] text-left text-[9px] font-semibold text-[#7f909e]">
                                    Internship Status
                                </th>

                                <th class="border-y border-[#e7edf1] px-[10px] py-[11px] text-left text-[9px] font-semibold text-[#7f909e]">
                                    Account Status
                                </th>

                                <th class="border-y border-[#e7edf1] px-[10px] py-[11px] text-right text-[9px] font-semibold text-[#7f909e]">
                                    Actions
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            <tr
                                v-for="intern in stagiaires.data"
                                :key="intern.user_id"
                                class="transition-colors
                                       hover:bg-[#fafcfd]"
                            >

                                <!-- INTERN -->
                                <td class="border-b border-[#edf1f4] px-[10px] py-3">
                                    <div class="flex min-w-[180px] items-center gap-[9px]">

                                        <div
                                            class="flex h-[30px] w-[30px]
                                                   shrink-0 items-center
                                                   justify-center
                                                   rounded-full
                                                   bg-[#286d93]
                                                   text-[8px] font-bold
                                                   text-white"
                                        >
                                            {{ initials(intern.user?.nom_complet) }}
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
                                                    intern.user?.nom_complet
                                                    ?? 'Unnamed intern'
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
                                                    intern.user?.email
                                                    ?? 'No email'
                                                }}
                                            </span>

                                        </div>
                                    </div>
                                </td>

                                <td class="border-b border-[#edf1f4] px-[10px] py-3 text-[10px] text-[#425c6d]">
                                    {{ intern.universite || 'Not specified' }}
                                </td>

                                <td class="border-b border-[#edf1f4] px-[10px] py-3 text-[10px] text-[#425c6d]">
                                    {{ intern.filiere || 'Not specified' }}
                                </td>

                                <td class="border-b border-[#edf1f4] px-[10px] py-3 text-[10px] text-[#425c6d]">
                                    {{ intern.niveau || 'Not specified' }}
                                </td>

                                <td class="border-b border-[#edf1f4] px-[10px] py-3">
                                    <span
                                        class="inline-flex rounded-full
                                               bg-[#edf3f7]
                                               px-2 py-[5px]
                                               text-[8px] font-semibold
                                               capitalize
                                               text-[#547183]"
                                    >
                                        {{ intern.statut_stage || 'Unknown' }}
                                    </span>
                                </td>

                                <td class="border-b border-[#edf1f4] px-[10px] py-3">
                                    <span
                                        class="inline-flex min-w-[60px]
                                               items-center
                                               justify-center
                                               rounded-full
                                               px-[9px] py-[5px]
                                               text-[8px] font-bold"
                                        :class="statusClasses(intern.user?.etat)"
                                    >
                                        {{ statusLabel(intern.user?.etat) }}
                                    </span>
                                </td>

                                <!-- ACTIONS -->
                                <td class="border-b border-[#edf1f4] px-[10px] py-3">

                                    <div
                                        class="flex items-center
                                               justify-end gap-1.5
                                               whitespace-nowrap"
                                    >

                                        <Link
                                            :href="
                                                route(
                                                    'admin.stagiaires.show',
                                                    intern.user_id
                                                )
                                            "
                                            class="inline-flex min-h-[30px]
                                                   items-center
                                                   justify-center
                                                   rounded-md
                                                   border border-[#dce5eb]
                                                   bg-white px-[10px]
                                                   text-[9px] font-semibold
                                                   text-[#536f80]
                                                   no-underline transition
                                                   hover:border-[#bfd0da]
                                                   hover:bg-[#f4f8fa]
                                                   hover:text-[#174966]"
                                        >
                                            View
                                        </Link>

                                        <Link
                                            :href="
                                                route(
                                                    'admin.stagiaires.edit',
                                                    intern.user_id
                                                )
                                            "
                                            class="inline-flex min-h-[30px]
                                                   items-center
                                                   justify-center
                                                   rounded-md
                                                   border border-[#dce5eb]
                                                   bg-white px-[10px]
                                                   text-[9px] font-semibold
                                                   text-[#536f80]
                                                   no-underline transition
                                                   hover:border-[#bfd0da]
                                                   hover:bg-[#f4f8fa]
                                                   hover:text-[#174966]"
                                        >
                                            Edit
                                        </Link>

                                        <button
                                            type="button"
                                            class="inline-flex min-h-[30px]
                                                   items-center
                                                   justify-center
                                                   rounded-md
                                                   border border-[#f0cccc]
                                                   bg-white px-[10px]
                                                   text-[9px] font-semibold
                                                   text-[#c95858]
                                                   transition
                                                   hover:border-[#e7aaaa]
                                                   hover:bg-[#fff4f4]
                                                   hover:text-[#b83e3e]"
                                            @click="deleteIntern(intern)"
                                        >
                                            Delete
                                        </button>

                                    </div>
                                </td>

                            </tr>

                        </tbody>
                    </table>

                    <!-- EMPTY STATE -->
                    <div
                        v-else
                        class="flex flex-col
                               items-center px-5
                               py-[55px] text-center"
                    >
                        <div
                            class="mb-3 flex
                                   h-[50px] w-[50px]
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
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>

                        <h3
                            class="mb-[5px]
                                   text-[13px] font-bold
                                   text-[#334f61]"
                        >
                            No interns found
                        </h3>

                        <p
                            class="m-0 text-[10px]
                                   text-[#92a1ac]"
                        >
                            No intern accounts match your current search.
                        </p>

                        <form
                            action="/admin/stagiaires/create"
                            method="GET"
                            class="mt-4"
                        >
                            <button
                                type="submit"
                                class="inline-flex min-h-[36px]
                                       cursor-pointer
                                       items-center justify-center
                                       rounded-lg bg-[#174966]
                                       px-4 text-[9px]
                                       font-semibold text-white
                                       transition
                                       hover:bg-[#123e57]"
                            >
                                Add Intern
                            </button>
                        </form>
                    </div>

                </div>

                <!-- PAGINATION -->
                <div
                    v-if="stagiaires.links?.length > 3"
                    class="flex items-center
                           justify-between gap-[15px]
                           pt-[15px]
                           max-[700px]:flex-col
                           max-[700px]:items-start"
                >
                    <div class="text-[9px] text-[#8a9ba7]">
                        Showing

                        <strong>
                            {{ stagiaires.from ?? 0 }}
                        </strong>

                        –

                        <strong>
                            {{ stagiaires.to ?? 0 }}
                        </strong>

                        of

                        <strong>
                            {{ stagiaires.total ?? 0 }}
                        </strong>
                    </div>

                    <div class="flex flex-wrap gap-1">

                        <button
                            v-for="link in stagiaires.links"
                            :key="link.label"
                            type="button"
                            :disabled="!link.url"
                            class="h-[29px] min-w-[29px]
                                   rounded-md border
                                   border-[#dce5eb]
                                   bg-white px-2
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
