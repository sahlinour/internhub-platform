<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import SearchInput from '@/Components/Admin/SearchInput.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'

const props = defineProps({
    offres: {
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

const searchApplications = () => {
    router.get(
        route('admin.candidatures.index'),
        {
            search: search.value || undefined,
        },
        {
            preserveState: true,
            replace: true,
        }
    )
}

const companyName = (offer) => {
    return (
        offer?.entreprise?.user?.nom_complet
        ?? 'Unknown company'
    )
}
</script>

<template>
    <Head title="Applications" />

    <AdminLayout>
        <div class="w-full">

            <!-- PAGE HEADER -->
            <header class="mb-5">
                <h1 class="mb-[5px] text-[22px] font-bold text-[#20394b]">
                    Applications
                </h1>

                <p class="m-0 text-[11px] text-[#8798a6]">
                    Review applications submitted for internship offers.
                </p>
            </header>

            <DashboardCard>

                <!-- TABLE TOOLBAR -->
                <div
                    class="mb-5 flex items-center justify-between gap-5
                           max-[700px]:flex-col max-[700px]:items-stretch"
                >
                    <div>
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Applications by Internship Offer
                        </h2>

                        <p class="m-0 text-[10px] text-[#8f9faa]">
                            {{ offres.total ?? 0 }} internship offers
                        </p>
                    </div>

                    <SearchInput
                        v-model="search"
                        placeholder="Search offers..."
                        @search="searchApplications"
                    />
                </div>

                <!-- TABLE -->
                <div
                    v-if="offres.data?.length"
                    class="w-full overflow-x-auto"
                >
                    <table class="w-full border-collapse">

                        <thead class="bg-[#f8fafb]">
                            <tr>
                                <th
                                    class="whitespace-nowrap border-y border-[#e6ecef]
                                           px-3 py-[13px] text-left text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Internship Offer
                                </th>

                                <th
                                    class="whitespace-nowrap border-y border-[#e6ecef]
                                           px-3 py-[13px] text-left text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Company
                                </th>

                                <th
                                    class="whitespace-nowrap border-y border-[#e6ecef]
                                           px-3 py-[13px] text-left text-[10px]
                                           font-bold text-[#768997]"
                                >
                                    Applications
                                </th>

                                <th
                                    class="whitespace-nowrap border-y border-[#e6ecef]
                                           px-3 py-[13px]"
                                ></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="offer in offres.data"
                                :key="offer.id"
                                class="transition hover:bg-[#fafcfd]"
                            >
                                <!-- OFFER -->
                                <td
                                    class="border-b border-[#edf1f4]
                                           px-3 py-[15px] align-middle
                                           text-[11px] text-[#40596a]"
                                >
                                    <div
                                        class="flex min-w-[260px] items-center gap-[11px]"
                                    >
                                        <div
                                            class="flex h-9 w-9 shrink-0
                                                   items-center justify-center
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
                                                    d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                                                />

                                                <path d="M3 12h18" />
                                            </svg>
                                        </div>

                                        <div class="min-w-0">
                                            <strong
                                                class="mb-1 block text-[11px]
                                                       font-bold text-[#263f50]"
                                            >
                                                {{
                                                    offer.titre
                                                    ?? 'Untitled offer'
                                                }}
                                            </strong>

                                            <span
                                                class="block max-w-[280px]
                                                       overflow-hidden
                                                       text-ellipsis
                                                       whitespace-nowrap
                                                       text-[9px]
                                                       text-[#8d9ca7]"
                                            >
                                                {{
                                                    offer.description
                                                    ?? 'No description'
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- COMPANY -->
                                <td
                                    class="border-b border-[#edf1f4]
                                           px-3 py-[15px] align-middle"
                                >
                                    <div
                                        class="flex min-w-[190px]
                                               items-center gap-[9px]"
                                    >
                                        <UserAvatar
                                            :name="companyName(offer)"
                                            :photo="offer.entreprise?.user?.photo"
                                            :size="34"
                                        />

                                        <div>
                                            <strong
                                                class="mb-[3px] block
                                                       text-[10px] font-bold
                                                       text-[#40596a]"
                                            >
                                                {{ companyName(offer) }}
                                            </strong>

                                            <span
                                                class="text-[9px] text-[#94a2ac]"
                                            >
                                                {{
                                                    offer.entreprise
                                                        ?.user
                                                        ?.email
                                                    ?? 'No email'
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- APPLICATION COUNT -->
                                <td
                                    class="border-b border-[#edf1f4]
                                           px-3 py-[15px] align-middle"
                                >
                                    <span
                                        class="inline-flex h-7 min-w-8
                                               items-center justify-center
                                               rounded-[7px]
                                               bg-[#e8f2f7]
                                               px-[9px]
                                               text-[10px] font-bold
                                               text-[#326c8a]"
                                    >
                                        {{
                                            offer.candidatures_count
                                            ?? 0
                                        }}
                                    </span>
                                </td>

                                <!-- ACTION -->
                                <td
                                    class="border-b border-[#edf1f4]
                                           px-3 py-[15px]
                                           text-right align-middle"
                                >
                                    <Link
                                        :href="
                                            route(
                                                'admin.candidatures.byOffer',
                                                offer.id
                                            )
                                        "
                                        class="inline-flex min-h-[34px]
                                               items-center justify-center
                                               whitespace-nowrap
                                               rounded-[7px]
                                               border border-[#d8e4ea]
                                               bg-white px-[11px]
                                               text-[9px] font-bold
                                               text-[#356d8b]
                                               no-underline transition
                                               hover:bg-[#f2f7fa]"
                                    >
                                        View Applications
                                    </Link>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <!-- EMPTY STATE -->
                <div
                    v-else
                    class="px-5 py-[55px] text-center"
                >
                    <h3
                        class="mb-[5px] text-[13px]
                               font-semibold text-[#334f61]"
                    >
                        No applications found
                    </h3>

                    <p class="m-0 text-[10px] text-[#92a1ac]">
                        There are currently no internship offers to display.
                    </p>
                </div>

            </DashboardCard>

        </div>
    </AdminLayout>
</template>
