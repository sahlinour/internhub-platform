<script setup>
import { Head, Link } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

defineProps({
    entreprise: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <Head title="Company Details" />

    <AdminLayout>
        <div class="w-full max-w-[1050px]">

            <!-- HEADER -->
            <header
                class="mb-5 flex items-start justify-between gap-5
                       max-[700px]:flex-col"
            >
                <div>
                    <div
                        class="mb-2 flex items-center gap-[7px]
                               text-[9px] text-[#96a5af]"
                    >
                        <Link
                            :href="route('admin.entreprises.index')"
                            class="text-[#367594] no-underline hover:underline"
                        >
                            Companies
                        </Link>

                        <span>/</span>
                        <span>Details</span>
                    </div>

                    <h1
                        class="mb-[5px] text-[22px]
                               font-bold text-[#20394b]"
                    >
                        Company Details
                    </h1>

                    <p class="m-0 text-[10px] text-[#8798a6]">
                        View company information and account details.
                    </p>
                </div>

                <Link
                    :href="route('admin.entreprises.edit', entreprise.id)"
                    class="inline-flex min-h-[39px]
                           items-center justify-center
                           rounded-lg bg-[#174966]
                           px-[15px]
                           text-[10px] font-bold text-white
                           no-underline transition
                           hover:bg-[#123e57]"
                >
                    Edit Company
                </Link>
            </header>

            <DashboardCard>

                <!-- COMPANY HEADER -->
                <div
                    class="mb-5 flex items-center gap-4
                           border-b border-[#edf1f4]
                           pb-5"
                >
                    <UserAvatar
                        :name="entreprise.nom_complet"
                        :photo="entreprise.photo"
                        :size="72"
                    />

                    <div>
                        <h2
                            class="mb-1 text-[16px]
                                   font-bold text-[#294355]"
                        >
                            {{
                                entreprise.nom_complet
                                ?? 'Unnamed company'
                            }}
                        </h2>

                        <p
                            class="mb-2 text-[10px]
                                   text-[#8798a6]"
                        >
                            {{
                                entreprise.email
                                ?? 'No email'
                            }}
                        </p>

                        <StatusBadge
                            :status="entreprise.etat"
                        />
                    </div>
                </div>

                <!-- DETAILS GRID -->
                <div
                    class="grid grid-cols-2 gap-[18px]
                           max-[700px]:grid-cols-1"
                >

                    <!-- PHONE -->
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[9px] text-[#8a9aa6]">
                            Phone
                        </span>

                        <strong
                            class="text-[11px] font-semibold
                                   text-[#40596a]"
                        >
                            {{
                                entreprise.telephone
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <!-- CITY -->
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[9px] text-[#8a9aa6]">
                            City
                        </span>

                        <strong
                            class="text-[11px] font-semibold
                                   text-[#40596a]"
                        >
                            {{
                                entreprise.ville?.nom
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <!-- SECTOR -->
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[9px] text-[#8a9aa6]">
                            Sector
                        </span>

                        <strong
                            class="text-[11px] font-semibold
                                   text-[#40596a]"
                        >
                            {{
                                entreprise.entreprise?.secteur
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <!-- ADDRESS -->
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[9px] text-[#8a9aa6]">
                            Address
                        </span>

                        <strong
                            class="text-[11px] font-semibold
                                   text-[#40596a]"
                        >
                            {{
                                entreprise.entreprise?.adresse
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <!-- WEBSITE -->
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[9px] text-[#8a9aa6]">
                            Website
                        </span>

                        <a
                            v-if="entreprise.entreprise?.site_web"
                            :href="entreprise.entreprise.site_web"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="break-all text-[11px]
                                   font-semibold text-[#367594]
                                   no-underline hover:underline"
                        >
                            {{ entreprise.entreprise.site_web }}
                        </a>

                        <strong
                            v-else
                            class="text-[11px] font-semibold
                                   text-[#40596a]"
                        >
                            Not specified
                        </strong>
                    </div>

                    <!-- STATUS -->
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[9px] text-[#8a9aa6]">
                            Status
                        </span>

                        <div>
                            <StatusBadge
                                :status="entreprise.etat"
                            />
                        </div>
                    </div>

                </div>

                <!-- DESCRIPTION -->
                <div
                    class="mt-[25px]
                           border-t border-[#edf1f4]
                           pt-5"
                >
                    <h3
                        class="mb-2 text-[13px]
                               font-bold text-[#294355]"
                    >
                        Description
                    </h3>

                    <p
                        class="m-0 text-[10px]
                               leading-[1.6] text-[#607887]"
                    >
                        {{
                            entreprise.entreprise?.description
                            ?? 'No description available.'
                        }}
                    </p>
                </div>

            </DashboardCard>

        </div>
    </AdminLayout>
</template>
