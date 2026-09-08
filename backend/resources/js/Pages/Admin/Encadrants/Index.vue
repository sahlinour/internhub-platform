<script setup>
import { computed, ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import SearchInput from '@/Components/Admin/SearchInput.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    encadrants: {
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

const stats = computed(() => [
    {
        label: 'Total Supervisors',
        value: props.encadrants?.total ?? 0,
        detail: 'Registered supervisors',
        icon: 'users',
    },
    {
        label: 'Active',
        value: (props.encadrants?.data ?? []).filter(
            item => item.user?.etat === 'active'
        ).length,
        detail: 'Active supervisor accounts',
        icon: 'check',
    },
    {
        label: 'Inactive',
        value: (props.encadrants?.data ?? []).filter(
            item => item.user?.etat !== 'active'
        ).length,
        detail: 'Inactive supervisor accounts',
        icon: 'alert',
    },
])

const deleteEncadrant = (id) => {
    if (!confirm('Are you sure you want to delete this supervisor?')) {
        return
    }

    router.delete(
        route('admin.encadrants.destroy', id),
        {
            preserveScroll: true,
        }
    )
}

const applySearch = () => {
    router.get(
        route('admin.encadrants.index'),
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
</script>

<template>
    <Head title="Company Supervisors" />

    <AdminLayout>
        <div class="w-full">

            <!-- ========================= -->
            <!-- HEADER -->
            <!-- ========================= -->

            <header
                class="mb-6 flex items-center justify-between gap-5
                       max-md:flex-col max-md:items-stretch"
            >
                <div class="min-w-0">
                    <h1
                        class="mb-1.5 text-2xl font-bold text-[#20394b]
                               max-md:text-[21px]
                               max-[480px]:text-[19px]"
                    >
                        Company Supervisors
                    </h1>

                    <p
                        class="m-0 text-xs text-[#8798a6]
                               max-[480px]:text-[10px]"
                    >
                        Employees supervising interns at partner companies.
                    </p>
                </div>

                <Link
                    :href="route('admin.encadrants.create')"
                    class="inline-flex min-h-[42px] shrink-0
                           items-center justify-center gap-2
                           rounded-[9px] bg-[#174966]
                           px-[18px] text-[11px] font-bold
                           text-white no-underline
                           shadow-[0_4px_12px_rgba(23,73,102,0.14)]
                           transition
                           hover:-translate-y-px
                           hover:bg-[#123e57]
                           hover:shadow-[0_6px_16px_rgba(23,73,102,0.2)]
                           max-md:w-full"
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
                        class="shrink-0"
                    >
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>

                    <span>Add Supervisor</span>
                </Link>
            </header>

            <!-- ========================= -->
            <!-- STATS -->
            <!-- ========================= -->

            <section
                class="mb-5 grid grid-cols-3 gap-4
                       max-[1100px]:grid-cols-2
                       max-md:grid-cols-1"
            >
                <StatCard
                    v-for="stat in stats"
                    :key="stat.label"
                    v-bind="stat"
                    class="min-w-0"
                />
            </section>

            <!-- ========================= -->
            <!-- TABLE CARD -->
            <!-- ========================= -->

            <div
                class="w-full rounded-xl border border-[#dfe7ec]
                       bg-white p-5
                       shadow-[0_4px_14px_rgba(31,58,75,0.05)]"
            >

                <!-- TOOLBAR -->

                <div
                    class="mb-[18px] flex items-center
                           justify-between gap-5
                           max-md:flex-col
                           max-md:items-stretch"
                >
                    <div>
                        <h2
                            class="mb-[5px] text-[15px]
                                   font-bold text-[#294355]"
                        >
                            All Supervisors
                        </h2>

                        <p class="m-0 text-[10px] text-[#8f9faa]">
                            {{ encadrants?.total ?? 0 }} supervisors
                        </p>
                    </div>

                    <form
                        class="m-0 max-md:w-full"
                        @submit.prevent="applySearch"
                    >
                        <SearchInput
                            v-model="search"
                            placeholder="Search supervisors..."
                        />
                    </form>
                </div>

                <!-- ========================= -->
                <!-- TABLE -->
                <!-- ========================= -->

                <div
                    class="w-full overflow-x-auto rounded-[10px]
                           border border-[#e8eef2]"
                >
                    <table
                        class="w-full min-w-[1050px]
                               border-collapse bg-white"
                    >

                        <!-- TABLE HEAD -->

                        <thead class="bg-[#f8fafb]">
                            <tr>
                                <th
                                    class="whitespace-nowrap border-b
                                           border-[#e5ebef]
                                           px-[14px] py-[13px]
                                           text-left text-[10px]
                                           font-bold uppercase
                                           tracking-[0.03em]
                                           text-[#738795]"
                                >
                                    Name
                                </th>

                                <th
                                    class="whitespace-nowrap border-b
                                           border-[#e5ebef]
                                           px-[14px] py-[13px]
                                           text-left text-[10px]
                                           font-bold uppercase
                                           tracking-[0.03em]
                                           text-[#738795]"
                                >
                                    Company
                                </th>

                                <th
                                    class="whitespace-nowrap border-b
                                           border-[#e5ebef]
                                           px-[14px] py-[13px]
                                           text-left text-[10px]
                                           font-bold uppercase
                                           tracking-[0.03em]
                                           text-[#738795]"
                                >
                                    Position
                                </th>

                                <th
                                    class="whitespace-nowrap border-b
                                           border-[#e5ebef]
                                           px-[14px] py-[13px]
                                           text-left text-[10px]
                                           font-bold uppercase
                                           tracking-[0.03em]
                                           text-[#738795]"
                                >
                                    Specialty
                                </th>

                                <th
                                    class="whitespace-nowrap border-b
                                           border-[#e5ebef]
                                           px-[14px] py-[13px]
                                           text-left text-[10px]
                                           font-bold uppercase
                                           tracking-[0.03em]
                                           text-[#738795]"
                                >
                                    Department
                                </th>

                                <th
                                    class="whitespace-nowrap border-b
                                           border-[#e5ebef]
                                           px-[14px] py-[13px]
                                           text-left text-[10px]
                                           font-bold uppercase
                                           tracking-[0.03em]
                                           text-[#738795]"
                                >
                                    Interns Assigned
                                </th>

                                <th
                                    class="whitespace-nowrap border-b
                                           border-[#e5ebef]
                                           px-[14px] py-[13px]
                                           text-left text-[10px]
                                           font-bold uppercase
                                           tracking-[0.03em]
                                           text-[#738795]"
                                >
                                    Status
                                </th>

                                <th
                                    class="whitespace-nowrap border-b
                                           border-[#e5ebef]
                                           px-[14px] py-[13px]
                                           text-left text-[10px]
                                           font-bold uppercase
                                           tracking-[0.03em]
                                           text-[#738795]"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <!-- TABLE BODY -->

                        <tbody>

                            <tr
                                v-for="supervisor in encadrants?.data ?? []"
                                :key="supervisor.user_id"
                                class="transition-colors
                                       hover:bg-[#fafcfd]"
                            >

                                <!-- USER -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[14px] py-[15px]
                                           align-middle text-[11px]
                                           text-[#40596a]"
                                >
                                    <div
                                        class="flex min-w-[190px]
                                               items-center gap-[11px]"
                                    >
                                        <UserAvatar
                                            :name="supervisor.user?.nom_complet"
                                            :photo="supervisor.user?.photo"
                                            :size="36"
                                        />

                                        <div class="min-w-0">

                                            <strong
                                                class="mb-[3px] block
                                                       max-w-[180px]
                                                       overflow-hidden
                                                       text-ellipsis
                                                       whitespace-nowrap
                                                       text-[11px]
                                                       font-bold
                                                       text-[#263f50]"
                                            >
                                                {{
                                                    supervisor.user?.nom_complet
                                                    ?? 'Unnamed supervisor'
                                                }}
                                            </strong>

                                            <span
                                                class="block max-w-[180px]
                                                       overflow-hidden
                                                       text-ellipsis
                                                       whitespace-nowrap
                                                       text-[9px]
                                                       text-[#8d9ca7]"
                                            >
                                                {{
                                                    supervisor.user?.email
                                                    ?? 'No email'
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- COMPANY -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[14px] py-[15px]
                                           align-middle text-[11px]
                                           text-[#40596a]"
                                >
                                    {{
                                        supervisor.entreprise
                                            ?.user
                                            ?.nom_complet
                                        ?? 'Not assigned'
                                    }}
                                </td>

                                <!-- POSITION -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[14px] py-[15px]
                                           align-middle text-[11px]
                                           text-[#40596a]"
                                >
                                    {{
                                        supervisor.poste
                                        || 'Not specified'
                                    }}
                                </td>

                                <!-- SPECIALTY -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[14px] py-[15px]
                                           align-middle text-[11px]
                                           text-[#40596a]"
                                >
                                    {{
                                        supervisor.specialite
                                        || 'Not specified'
                                    }}
                                </td>

                                <!-- DEPARTMENT -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[14px] py-[15px]
                                           align-middle text-[11px]
                                           text-[#40596a]"
                                >
                                    {{
                                        supervisor.departement
                                        || 'Not specified'
                                    }}
                                </td>

                                <!-- INTERNS -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[14px] py-[15px]
                                           align-middle"
                                >
                                    <span
                                        class="inline-flex h-7 min-w-[30px]
                                               items-center justify-center
                                               rounded-[7px]
                                               bg-[#edf4f8]
                                               px-2 text-[10px]
                                               font-bold text-[#356d8b]"
                                    >
                                        {{
                                            supervisor.stages_count
                                            ?? 0
                                        }}
                                    </span>
                                </td>

                                <!-- STATUS -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[14px] py-[15px]
                                           align-middle"
                                >
                                    <StatusBadge
                                        :status="supervisor.user?.etat"
                                    />
                                </td>

                                <!-- ACTIONS -->

                                <td
                                    class="border-b border-[#edf1f4]
                                           px-[14px] py-[15px]
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
                                                    'admin.encadrants.show',
                                                    supervisor.user_id
                                                )
                                            "
                                            class="inline-flex min-h-[30px]
                                                   items-center justify-center
                                                   rounded-md border
                                                   border-[#dce5eb]
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

                                        <!-- EDIT -->

                                        <Link
                                            :href="
                                                route(
                                                    'admin.encadrants.edit',
                                                    supervisor.user_id
                                                )
                                            "
                                            class="inline-flex min-h-[30px]
                                                   items-center justify-center
                                                   rounded-md border
                                                   border-[#dce5eb]
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

                                        <!-- DELETE -->

                                        <button
                                            type="button"
                                            class="inline-flex min-h-[30px]
                                                   items-center justify-center
                                                   rounded-md border
                                                   border-[#f0cccc]
                                                   bg-white px-[10px]
                                                   text-[9px] font-semibold
                                                   text-[#c95858]
                                                   transition
                                                   hover:border-[#e7aaaa]
                                                   hover:bg-[#fff4f4]
                                                   hover:text-[#b83e3e]"
                                            @click="
                                                deleteEncadrant(
                                                    supervisor.user_id
                                                )
                                            "
                                        >
                                            Delete
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            <!-- EMPTY -->

                            <tr v-if="!(encadrants?.data?.length)">
                                <td
                                    colspan="8"
                                    class="bg-white px-5 py-[55px]
                                           text-center text-[11px]
                                           text-[#92a1ac]"
                                >
                                    No supervisors found.
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- ========================= -->
                <!-- PAGINATION -->
                <!-- ========================= -->

                <div
                    v-if="encadrants?.links?.length > 3"
                    class="flex items-center justify-between
                           gap-[15px] pt-[18px]
                           max-sm:flex-col"
                >
                    <div class="text-[9px] text-[#8a9ba7]">
                        Showing

                        <strong>
                            {{ encadrants.from ?? 0 }}
                        </strong>

                        –

                        <strong>
                            {{ encadrants.to ?? 0 }}
                        </strong>

                        of

                        <strong>
                            {{ encadrants.total ?? 0 }}
                        </strong>
                    </div>

                    <div class="flex gap-1">
                        <button
                            v-for="link in encadrants.links"
                            :key="link.label"
                            type="button"
                            :disabled="!link.url"
                            class="h-[29px] min-w-[29px]
                                   rounded-md border
                                   border-[#dce5eb]
                                   bg-white px-2
                                   text-[9px] text-[#647b8b]
                                   transition
                                   hover:bg-[#f4f8fa]
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

            </div>
        </div>
    </AdminLayout>
</template>
