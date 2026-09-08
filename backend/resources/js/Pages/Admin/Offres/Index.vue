<script setup>
import { computed, ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import SearchInput from '@/Components/Admin/SearchInput.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    offres: {
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

/* =========================
   STATISTICS
========================= */

const stats = computed(() => {
    const offers = props.offres?.data ?? []

    return [
        {
            label: 'Total Offers',
            value: props.offres?.total ?? 0,
            detail: 'Published internship offers',
            icon: 'briefcase',
        },
        {
            label: 'Active',
            value: offers.filter(
                offer => offer.statut?.toLowerCase() === 'active'
            ).length,
            detail: 'Currently active offers',
            icon: 'check',
        },
        {
            label: 'Other Status',
            value: offers.filter(
                offer => offer.statut?.toLowerCase() !== 'active'
            ).length,
            detail: 'Inactive or closed offers',
            icon: 'alert',
        },
    ]
})

/* =========================
   SEARCH
========================= */

const searchOffers = () => {
    router.get(
        route('admin.offres.index'),
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
        route('admin.offres.index'),
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
        return 'Not specified'
    }

    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}

const companyName = (offer) => {
    return offer?.entreprise?.user?.nom_complet ?? 'Unknown company'
}

/* =========================
   DELETE
========================= */

const deleteOffer = (offer) => {
    const title = offer?.titre ?? 'this internship offer'

    if (
        !window.confirm(
            `Are you sure you want to delete "${title}"?`
        )
    ) {
        return
    }

    router.delete(
        route('admin.offres.destroy', offer.id),
        {
            preserveScroll: true,
        }
    )
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
    <Head title="Internship Offers" />

    <AdminLayout>
        <div class="w-full">

            <!-- =========================
                 HEADER
            ========================== -->
            <header
                class="mb-5 flex items-center
                       justify-between gap-5
                       max-[700px]:flex-col
                       max-[700px]:items-stretch"
            >
                <div>
                    <h1
                        class="mb-[5px]
                               text-[22px] font-bold
                               text-[#20394b]"
                    >
                        Internship Offers
                    </h1>

                    <p
                        class="m-0 text-[11px]
                               text-[#8798a6]"
                    >
                        View and manage internship opportunities
                        published by partner companies.
                    </p>
                </div>

                <Link
                    :href="route('admin.offres.create')"
                    class="inline-flex min-h-10
                           items-center justify-center gap-2
                           rounded-lg
                           bg-[#174966] px-4
                           text-[10px] font-semibold
                           text-white no-underline
                           shadow-[0_4px_12px_rgba(23,73,102,0.14)]
                           transition
                           hover:-translate-y-px
                           hover:bg-[#123e57]
                           hover:shadow-[0_6px_16px_rgba(23,73,102,0.18)]
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

                    Post Internship Offer
                </Link>
            </header>

            <!-- =========================
                 STATS
            ========================== -->
            <section
                class="mb-[18px]
                       grid grid-cols-3 gap-[14px]
                       max-[1000px]:grid-cols-2
                       max-[700px]:grid-cols-1"
            >
                <StatCard
                    v-for="stat in stats"
                    :key="stat.label"
                    v-bind="stat"
                    class="min-w-0"
                />
            </section>

            <!-- =========================
                 OFFERS
            ========================== -->
            <DashboardCard>

                <!-- TOOLBAR -->
                <div
                    class="mb-5 flex items-center
                           justify-between gap-5
                           max-[700px]:flex-col
                           max-[700px]:items-stretch"
                >
                    <div>
                        <h2
                            class="mb-1 text-[14px]
                                   font-bold text-[#294355]"
                        >
                            Current Internship Offers
                        </h2>

                        <p
                            class="m-0 text-[10px]
                                   text-[#8f9faa]"
                        >
                            {{ offres.total ?? 0 }} internship offers
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-2
                               max-[700px]:w-full"
                    >
                        <SearchInput
                            v-model="search"
                            placeholder="Search internship offers..."
                            @search="searchOffers"
                        />

                        <button
                            v-if="search"
                            type="button"
                            class="h-[38px]
                                   rounded-lg
                                   border border-[#dce5eb]
                                   bg-white px-3
                                   text-[9px] font-semibold
                                   text-[#657d8d]
                                   transition
                                   hover:bg-[#f7fafb]"
                            @click="clearSearch"
                        >
                            Clear
                        </button>
                    </div>
                </div>

                <!-- =========================
                     TABLE
                ========================== -->
                <div
                    v-if="offres.data?.length"
                    class="w-full overflow-x-auto"
                >
                    <table
                        class="w-full
                               min-w-[950px]
                               border-collapse"
                    >
                        <thead class="bg-[#f8fafb]">
                            <tr>
                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e6ecef]
                                           px-3 py-[13px]
                                           text-left text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Offer
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e6ecef]
                                           px-3 py-[13px]
                                           text-left text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Company
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e6ecef]
                                           px-3 py-[13px]
                                           text-left text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Duration
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e6ecef]
                                           px-3 py-[13px]
                                           text-left text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Deadline
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e6ecef]
                                           px-3 py-[13px]
                                           text-left text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Status
                                </th>

                                <th
                                    class="whitespace-nowrap
                                           border-y border-[#e6ecef]
                                           px-3 py-[13px]
                                           text-right text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="offer in offres.data"
                                :key="offer.id"
                                class="transition-colors
                                       hover:bg-[#fafcfd]"
                            >
                                <!-- OFFER -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-3 py-[15px]
                                           align-middle"
                                >
                                    <div
                                        class="flex min-w-[260px]
                                               items-center gap-[11px]"
                                    >
                                        <div
                                            class="flex h-9 w-9
                                                   shrink-0
                                                   items-center
                                                   justify-center
                                                   rounded-[9px]
                                                   bg-[#edf4f8]
                                                   text-[#39718f]"
                                        >
                                            <svg
                                                viewBox="0 0 24 24"
                                                width="17"
                                                height="17"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <rect
                                                    x="3"
                                                    y="7"
                                                    width="18"
                                                    height="13"
                                                    rx="2"
                                                />

                                                <path
                                                    d="M8 7V5a2 2 0 0 1
                                                       2-2h4a2 2 0 0 1
                                                       2 2v2"
                                                />

                                                <path d="M3 12h18" />
                                            </svg>
                                        </div>

                                        <div class="min-w-0">
                                            <strong
                                                class="mb-1 block
                                                       max-w-[280px]
                                                       overflow-hidden
                                                       text-ellipsis
                                                       whitespace-nowrap
                                                       text-[11px]
                                                       font-bold
                                                       text-[#263f50]"
                                            >
                                                {{
                                                    offer.titre
                                                    || 'Untitled offer'
                                                }}
                                            </strong>

                                            <span
                                                class="block max-w-[300px]
                                                       overflow-hidden
                                                       text-ellipsis
                                                       whitespace-nowrap
                                                       text-[9px]
                                                       text-[#8d9ca7]"
                                            >
                                                {{
                                                    offer.description
                                                    || 'No description'
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- COMPANY -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-3 py-[15px]
                                           align-middle"
                                >
                                    <div
                                        class="flex min-w-[170px]
                                               items-center gap-[9px]"
                                    >
                                        <UserAvatar
                                            :name="companyName(offer)"
                                            :photo="
                                                offer.entreprise
                                                    ?.user
                                                    ?.photo
                                            "
                                            :size="32"
                                        />

                                        <span
                                            class="text-[10px]
                                                   font-semibold
                                                   text-[#40596a]"
                                        >
                                            {{ companyName(offer) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- DURATION -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-3 py-[15px]
                                           align-middle"
                                >
                                    <span
                                        class="inline-flex
                                               whitespace-nowrap
                                               rounded-md
                                               bg-[#f0f5f8]
                                               px-[9px] py-[5px]
                                               text-[9px]
                                               font-semibold
                                               text-[#52758a]"
                                    >
                                        {{
                                            offer.duree
                                            || 'Not specified'
                                        }}
                                    </span>
                                </td>

                                <!-- DEADLINE -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-3 py-[15px]
                                           align-middle
                                           text-[10px]
                                           text-[#40596a]"
                                >
                                    {{ formatDate(offer.date_limite) }}
                                </td>

                                <!-- STATUS -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-3 py-[15px]
                                           align-middle"
                                >
                                    <StatusBadge
                                        :status="offer.statut"
                                    />
                                </td>

                                <!-- ACTIONS -->
                                <td
                                    class="border-b
                                           border-[#edf1f4]
                                           px-3 py-[15px]
                                           align-middle"
                                >
                                    <div
                                        class="flex items-center
                                               justify-end gap-1.5
                                               whitespace-nowrap"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'admin.offres.show',
                                                    offer.id
                                                )
                                            "
                                            class="inline-flex
                                                   min-h-[30px]
                                                   items-center
                                                   justify-center
                                                   rounded-md
                                                   border
                                                   border-[#dce5eb]
                                                   bg-white
                                                   px-[10px]
                                                   text-[9px]
                                                   font-semibold
                                                   text-[#536f80]
                                                   no-underline
                                                   transition
                                                   hover:border-[#bfd0da]
                                                   hover:bg-[#f4f8fa]
                                                   hover:text-[#174966]"
                                        >
                                            View
                                        </Link>

                                        <button
                                            type="button"
                                            class="inline-flex
                                                   min-h-[30px]
                                                   cursor-pointer
                                                   items-center
                                                   justify-center
                                                   rounded-md
                                                   border
                                                   border-[#f0cccc]
                                                   bg-white
                                                   px-[10px]
                                                   text-[9px]
                                                   font-semibold
                                                   text-[#c95858]
                                                   transition
                                                   hover:border-[#e7aaaa]
                                                   hover:bg-[#fff4f4]
                                                   hover:text-[#b83e3e]"
                                            @click="deleteOffer(offer)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- =========================
                     EMPTY STATE
                ========================== -->
                <div
                    v-else
                    class="flex flex-col
                           items-center
                           px-5 py-[60px]
                           text-center"
                >
                    <div
                        class="mb-3 flex
                               h-[54px] w-[54px]
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
                            <rect
                                x="3"
                                y="7"
                                width="18"
                                height="13"
                                rx="2"
                            />

                            <path
                                d="M8 7V5a2 2 0 0 1
                                   2-2h4a2 2 0 0 1
                                   2 2v2"
                            />
                        </svg>
                    </div>

                    <h3
                        class="mb-[5px]
                               text-[13px]
                               font-bold
                               text-[#334f61]"
                    >
                        No internship offers found
                    </h3>

                    <p
                        class="m-0 max-w-[400px]
                               text-[10px]
                               text-[#92a1ac]"
                    >
                        There are currently no internship offers
                        matching your search.
                    </p>

                    <div
                        class="mt-4 flex items-center
                               justify-center gap-2
                               max-[500px]:flex-col"
                    >
                        <button
                            v-if="search"
                            type="button"
                            class="inline-flex
                                   min-h-[36px]
                                   items-center justify-center
                                   rounded-lg
                                   border border-[#dce5eb]
                                   bg-white px-4
                                   text-[9px]
                                   font-semibold
                                   text-[#617888]
                                   transition
                                   hover:bg-[#f8fafb]"
                            @click="clearSearch"
                        >
                            Clear Search
                        </button>

                        <Link
                            :href="route('admin.offres.create')"
                            class="inline-flex
                                   min-h-[36px]
                                   items-center justify-center
                                   rounded-lg
                                   bg-[#174966] px-4
                                   text-[9px]
                                   font-semibold
                                   text-white
                                   no-underline
                                   transition
                                   hover:bg-[#123e57]"
                        >
                            Post Internship Offer
                        </Link>
                    </div>
                </div>

                <!-- =========================
                     PAGINATION
                ========================== -->
                <div
                    v-if="offres.links?.length > 3"
                    class="flex items-center
                           justify-between gap-4
                           pt-5
                           max-[700px]:flex-col
                           max-[700px]:items-start"
                >
                    <p
                        class="m-0 text-[9px]
                               text-[#8a9ba7]"
                    >
                        Showing

                        <strong class="text-[#4b6475]">
                            {{ offres.from ?? 0 }}
                        </strong>

                        –

                        <strong class="text-[#4b6475]">
                            {{ offres.to ?? 0 }}
                        </strong>

                        of

                        <strong class="text-[#4b6475]">
                            {{ offres.total ?? 0 }}
                        </strong>
                    </p>

                    <div class="flex flex-wrap gap-1">
                        <button
                            v-for="link in offres.links"
                            :key="link.label"
                            type="button"
                            :disabled="!link.url"
                            class="h-[29px]
                                   min-w-[29px]
                                   rounded-md
                                   border border-[#dce5eb]
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
                            @click="goToPage(link.url)"
                            v-html="link.label"
                        />
                    </div>
                </div>

            </DashboardCard>
        </div>
    </AdminLayout>
</template>
